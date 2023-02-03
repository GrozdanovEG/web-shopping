<?php
namespace WebShoppingApp\Model;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Storage\Connectable;
use PDO;

class OrderStorageByPDO implements OrderStorage
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

    public function store(Order $order, ?InputData $inputData): Order|false
    {
        $qBuilder = new OrderQueryBuilder();
        $queries['order'] = $qBuilder->modifyQueryMode('insert')->build();
        $queries['item'] = $qBuilder->modifyQueryMode('insert-item')->build();

        /* transactions execution */
        if ($this->processQueries($order, $queries)) {
            echo '<div class="message success">Order successfully stored</div>';
            return $order;
        }
        return false;
    }

    public function findById(string $id): array
    {
        $results = [];
        try {
            $qBuilder = new OrderQueryBuilder();
            $query= $qBuilder->modifyQueryMode('select-item-by-id')->build();
            $statement = $this->pdoConnection->prepare($query);
            $statement->execute(['id' => $id]);
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $results = $statement->fetchAll();
        } catch (\Throwable $th) {
            error_log('Error: '. $th->getMessage().
                '  ['. $th->getFile() .':' . $th->getLine() . ']' . PHP_EOL);
            echo '<div class="message failure">We are currently experiencing technical problem. Sorry for the inconvenience!</div>'.PHP_EOL;
        }
        return $results;
    }
    public function fetchAll(): array
    {
        $results = [];
        try {
            $qBuilder = new OrderQueryBuilder();
            $query= $qBuilder->modifyQueryMode('select')->build();
            $statement = $this->pdoConnection->query($query);
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $results = $statement->fetchAll();
        } catch (\Throwable $th) {
            error_log('Error: '. $th->getMessage().
                '  ['. $th->getFile() .':' . $th->getLine() . ']' . PHP_EOL);
            echo '<div class="message failure">We are currently experiencing technical problem. Sorry for the inconvenience!</div>'.PHP_EOL;
        }
        return $results;
    }

    private function processQueries(Order $order, array $queries): bool
    {
        try {
            $this->pdoConnection->beginTransaction();
            $statements['order'] = $this->pdoConnection->prepare($queries['order']);
            $statements['items'] = $this->pdoConnection->prepare($queries['item']);
            $parameters = [
                'order_id' => $order->id(),
                'total' => $order->total(),
                'completed_at' => $order->completedAt()->format('Y-m-d H:i:s')
            ];
            $statements['order']->execute($parameters);

            /* processing each item */
            foreach ($order->getItems() as $item) {
                $parameters = [
                    'order_id' => $order->id(),
                    'product_id' => $item->id(),
                    'quantity' => $item->quantity(),
                    'price' => $item->price()
                ];
                $statements['items']->execute($parameters);
            }

            $this->pdoConnection->commit();
            return true;
        } catch(Exception $e) {
            error_log("File: {$e->getFile()} ; Line: {$e->getLine()}: Message:  {$e->getMessage()}");
            $this->pdoConnection->rollBack();
            return false;
        }
    }


}