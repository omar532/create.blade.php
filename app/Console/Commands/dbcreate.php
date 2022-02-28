<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class dbcreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create{name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new MySQL database based on config file or the provided parameter';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $schemaName = $this->argument('name') ?: config('database.connections.MySQL.database');
        $charset = config('database.connections.MySQL.charset','utf8mb4');
        $collaction=config('database.connections.MySQL.collaction','utf8mb4_general_ci');
        config(['database.connections.MySQL.database'=>null]);
        $query="drop database $schemaName";
        db::statement($query);
        $query = "create database if not exists $schemaName character set $charset collate $collaction;";
        db::statement($query);
        echo "database $schemaName create successfu";



         config(['database.connections.MySQL.database'=>schemaName]);
    }
}
