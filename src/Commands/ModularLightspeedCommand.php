<?php

namespace Modularlightspeed\Modularlightspeed\Commands;

use Illuminate\Console\Command;

class ModularlightspeedCommand extends Command
{
    public $signature = 'modular-middleware-lightspeed';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
