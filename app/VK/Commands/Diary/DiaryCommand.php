<?php

namespace App\VK\Commands\Diary;

use App\VK\Commands\Command;
use App\VK\DTO\ButtonDTO;
use App\VK\DTO\KeyboardDTO;
use Illuminate\Http\Client\ConnectionException;

class DiaryCommand extends Command
{
    protected string $name = 'diary';
    protected string $value = 'Дневник размышлений';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        $message = "Записывайте свои мысли и чувства о пройденных модулях\n\n";

        $buttons = [
            [new ButtonDTO(
                label: 'Добавить запись',
                payload: json_encode(['command' => 'diary_add', 'data' => ['step' => DiaryAddCommand::STEP_SELECT_MODULE]]),
            )],
            [new ButtonDTO(
                label: 'Мои записи',
                payload: json_encode(['command' => 'diary_history']),
            )],
            [new ButtonDTO(
                label: 'Меню',
                payload: json_encode(['command' => 'menu']),
            )],
        ];

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, false, true));
    }
}
