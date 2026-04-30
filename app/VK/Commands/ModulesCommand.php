<?php

namespace App\VK\Commands;

use Illuminate\Http\Client\ConnectionException;

class ModulesCommand extends Command
{
    protected string $name = 'modules';
    protected string $value = 'Интерактивные модули';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id): void
    {
        $message = 'Раздел "Интерактивные модули" в разработке';

        $this->messageService->send($user_id, $message);
    }
}
