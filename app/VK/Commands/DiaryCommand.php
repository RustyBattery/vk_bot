<?php

namespace App\VK\Commands;

use Illuminate\Http\Client\ConnectionException;

class DiaryCommand extends Command
{
    protected string $name = 'diary';
    protected string $value = 'Дневник размышлений';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        $message = 'Раздел "Дневник размышлений" в разработке';

        $this->messageService->send($user_id, $message);
    }
}
