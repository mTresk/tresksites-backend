<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseBackup extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Backup the database to cloud storage';

    public function handle(): void
    {
        $filename = "backup-".now()->format('Y-m-d').".sql";
        $path = storage_path("app/backup/{$filename}");

        //  Создание резервной копии
        $command = "mysqldump --user="
            .config('database.connections.mysql.username')
            ." --password=".config('database.connections.mysql.password')
            ." --host=".config('database.connections.mysql.host')
            ." "
            .config('database.connections.mysql.database')
            ."  > ".$path;

        exec($command);

        $this->info('Резервная копия базы данных создана.');
    }
}