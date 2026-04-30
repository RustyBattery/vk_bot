<?php

namespace App\VK\Commands;

use Illuminate\Http\Client\ConnectionException;

class ProgressCommand extends Command
{
    protected string $name = 'progress';
    protected string $value = 'Мой прогресс';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id): void
    {
        $message = 'Раздел "Мой прогресс" в разработке';

        $this->messageService->send($user_id, $message);
    }
}
