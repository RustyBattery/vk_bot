<?php

namespace App\VK\Commands\Modules;

use App\Models\Module;
use App\VK\Commands\Command;
use App\VK\DTO\ButtonDTO;
use App\VK\DTO\KeyboardDTO;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;

class ModuleStartCommand extends Command
{
    protected string $name = 'module_start';
    protected string $value = '';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        $module = Module::with('questions')->find($payload->data->id);

        $message = "Начать тестирование \"" . $module->title . "\"?";

        $question_ids = $module->questions->pluck('id');

        Log::debug('question_ids', [$question_ids]);

        $buttons = [
            [new ButtonDTO(
                label: 'Да',
                payload: json_encode([
                    'command' => 'module_question',
                    'data' => [
                        'remaining_questions' => $question_ids,
                        'last_question' => null,
                    ]
                ]),
            )],
            [new ButtonDTO(
                label: 'Меню',
                payload: json_encode(['command' => 'menu']),
            )],
        ];

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, true, false));
    }
}
