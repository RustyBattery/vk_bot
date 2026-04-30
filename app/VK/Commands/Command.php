<?php

namespace App\VK\Commands;

use App\VK\Services\MessageService;

abstract class Command
{
    protected string $name = '';
    protected string $value = '';

    protected MessageService $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function getName(): string
    {
        return $this->name;
    }

    abstract public function handle(int $user_id, ?object $payload);
}
