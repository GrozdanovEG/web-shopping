<?php
declare(strict_types=1);

namespace WebShoppingApp\Storage;

final class StorageData
{
    private array $dbData = [
        'host' => 'localhost',
        'username' => 'm3webshopping',
        'password' => 'wshm3',
        'databaseName' => 'm3webshopping'
    ];
    private array $filenames;

    public function __construct(?array $dbData = null)
    {
        if (isset($dbData))
        $this->dbData = $dbData;
        //$this->dbData = ['host' => 'localhost', 'username' => 'testdrop','password' => '123','databaseName' => 'testdrop'];
    }

    public function dbData(): array
    {
        return $this->dbData;
    }
}
