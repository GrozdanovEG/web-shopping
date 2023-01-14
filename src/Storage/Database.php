<?php
declare(strict_types=1);

namespace WebShoppingApp\Storage;

class Database implements Storage {

    private DatabaseData $databaseData;

    public function __construct(DatabaseData $databaseData)
    {
        $this->databaseData = $databaseData;
    }

    public function connect(): \PDO|false
    {
        try {
            return new PDO($this->databaseData->generatePdoDsn('mysql'),
                $this->databaseData->username(), $this->databaseData->password());
        } catch (\Throwable $throwable) {
            echo 'Something went wrong. Check your input and/or try again later!';
            error_log('Error occurred: '.$throwable->getMessage() . PHP_EOL)
            return false;
        }
    }

    public function query(string $query): bool
    {
        try {

            return true;
        } catch (\PDOException $ex) {
            //
            return false;
        }

    }

    public function disconnect(): bool|null
    {
        
    }
}



