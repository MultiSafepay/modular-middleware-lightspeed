<?php

namespace ModularLightspeed\ModularLightspeed\API\Data;

abstract class RequestData
{
    protected string $path;
    protected string $type;

    public function getPath(): string
    {
        return $this->path;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getHeaders(): array {return [];}
    public function getParams(): array {return [];}
    public function getPayload(): array {return [];}
    public function getJson(): array {return [];}
}
