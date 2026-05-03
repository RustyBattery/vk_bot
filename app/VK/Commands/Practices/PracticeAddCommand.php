<?php

namespace App\VK\Commands\Practices;

use App\Models\Practice;
use App\Models\UserPractice;
use App\VK\Commands\Command;
use App\VK\DTO\ButtonDTO;
use App\VK\DTO\KeyboardDTO;
use Illuminate\Http\Client\ConnectionException;

class PracticeAddCommand extends Command
{
    protected string $name = 'practice_add';
    protected string $value = '';

    const string STEP_SELECT_TYPE = 'select_type';
    const string STEP_SAVE_TYPE = 'save_type';
    const string STEP_SAVE_STRESS_BEFORE = 'save_stress_before';
    const string STEP_SAVE_STRESS_AFTER = 'save_stress_after';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        $step = $payload->data->step ?? null;

        if ($step == self::STEP_SELECT_TYPE) {
            $this->select_type($user_id);
        }

        if ($step == self::STEP_SAVE_TYPE) {
            $this->save_type($user_id, $payload->data->practice_id);
        }

        if ($step == self::STEP_SAVE_STRESS_BEFORE) {
            $this->save_stress_before($user_id, $payload->data->practice_id, $payload->data->stress_before);
        }

        if ($step == self::STEP_SAVE_STRESS_AFTER) {
            $this->save_stress_after($user_id, $payload->data->practice_id, $payload->data->stress_after);
        }
    }

    private function select_type(int $user_id): void
    {
        $message = "Выберите технику:\n\n";

        $buttons = [];
        $types = Practice::all();

        foreach ($types as $type) {
            $buttons[] = [new ButtonDTO(
                label: $type->name,
                payload: json_encode([
                    'command' => 'practice_add',
                    'data' => [
                        'step' => self::STEP_SAVE_TYPE,
                        'practice_id' => $type->id,
                    ]
                ]),
            )];
        }

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, false, false));
    }

    private function save_type(int $user_id, int $practice_id): void
    {
        $practice = UserPractice::query()->create([
            'user_id' => $user_id,
            'practice_id' => $practice_id,
        ]);

        $message = "Уровень стресса до практики:\n\n";

        $buttons = [];

        for ($i = 1; $i <= 10; $i++) {
            $buttons[] = [new ButtonDTO(
                label: $i,
                payload: json_encode([
                    'command' => 'practice_add',
                    'data' => [
                        'step' => self::STEP_SAVE_STRESS_BEFORE,
                        'practice_id' => $practice->id,
                        'stress_before' => $i,
                    ]
                ]),
            )];
        }

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, false, false));
    }

    private function save_stress_before(int $user_id, int $practice_id, int $stress_before): void
    {
        $practice = UserPractice::query()->find($practice_id);
        $practice->stress_before = $stress_before;
        $practice->save();

        $message = "Уровень стресса после практики:\n\n";

        $buttons = [];

        for ($i = 1; $i <= 10; $i++) {
            $buttons[] = [new ButtonDTO(
                label: $i,
                payload: json_encode([
                    'command' => 'practice_add',
                    'data' => [
                        'step' => self::STEP_SAVE_STRESS_AFTER,
                        'practice_id' => $practice->id,
                        'stress_after' => $i,
                    ]
                ]),
            )];
        }

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, false, false));
    }

    private function save_stress_after(int $user_id, int $practice_id, int $stress_after): void
    {
        $practice = UserPractice::query()->find($practice_id);
        $practice->stress_after = $stress_after;
        $practice->save();

        $message = "Сессия успешно записана!\n\n";

        $buttons = [
            [new ButtonDTO(
                label: 'Меню',
                payload: json_encode(['command' => 'menu']),
            )],
        ];

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, false, false));
    }
}
