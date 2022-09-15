<?php

namespace ModularLightspeed\ModularLightspeed\Commands;

use Illuminate\Console\Command;

class ModularLightspeedCommand extends Command
{
    public $signature = 'modular-middleware-Lightspeed';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
