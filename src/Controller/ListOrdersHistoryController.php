<?php

namespace WebShoppingApp\Controller;

use DateTime;
use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\Order;
use WebShoppingApp\Model\OrderStorageByPDO;
use WebShoppingApp\Model\ProductFactory;
use WebShoppingApp\Storage\Database;
use WebShoppingApp\Storage\DatabaseData;
use WebShoppingApp\Storage\StorageData;

class ListOrdersHistoryController implements ActionsController
{
    public function canHandle(string $action): bool
    {
        return ($action === 'list_orders' || $action === 'orders_history');
    }

    /**
     * @inheritDoc
     */
    public function handle(InputData $inputData): array
    {
        $records = [];
        try {
            $databaseData = new DatabaseData((new StorageData())->dbData());
            $orderStorage = new OrderStorageByPDO(new Database($databaseData));

            if ($records = $orderStorage->fetchAll()) {
                echo '<div class="message success">Order history successfully retrieved.</div>';
            }
            $orders = [];
            foreach ($records as $record) {
                $orderId = $record['order_id'];
                $total = $record['total'];
                $completedAt = DateTime::createFromFormat('Y-m-d H:i:s', $record['completed_at']);
                if (! isset($orders[$orderId])) {
                    $orders[$orderId] = new Order($orderId, $total, $completedAt);
                }
                $product = ProductFactory::createFromArrayAssoc($record);
                $orders[$orderId]->addItem($product);
            }
            // @todo listing orders and products in HTML rendered view
            // (new OrderHtmlOutput($order))->toTableView();
            foreach ($orders as $order) //print_r($order);
                echo '<div>'. $order . '</div><br>';



        } catch (Throwable $th) {
            echo '<div class="message failure"> Oooops! Something unexpected happened. Try Again later!</div>';
            error_log($th->getMessage());
        }
        return [$records];
    }
}