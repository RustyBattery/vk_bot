<?php

namespace App\VK\Commands\Diary;

use App\Models\Entry;
use App\Models\Module;
use App\VK\Commands\Command;
use App\VK\DTO\ButtonDTO;
use App\VK\DTO\KeyboardDTO;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;

class DiaryAddCommand extends Command
{
    protected string $name = 'diary_add';
    protected string $value = '';

    const string STEP_SELECT_MODULE = 'select_module';
    const string STEP_SAVE_MODULE = 'save_module';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        $step = $payload->data->step ?? null;

        if ($step == self::STEP_SELECT_MODULE) {
            $this->select_module($user_id);
        }

        if ($step == self::STEP_SAVE_MODULE) {
            $this->save_module($user_id, $payload->data->module_id);
        }

    }


    private function select_module(int $user_id): void
    {
        $message = "Выберите модуль:\n\n";

        $buttons = [];
        $modules = Module::all();

        foreach ($modules as $module) {
            $label = $module->id . '. ' . $module->title;
            if (mb_strlen($label) > 40) {
                $label = mb_substr($label, 0, 37) . '...';
            }

            $buttons[] = [new ButtonDTO(
                label: $label,
                payload: json_encode([
                    'command' => 'diary_add',
                    'data' => [
                        'step' => self::STEP_SAVE_MODULE,
                        'module_id' => $module->id,
                    ]
                ]),
            )];
        }

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, false, false));
    }

    private function save_module(int $user_id, int $module_id): void
    {
        $entry = Entry::query()->create([
            'user_id' => $user_id,
            'module_id' => $module_id,
        ]);

        $message = "Поделитесь своими мыслями и размышлениями о модуле. Что вы узнали? Какие эмоции вызвал этот модуль? Как вы планируете применить полученные знания?";

        $buttons = [
            [new ButtonDTO(
                label: 'Отмена',
                payload: json_encode(['command' => 'menu']),
            )],
        ];

        Cache::set('state-' . $user_id, 'waiting_entry-' . $entry->id, 3 * 60);

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, false, false));
    }

    public function add_text(int $user_id, int $entry_id, string $text): void
    {
        $entry = Entry::find($entry_id);

        if (!empty($entry)) {
            $entry->text = $text;
            $entry->save();
        }

        $message = "Запись успешно добавлена!";

        $buttons = [
            [new ButtonDTO(
                label: 'Отмена',
                payload: json_encode(['command' => 'menu']),
            )],
        ];

        Cache::delete('state-' . $user_id);

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, false, false));
    }
}
