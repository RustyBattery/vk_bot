<?php

namespace App\VK\Commands\Materials;

use App\Models\Material;
use App\VK\Commands\Command;
use App\VK\DTO\ButtonDTO;
use App\VK\DTO\KeyboardDTO;
use Illuminate\Http\Client\ConnectionException;

class MaterialItemCommand extends Command
{
    protected string $name = 'material_item';
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

        $material = Material::with('blocks')->find($id);

        $buttons = [];

        foreach ($material->blocks as $block) {
            $label = $block->title;
            if (mb_strlen($label) > 40) {
                $label = mb_substr($label, 0, 37) . '...';
            }

            $buttons[] = [new ButtonDTO(
                label: $label,
                type: 'callback',
                payload: json_encode(['command' => 'material_block', 'data' => ['id' => $block->id]]),
            )];
        }

        $message = $material->title . "\n\n" . $material->text;

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, true, true));
    }
}
