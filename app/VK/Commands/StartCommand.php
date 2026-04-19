<?php

namespace App\VK\Commands;

use App\VK\DTO\ButtonDTO;
use App\VK\DTO\KeyboardDTO;
use Illuminate\Http\Client\ConnectionException;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $value = 'Начать';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id): void
    {
        $keyboard = new KeyboardDTO([
            new ButtonDTO(
                label: 'Образовательное руководство',
                payload: json_encode(['command' => 'materials']),
            ),
            new ButtonDTO(
                label: 'Интерактивные модули',
                payload: json_encode(['command' => 'modules']),
            ),
            new ButtonDTO(
                label: 'Мой прогресс',
                payload: json_encode(['command' => 'progress']),
            ),
            new ButtonDTO(
                label: 'Журнал практики',
                payload: json_encode(['command' => 'practices']),
            ),
            new ButtonDTO(
                label: 'Дневник размышлений',
                payload: json_encode(['command' => 'diary']),
            ),
        ]);

        $message = 'Добро пожаловать в это всеобъемлющее руководство по управлению стрессом при совмещении множества обязанностей. Этот курс поможет вам развить устойчивость и навыки эмоциональной саморегуляции для успеха в требовательной академической и профессиональной среде.';

        $this->messageService->send($user_id, $message, $keyboard);
    }
}
