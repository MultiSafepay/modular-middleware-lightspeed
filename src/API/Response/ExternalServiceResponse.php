<?php

namespace Modularlightspeed\Modularlightspeed\API\Response;

class ExternalServiceResponse
{
    public function __construct(
        protected int $id,
        protected string $type,
        protected string $name,
        protected string $urlEndpoint,
        protected bool $isActive,
        protected string $createdAt,
        protected string $updatedAt,
    )
    {
    }
}
