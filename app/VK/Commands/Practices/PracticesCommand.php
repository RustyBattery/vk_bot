<?php

namespace App\VK\Commands\Practices;

use App\Models\UserPractice;
use App\VK\Commands\Command;
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
        $message = "Статистика\n\n";

        $practices = UserPractice::where('user_id', $user_id)->get();
        $message .= "Всего сессий:  " . $practices->count() . "\n";

        $amountStressReduction = 0;
        $amountStressBefore = 0;
        $amountStressAfter = 0;

        foreach ($practices as $practice) {
            $amountStressReduction += $practice->stress_after - $practice->stress_before;
            $amountStressBefore += $practice->stress_before;
            $amountStressAfter += $practice->stress_after;
        }

        $averageStressReduction = $practices->count() ? (string) round($amountStressReduction / $practices->count(), 1) : "-";
        $averageStressBefore = $practices->count() ? (string) round($amountStressBefore / $practices->count(), 1) : "-";
        $averageStressAfter = $practices->count() ? (string) round($amountStressAfter / $practices->count(), 1) : "-";

        $message .= "Средн. снижение стресса:  " . -$averageStressReduction . "\n";
        $message .= "Средн. уровень до:  " . $averageStressBefore . "\n";
        $message .= "Средн. уровень после:  " . $averageStressAfter . "\n";

        $message .= "\n\n";

        $buttons = [
            [new ButtonDTO(
                label: 'Записать новую сессию',
                payload: json_encode(['command' => 'practice_add', 'data' => ['step' => PracticeAddCommand::STEP_SELECT_TYPE]]),
            )],
            [new ButtonDTO(
                label: 'История практики',
                payload: json_encode(['command' => 'practice_history']),
            )],
        ];

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, false, true));
    }
}
