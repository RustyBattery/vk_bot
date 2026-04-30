<?php

return [
    'commands' => [
        'start' => \App\VK\Commands\StartCommand::class,
        'materials' => \App\VK\Commands\MaterialsCommand::class,
        'modules' => \App\VK\Commands\ModulesCommand::class,
        'progress' => \App\VK\Commands\ProgressCommand::class,
        'practices' => \App\VK\Commands\PracticesCommand::class,
        'diary' => \App\VK\Commands\DiaryCommand::class,
    ],
];
