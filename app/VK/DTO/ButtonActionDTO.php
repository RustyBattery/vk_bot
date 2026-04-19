<?php

namespace App\VK\DTO;

readonly class ButtonActionDTO
{
    public string $type;
    public string $label;
    public string $payload;

    public function __construct($label, $type = 'text', $payload = '')
    {
        $this->label = $label;
        $this->type = $type;
        $this->payload = $payload;
    }
}
