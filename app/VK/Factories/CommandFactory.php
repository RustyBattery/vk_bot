<?php

namespace App\VK\Factories;

use App\VK\Commands\Command;
use Illuminate\Support\Facades\App;

class CommandFactory
{
    public function make(string $name): ?Command
    {
        $commands = config('vk.commands');

        if (!isset($commands[$name])) {
            return null;
        }

        return App::make($commands[$name]);
    }
}
