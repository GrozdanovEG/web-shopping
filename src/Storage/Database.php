<?php
declare(strict_types=1);

namespace WebShoppingApp\Storage;

use PDO;

class Database extends Storage implements Connectable {

    public function __construct(DatabaseData $dbData)
    {
        $this->storageData = $dbData;
    }

    /** @return PDO|null */
    public function connect(string $dbDriver): mixed
    {
        try {
            return new PDO($this->storageData->generatePdoDsn($dbDriver),
                           $this->storageData->username(), $this->storageData->password());
        } catch (\Throwable $throwable) {
            echo '<div class="message failure">Something went wrong. Check your input and/or try again later!</div>';
            error_log('Error occurred: '.$throwable->getMessage() . PHP_EOL);
            return null;
        }
    }

    // @todo to be implemented
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
        return true;
    }
}



