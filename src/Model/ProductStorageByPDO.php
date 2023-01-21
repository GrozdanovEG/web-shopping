<?php

namespace WebShoppingApp\Model;

use PDO;
use WebShoppingApp\Storage\Connectable;
use WebShoppingApp\DataFlow\{StorageInput,InputData};

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
        $qBuilder = new ProductQueryBuilder($product);
        $query = $qBuilder->modifyQueryMode('insert')->build();

        $statement = $this->pdoConnection->prepare($query);
        if ( $statement->execute($parameters) )
            return $product;

        return false;
    }

    public function remove(Product $product): Product|false
    {

        return false;
    }

    public function findById(string $id): ?Product
    {
        $query = "SELECT * FROM products WHERE id = :id AND visibility > 0";
        $statement = $this->pdoConnection->prepare($query);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result= $statement->fetch();
        $storageInput = new StorageInput($result);
        return (ProductFactory::createFromInputData($storageInput) ?? null);
    }

    /** @return Product[] */
    public function fetchAll(): array
    {
        $query = "SELECT * FROM products WHERE visibility > 0";
        $statement = $this->pdoConnection->query($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $results = $statement->fetchAll();
        $products = [];
        foreach ($results as $result) {
            $storageInput = new StorageInput($result);
            $products[] = ProductFactory::createFromInputData($storageInput);
        }
        return $products;
    }
}
