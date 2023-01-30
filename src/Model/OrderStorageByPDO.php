<?php

namespace WebShoppingApp\Model;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Storage\Connectable;
use PDO;
use DateTime;

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
        $queries['order'] = 'INSERT INTO orders (id, total, completed_at)
                        VALUES
                        ( :order_id, :total, :completed_at );';
        $queries['items'] = 'INSERT INTO order_items  (order_id, product_id, quantity, price)
                            VALUES
                            (:order_id, :product_id, :quantity, :price);';
        /* @todo  optional building queries by using separate class
        $qBuilder = new OrderQueryBuilder($order);
        $query = $qBuilder->modifyQueryMode('insert')->build();  */

        /* transaction(s) executions */
        if ($this->processQueries($order, $queries)) {
            echo "<div class=\"message info\">The operation with the order was successful</div>";

            return $order;
        }
        return false;
    }

    private function processQueries(Order $order, array $queries): bool
    {
        try {
            $this->pdoConnection->beginTransaction();
            $statements['order'] = $this->pdoConnection->prepare($queries['order']);
            $statements['items'] = $this->pdoConnection->prepare($queries['items']);
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