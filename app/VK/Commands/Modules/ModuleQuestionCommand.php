<?php

namespace App\VK\Commands\Modules;

use App\Models\Module;
use App\Models\ModuleAnswer;
use App\Models\ModuleAttempts;
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
        $attempt = null;

        if (!empty($payload->data->last_question)) {
            $question = ModuleQuestion::find($payload->data->last_question->id);
            $answer = ModuleAnswer::find($payload->data->last_question->answer);

            $attempt_id = $payload->data->attempt_id ?? null;

            $attempt = ModuleAttempts::find($attempt_id);

            if (empty($attempt)) {
                $module = $question->module;
                $attempt = ModuleAttempts::query()->create([
                    'user_id' => $user_id,
                    'module_id' => $module->id,
                    'total_scores' => $module->questions->count(),
                ]);
            }

            $attempt->answers()->attach($answer->id);

            if ($answer->is_correct) {
                $attempt->scores++;
                $attempt->save();
            }
        }

        $remaining_question_ids = $payload->data->remaining_questions;

        if (empty($remaining_question_ids)) {

            if ($attempt) {
                $message = $this->getResultMessage($attempt);
            } else {
                $message = "Позже здесь будет результат тестирования";
            }

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
                        ],
                        'attempt_id' => $attempt->id ?? null,
                    ]
                ]),
            )];
        }

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, true, false));
    }

    private function getResultMessage(ModuleAttempts $attempt): string
    {
        $message = "Ваш результат " . $attempt->scores . "/" . $attempt->total_scores . "\n\n";

        $module = $attempt->module()->first();
        $questions = $module->questions()->get();

        $attempt_answer_ids = $attempt->answers()->get()->pluck('id')->toArray();

        foreach ($questions as $question) {
            $message .= $question->question . "\n";
            $answers = $question->answers()->get();
            foreach ($answers as $answer) {
                $message .= " - " . $answer->value;
                if (in_array($answer->id, $attempt_answer_ids)) {
                    if ($answer->is_correct) {
                        $message .= "✅\n";
                    } else {
                        $message .= "❌\n";
                    }
                } else {
                    $message .= "\n";
                }
            }
            $message .= "ℹ️ " . $question->explanation . "\n\n";
        }

        return $message;
    }
}
