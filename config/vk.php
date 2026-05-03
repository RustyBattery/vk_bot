<?php

return [
    'commands' => [
        'start' => \App\VK\Commands\StartCommand::class,
        'menu' => \App\VK\Commands\MenuCommand::class,
        'materials' => \App\VK\Commands\Materials\MaterialsCommand::class,
        'material_item' => \App\VK\Commands\Materials\MaterialItemCommand::class,
        'material_block' => \App\VK\Commands\Materials\MaterialBlockCommand::class,
        'modules' => \App\VK\Commands\Modules\ModulesCommand::class,
        'module_start' => \App\VK\Commands\Modules\ModuleStartCommand::class,
        'module_question' => \App\VK\Commands\Modules\ModuleQuestionCommand::class,
        'progress' => \App\VK\Commands\ProgressCommand::class,
        'practices' => \App\VK\Commands\Practices\PracticesCommand::class,
        'practice_add' => \App\VK\Commands\Practices\PracticeAddCommand::class,
        'diary' => \App\VK\Commands\DiaryCommand::class,
    ],
];
