<?php

namespace App\VK\Commands;

use App\VK\DTO\ButtonDTO;
use App\VK\DTO\KeyboardDTO;
use Illuminate\Http\Client\ConnectionException;

class PracticesCommand extends Command
{
    protected string $name = 'practices';
    protected string $value = 'Журнал практики';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        $message = "Статистика:\n\n";
        $message .= "Всего сессий:". null . "\n";
        $message .= "Средн. снижение стресса:". null . "\n";
        $message .= "Средн. уровень до:". null . "\n";
        $message .= "Средн. уровень после:". null . "\n";

        $message .= "\n\n";

        $buttons = [
            [new ButtonDTO(
                label: 'Записать новую сессию',
                payload: json_encode(['command' => 'practice_add']),
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
