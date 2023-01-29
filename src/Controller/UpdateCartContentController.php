<?php
declare(strict_types=1);
namespace WebShoppingApp\Controller;
use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\Cart;
use WebShoppingApp\Model\ProductFactory;
use WebShoppingApp\Model\ProductStorageByPDO;
use WebShoppingApp\Storage\Database;
use WebShoppingApp\Storage\DatabaseData;
use WebShoppingApp\Storage\StorageData;
use WebShoppingApp\View\CartHtmlOutput;



class UpdateCartContentController implements ActionsController
{
    public function canHandle(string $action): bool
    {
        return ($action === 'update_cart' || $action === 'update_cart_content');
    }

    public function handle(InputData $inputData): array
    {
        if (! isset($sessionManager)) $sessionManager = new SessionsManager();
        if ( $sessionManager->isRunning() && (! $sessionManager->cart) )
            $sessionManager->cart = new Cart();

        $cartList = ($sessionManager->cart)->fetchAll();
        $max = count($cartList);
        $userInputList = $inputData->getInputs();
        for ($i = 0; $i < $max; $i++ ) {
            $prodId = $cartList[$i]?->id();
            $newQuantity = $userInputList[$prodId]?->value();
            // @todo updating quality to be implemented
            echo "{$cartList[$i]->name()} : Old qty: {$cartList[$i]->quantity()}, {$newQuantity} <br>";
        }
        echo "<div class=\"message info\">UpdateCartController invoked!</div>";
        return [];
    }
}