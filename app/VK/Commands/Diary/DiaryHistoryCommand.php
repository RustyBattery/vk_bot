<?php

namespace App\VK\Commands\Diary;

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
        $message = "Ваши записи будет доступны позже\n\n";

        $buttons = [
            [new ButtonDTO(
                label: 'Меню',
                payload: json_encode(['command' => 'menu']),
            )],
        ];

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, false, false));
    }
}
