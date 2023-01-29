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
        // @todo   to be implemented Cart specific logic
        $cartFromInputData = CartFactory::createFromInputData($inputData);
        $c = $cartFromInputData;
        $parameters = [
            'id' => $c->id() ?? $cart->id(),
            'name' => $c->name() ?? $cart->name(),
            'price' => $c->price() ?? $cart->price(),
            'quantity' => $c->quantity() ?? $cart->quantity()
        ];
        $qBuilder = new CartQueryBuilder($cart);

        if ( $cart->id() === $cartFromInputData->id() ) {
            $query = $qBuilder->modifyQueryMode('update')->build();
        } else {
            $query = $qBuilder->modifyQueryMode('insert')->build();
        }

        $statement = $this->pdoConnection->prepare($query);
        if ( $statement->execute($parameters) ) {
            echo "<div class=\"message success\">The operation with {$c->name()} was successful</div>";
            return $c;
        }
        return false;
    }

}