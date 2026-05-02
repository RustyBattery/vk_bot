<?php

namespace App\VK\Commands\Modules;

use App\Models\Module;
use App\Models\ModuleQuestion;
use App\VK\Commands\Command;
use App\VK\DTO\ButtonDTO;
use App\VK\DTO\KeyboardDTO;
use Illuminate\Http\Client\ConnectionException;

class ModuleQuestionCommand extends Command
{
    protected string $name = 'module_question';
    protected string $value = '';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        if (!empty($payload->data->last_question)) {
            // todo пишем в базу ответ пользователя
        }

        $remaining_question_ids = $payload->data->remaining_questions;

        if (empty($remaining_question_ids)) {
            // todo формируем результат тестирования

            $message = "Позже здесь будет результат тестирования";

            $buttons = [
                [new ButtonDTO(
                    label: 'Меню',
                    payload: json_encode(['command' => 'menu']),
                )],
            ];

            $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, true, false));

            return;
        }

        $question = ModuleQuestion::with('answers')->find(array_shift($remaining_question_ids));

        $answers = $question->answers->shuffle();

        $message = $question->question . "\n\n";
        $message .= "Варианты ответа:" . "\n";

        $buttons = [];

        foreach ($answers as $answer) {
            $message .= " - " . $answer->value . "\n";

            $label = $answer->value;
            if (mb_strlen($label) > 40) {
                $label = mb_substr($label, 0, 37) . '...';
            }

            $buttons[] = [new ButtonDTO(
                label: $label,
                payload: json_encode([
                    'command' => 'module_question',
                    'data' => [
                        'remaining_questions' => $remaining_question_ids,
                        'last_question' => [
                            'id' => $question->id,
                            'answer' => $answer->id
                        ]
                    ]
                ]),
            )];
        }

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, true, false));
    }
}
