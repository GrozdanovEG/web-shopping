<?php
declare(strict_types=1);
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

class ListOrdersHistoryController implements ActionsController
{
    public function canHandle(string $action): bool
    {
        return ($action === 'list_orders' || $action === '');
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
                echo '<div class="message success">Order history successfully loaded.</div>' . PHP_EOL;
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
            // @todo moving the order listing logic completely outside of the controller
            $rows = '';
            foreach ($orders as $order) {
                $rows .= (new OrderHtmlOutput($order))->toTableRowView() . PHP_EOL;
            }
            echo '<table>' . PHP_EOL . $rows . '</table>' . PHP_EOL ;

        } catch (Throwable $th) {
            echo '<div class="message failure">Oooops! Something unexpected happened. Try Again later!</div>';
            error_log($th->getMessage());
        }
        return [$records];
    }
}