<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class appmaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appmaker:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $output = shell_exec('C:/xampp/htdocs/PropertyManager/test.bat');
        return $output;
    }
}
