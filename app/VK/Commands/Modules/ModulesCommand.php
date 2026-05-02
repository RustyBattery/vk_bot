<?php

namespace App\VK\Commands\Modules;

use App\Models\Module;
use App\VK\Commands\Command;
use App\VK\DTO\ButtonDTO;
use App\VK\DTO\KeyboardDTO;
use Illuminate\Http\Client\ConnectionException;

class ModulesCommand extends Command
{
    protected string $name = 'modules';
    protected string $value = 'Интерактивные модули';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        $message = "Проверьте своё понимание с помощью этих интерактивных модулей тестирования.\n";
        $message .= "Каждый модуль содержит вопросы с множественным выбором с немедленной обратной связью и объяснениями.\n\n";
        $message .= "Доступные модули:\n\n";

        $modules = Module::all();

        $buttons = [];

        foreach ($modules as $module) {
            $message .= $module->id . ". " . $module->title . "\n";
            $message .= $module->description . "\n\n";

            $label = $module->id . ". " . $module->title;
            if (mb_strlen($label) > 40) {
                $label = mb_substr($label, 0, 37) . '...';
            }

            $buttons[] = [new ButtonDTO(
                label: $label,
                payload: json_encode(['command' => 'start_test', 'data' => ['id' => $module->id]]),
            )];
        }

        $buttons[] = [new ButtonDTO(
            label: 'Меню',
            payload: json_encode(['command' => 'menu']),
        )];

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, true, false));
    }
}
