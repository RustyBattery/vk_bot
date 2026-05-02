<?php

return [
    'commands' => [
        'start' => \App\VK\Commands\StartCommand::class,
        'menu' => \App\VK\Commands\MenuCommand::class,
        'materials' => \App\VK\Commands\Materials\MaterialsCommand::class,
        'material_item' => \App\VK\Commands\Materials\MaterialItemCommand::class,
        'material_block' => \App\VK\Commands\Materials\MaterialBlockCommand::class,
        'modules' => \App\VK\Commands\Modules\ModulesCommand::class,
        'progress' => \App\VK\Commands\ProgressCommand::class,
        'practices' => \App\VK\Commands\PracticesCommand::class,
        'diary' => \App\VK\Commands\DiaryCommand::class,
    ],
];
