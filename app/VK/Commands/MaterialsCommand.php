<?php

namespace App\VK\Commands;

use Illuminate\Http\Client\ConnectionException;

class MaterialsCommand extends Command
{
    protected string $name = 'materials';
    protected string $value = 'Образовательное руководство';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id): void
    {
        $message = 'Раздел "Образовательное руководство" в разработке';

        $this->messageService->send($user_id, $message);
    }
}
