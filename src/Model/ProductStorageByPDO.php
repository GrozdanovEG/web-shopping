<?php

namespace WebShoppingApp\Model;

use PDO;
use WebShoppingApp\Storage\Connectable;

class ProductStorageByPDO implements ProductStorage
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

    public function store(Product $product): Product|false
    {
        $parameters = [
            'id' => $product->id(),
            'name' => $product->name(),
            'description' => $product->description(),
            'price' => $product->price(),
            'quantity' => $product->quantity()
        ];

        // Building query  @todo separating the logic outside the class
        $query =<<<QUERY
        INSERT INTO products
          (id, name, description, price, quantity)
          VALUES
          (:id, :name, :description, :price, :quantity)
        QUERY;
        $statement = $this->pdoConnection->prepare($query);
        if ( $statement->execute($parameters) )
            return $product;

        return false;
    }

    public function remove(Product $product): Product|false
    {

        return false;
    }

    /** @return Product[] */
    public function fetchAll(): array
    {

    }
}