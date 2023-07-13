<?php

namespace Vietstars\DevDebugger\Console;

use DebugBar\DebugBar;
use Illuminate\Console\Command;

class ClearCommand extends Command
{
    protected $name = 'debugbar:clear';
    protected $description = 'Clear the DevDebugger Storage';
    protected $debugbar;

    public function __construct(DebugBar $debugbar)
    {
        $this->debugbar = $debugbar;

        parent::__construct();
    }

    public function handle()
    {
        $this->debugbar->boot();

        if ($storage = $this->debugbar->getStorage()) {
            try {
                $storage->clear();
            } catch (\InvalidArgumentException $e) {
                // hide InvalidArgumentException if storage location does not exist
                if (strpos($e->getMessage(), 'does not exist') === false) {
                    throw $e;
                }
            }
            $this->info('DevDebugger Storage cleared!');
        } else {
            $this->error('No DevDebugger Storage found..');
        }
    }
}
