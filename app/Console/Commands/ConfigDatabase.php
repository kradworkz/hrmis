<?php

namespace hrmis\Console\Commands;

use Illuminate\Console\Command;

class ConfigDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:database
                    {--show : Display the database name instead of modifying files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the application database configuration';

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
        $database = $this->ask('Enter database name');
        $username = $this->ask('Enter database username');
        $password = $this->secret('Enter database password');

        if($this->option('show')) {
            return $this->line('<comment>'.$database.'</comment>');
        }

        $env      = file_get_contents($this->laravel->environmentFilePath());

        $db_database  = "/^.*\bDB_DATABASE\b.*$/m";
        $db_username  = "/^.*\bDB_USERNAME\b.*$/m";
        $db_password  = "/^.*\bDB_PASSWORD\b.*$/m";

        $matches      = array();
        preg_match($db_database, $env, $matches[0]);
        preg_match($db_username, $env, $matches[1]);
        preg_match($db_password, $env, $matches[2]);

        if(empty($matches)) {
            echo "Database configuration not found in env file. Aborting..\n";
            return false;
        }

        $env      = str_replace($matches[0], "DB_DATABASE=".$database, $env);
        $env      = str_replace($matches[1], "DB_USERNAME=".$username, $env);
        $env      = str_replace($matches[2], "DB_PASSWORD=".$password, $env);
        file_put_contents($this->laravel->environmentFilePath(), $env);

        $this->info("Database configuration set successfully.");
    }
}