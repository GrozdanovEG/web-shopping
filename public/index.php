<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use WebShoppingApp\DataFlow\UserInput;
$userInput = new UserInput();
$inputData = $userInput->getInputs();
use WebShoppingApp\Controller\ControllerManager;
use WebShoppingApp\Controller\HomeActionController;
use WebShoppingApp\Controller\AddProductToPriceListController;
use WebShoppingApp\Controller\FetchProductsFromPriceListController;
use WebShoppingApp\Controller\UpdateProductFromPriceListController;
use WebShoppingApp\Controller\DeleteProductFromPriceListController;
use WebShoppingApp\Controller\ListCartContentController;
use WebShoppingApp\Controller\AddProductToCartController;
use WebShoppingApp\Controller\ResetCartContentController;
use WebShoppingApp\Controller\UpdateCartContentController;
use WebShoppingApp\Controller\ShoppingCheckoutController;
use WebShoppingApp\Controller\FinishCheckoutController;
use WebShoppingApp\Controller\ListOrdersHistoryController;
use WebShoppingApp\Controller\ListOrderDetailsController;

$controllerManager = new ControllerManager();
$controllerManager->add(new HomeActionController())
    ->add(new AddProductToPriceListController())
    ->add(new UpdateProductFromPriceListController())
    ->add(new DeleteProductFromPriceListController())
    ->add(new ListCartContentController())
    ->add(new AddProductToCartController())
    ->add(new ResetCartContentController())
    ->add(new UpdateCartContentController())
    ->add(new ShoppingCheckoutController())
    ->add(new FinishCheckoutController())
    ->add(new ListOrdersHistoryController())
    ->add(new ListOrderDetailsController());

require_once __DIR__ . '/../src/View/templates/header.html';
require_once __DIR__ . '/../src/View/templates/navigation.html';

?>
<div>
    <a href="?mode=shopping&action=cart">see the cart</a> |
   <a href="?mode=shopping&action=reset_cart">reset cart content</a> | <a href="?action=list_orders">list orders history</a>
</div>

<?php
try {
    $output = $controllerManager->handle($userInput);
} catch (Exception $e) {
    echo '<div class="message error">Application error occurred! Sorry for the inconvenience!</div>';
    error_log("File: {$e->getFile()} ; Line: {$e->getLine()}: Message:  {$e->getMessage()}");
} catch (Throwable $th) {
    echo '<div class="message failure">Your request cannot be processed. Check your input and/or try again later!</div>';
    error_log("File: {$th->getFile()} ; Line: {$th->getLine()}: Message:  {$th->getMessage()}");
}

require_once __DIR__ . '/../src/View/templates/footer.html';

