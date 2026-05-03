<?php

namespace App\VK\Commands\Diary;

use App\Models\Entry;
use App\VK\Commands\Command;
use App\VK\DTO\ButtonDTO;
use App\VK\DTO\KeyboardDTO;
use Illuminate\Http\Client\ConnectionException;

class DiaryHistoryCommand extends Command
{
    protected string $name = 'diary';
    protected string $value = 'diary_history';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        $message = "Ваши записи:\n\n";

        $entries = Entry::query()->where('user_id', $user_id)->get();

        foreach ($entries as $entry) {
            $entry->updated_at->format('j F Y \г. в H:i') . "\n";
            $message .= $entry->module->id . ". " . $entry->module->title . "\n";
            $message .= $entry->text . "\n\n";
        }

        $buttons = [
            [new ButtonDTO(
                label: 'Добавить запись',
                payload: json_encode(['command' => 'diary_add', 'data' => ['step' => DiaryAddCommand::STEP_SELECT_MODULE]]),
            )],
            [new ButtonDTO(
                label: 'Меню',
                payload: json_encode(['command' => 'menu']),
            )],
        ];

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, false, false));
    }
}
