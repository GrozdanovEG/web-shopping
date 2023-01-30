<?php

namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;

class ListOrdersHistoryController implements ActionsController
{

    /**
     * @inheritDoc
     */
    public function canHandle(string $action): bool
    {
        return ($action === 'list_orders');
    }

    /**
     * @inheritDoc
     */
    public function handle(InputData $inputData): array
    {
        // TODO: Implement handle() method.
        echo '<div class="message info">ListOrdersHistoryController invoked</div>';
        return [];
    }
}