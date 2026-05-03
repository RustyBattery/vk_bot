<?php

namespace App\VK\Commands\Practices;

use App\Models\UserPractice;
use App\VK\Commands\Command;
use App\VK\DTO\ButtonDTO;
use App\VK\DTO\KeyboardDTO;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;

class PracticeHistoryCommand extends Command
{
    protected string $name = 'practice_history';
    protected string $value = '';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        $message = "Мои практики\n\n";

        $practices = UserPractice::where('user_id', $user_id)->get();

        Carbon::setLocale('ru');

        foreach ($practices as $practice) {
            $message .= $practice->practice->name . "\n";
            $message .= $practice->updated_at->translatedFormat('j F Y \г. в H:i') . "\n";
            $message .= "Уровень стресса до практики: " . $practice->stress_before. "/10\n";
            $message .= "Уровень стресса после практики: " . $practice->stress_after. "/10\n";
            $message .= "Снижение: " . $practice->stress_after - $practice->stress_before. "\n\n";
        }

        $buttons = [
            [new ButtonDTO(
                label: 'Записать новую сессию',
                payload: json_encode(['command' => 'practice_add', 'data' => ['step' => PracticeAddCommand::STEP_SELECT_TYPE]]),
            )],
            [new ButtonDTO(
                label: 'История практики',
                payload: json_encode(['command' => 'practice_history']),
            )],
            [new ButtonDTO(
                label: 'Меню',
                payload: json_encode(['command' => 'menu']),
            )],
        ];

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, false, false));
    }
}
