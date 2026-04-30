<?php

namespace App\VK\Commands;

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
        $message = 'Раздел "Журнал практики" в разработке';

        $this->messageService->send($user_id, $message);
    }
}
