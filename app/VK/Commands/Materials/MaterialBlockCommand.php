<?php

namespace App\VK\Commands\Materials;

use App\Models\MaterialBlock;
use App\VK\Commands\Command;
use App\VK\DTO\ButtonDTO;
use App\VK\DTO\KeyboardDTO;
use Illuminate\Http\Client\ConnectionException;

class MaterialBlockCommand extends Command
{
    protected string $name = 'material_block';
    protected string $value = '';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        $id = $payload->data->id ?? null;

        if (!$id) {
            return;
        }

        $block = MaterialBlock::find($id);

        $message = $block->title . "\n\n" . $block->text;

        $buttons = [
            [new ButtonDTO(
                label: 'Образовательное руководство',
                payload: json_encode(['command' => 'materials']),
            )],
            [new ButtonDTO(
                label: 'Интерактивные модули',
                payload: json_encode(['command' => 'modules']),
            )],
            [new ButtonDTO(
                label: 'Мой прогресс',
                payload: json_encode(['command' => 'progress']),
            )],
            [new ButtonDTO(
                label: 'Журнал практики',
                payload: json_encode(['command' => 'practices']),
            )],
            [new ButtonDTO(
                label: 'Дневник размышлений',
                payload: json_encode(['command' => 'diary']),
            )],
        ];

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, false, false));
    }
}
