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
use WebShoppingApp\View\OrderHtmlOutput;

class ListOrderDetailsController implements ActionsController
{

    public function canHandle(string $action): bool
    {
        return ($action === 'order_details');
    }


    public function handle(InputData $inputData): array
    {
        $orderId = $inputData->getInputs()['order_id']?->value();
        $records = [];
        try {
            $databaseData = new DatabaseData((new StorageData())->dbData());
            $orderStorage = new OrderStorageByPDO(new Database($databaseData));

            if ($records = $orderStorage->findById($orderId)) {
                echo '<div class="message success">Order successfully found.</div>' . PHP_EOL;
            }

            if (count($records) > 0)
            foreach ($records as $record) {
                $orderId = $record['order_id'];
                $total = $record['total'];
                $completedAt = DateTime::createFromFormat('Y-m-d H:i:s', $record['completed_at']);
                if (! isset($order)) {
                    $order = new Order($orderId, $total, $completedAt);
                }
                $product = ProductFactory::createFromArrayAssoc($record);
                $order->addItem($product);
            }

            if(isset($order)) echo (new OrderHtmlOutput($order))->toTableView();

        } catch (Throwable $th) {
            echo '<div class="message failure">Oooops! Something unexpected happened. Try Again later!</div>';
            error_log($th->getMessage());
        }
        return [$records];

    }
}