<?php
declare(strict_types=1);
namespace WebShoppingApp\Model;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Storage\Connectable;

class CartStorageByPDO implements CartStorage
{

    private Connectable $connectable;
    private ?PDO $pdoConnection = null;
    protected string $dbDriverName;

    public function __construct(Connectable $connectable)
    {
        $this->connectable = $connectable;
        $this->changeDbDriverName('mysql');
    }

    public function changeDbDriverName(string $dbDriverName): void
    {
        if (in_array($dbDriverName, PDO::getAvailableDrivers(), true)) {
            $this->dbDriverName = $dbDriverName;
        }
        $this->updateConnection();
    }

    private function updateConnection(): void
    {
        $this->pdoConnection = $this->connectable->connect($this->dbDriverName);
    }

    public function store(Cart $cart, ?InputData $inputData): Cart|false
    {
        // TODO: Implement store() method.
        // Abandoned for now, not applicable

    }

}