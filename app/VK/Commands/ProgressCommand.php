<?php

namespace App\VK\Commands;

use App\Models\Module;
use App\Models\ModuleAttempts;
use Illuminate\Http\Client\ConnectionException;

class ProgressCommand extends Command
{
    protected string $name = 'progress';
    protected string $value = 'Мой прогресс';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        $message = "Ваш прогресс:\n\n";

        $modules = Module::all();

        foreach ($modules as $module) {
            $attempt = ModuleAttempts::query()->where('user_id', $user_id)
                ->where('module_id', $module->id)
                ->where('status', 'finished')
                ->orderBy('updated_at')->first();

            $result = $attempt ? $attempt->scores . "/" . $attempt->total_scores : "-";

            $message .= $module->id . ". " . $module->title . " ". $result . "\n\n";
        }

        $this->messageService->send($user_id, $message);
    }
}
