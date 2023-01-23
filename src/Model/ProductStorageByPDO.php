<?php

namespace WebShoppingApp\Model;

use PDO;
use WebShoppingApp\Storage\Connectable;
use WebShoppingApp\DataFlow\{StorageInput,InputData};
use WebShoppingApp\Storage\Database;

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

    public function store(Product $product, ?InputData $inputData): Product|false
    {
        $productFromInputData = ProductFactory::createFromInputData($inputData);
        $p = $productFromInputData;
        $parameters = [
            'id' => $p->id() ?? $product->id(),
            'name' => $p->name() ?? $product->name(),
            'description' => $p->description() ?? $product->description(),
            'price' => $p->price() ?? $product->price(),
            'quantity' => $p->quantity() ?? $product->quantity()
        ];
        $qBuilder = new ProductQueryBuilder($product);

        if ( $product->id() === $productFromInputData->id() ) {
            $query = $qBuilder->modifyQueryMode('update')->build();
        } else {
            $query = $qBuilder->modifyQueryMode('insert')->build();
        }

        $statement = $this->pdoConnection->prepare($query);
        if ( $statement->execute($parameters) ) {
            echo "<div class=\"message success\">The operation with {$p->name()} was successful</div>";
            return $p;
        }
        return false;
    }

    /** @param Product $product
     *  @return Product|false
     */
    public function remove(Product $product): Product|false
    {
        $parameters = [
                        'id' => $product->id(),
                        'visibility' => $product->visibility()
                      ];
        $qBuilder = new ProductQueryBuilder($product);
        $query = $qBuilder->modifyQueryMode('delete')->build();
        $statement = $this->pdoConnection->prepare($query);
        if ( $statement->execute($parameters) ) {
            echo "<div class=\"message success\">{$product->name()} was successfully removed</div>";
            return $product;
        }
        return false;
    }

    /** @param string $id
     *  @return Product    */
    public function findById(string $id): Product
    {
        $query = "SELECT * FROM products WHERE id = :id AND visibility > 0";
        $statement = $this->pdoConnection->prepare($query);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result= $statement->fetch();
        $storageInput = new StorageInput($result);
        return (ProductFactory::createFromInputData($storageInput));
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
