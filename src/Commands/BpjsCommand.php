<?php

namespace Kangangga\Bpjs\Commands;

use Illuminate\Console\Command;

class BpjsCommand extends Command
{
    public $signature = 'laravel-bpjs';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
