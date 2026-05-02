<?php

namespace App\VK\Commands;

use App\VK\DTO\ButtonDTO;
use App\VK\DTO\KeyboardDTO;
use Illuminate\Http\Client\ConnectionException;

class MenuCommand extends Command
{
    protected string $name = 'menu';
    protected string $value = 'Меню';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        $buttons = [
            [new ButtonDTO(
                label: 'Образовательное руководство',
                payload: json_encode(['command' => 'materials']),
            )],
            [new ButtonDTO(
                label: 'Интерактивные модули',
                payload: json_encode(['command' => 'modules']),
            )],
            [new ButtonDTO(
                label: 'Мой прогресс',
                payload: json_encode(['command' => 'progress']),
            )],
            [new ButtonDTO(
                label: 'Журнал практики',
                payload: json_encode(['command' => 'practices']),
            )],
            [new ButtonDTO(
                label: 'Дневник размышлений',
                payload: json_encode(['command' => 'diary']),
            )],
        ];

        $this->messageService->send($user_id, 'Возможности бота:', new KeyboardDTO($buttons, false, true));
    }
}
