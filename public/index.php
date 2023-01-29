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

$controllerManager = new ControllerManager();
$controllerManager->add(new HomeActionController())
    ->add(new AddProductToPriceListController())
    ->add(new UpdateProductFromPriceListController())
    ->add(new DeleteProductFromPriceListController())
    ->add(new ListCartContentController())
    ->add(new AddProductToCartController())
    ->add(new ResetCartContentController())
    ->add(new UpdateCartContentController());

require_once __DIR__ . '/../src/View/templates/header.html';
require_once __DIR__ . '/../src/View/templates/navigation.html';

echo '<div> <a href="?mode=shopping&action=cart">see the cart</a> |';
echo '<a href="?mode=shopping&action=reset_cart">reset cart content</a>  </div>';

try {
    $output = $controllerManager->handle($userInput);
} catch (Throwable $th) {
    echo '<div class="message failure">Your request cannot be processed. Check your input and/or try again later!</div>';
    error_log('Failure: ' . $th->getMessage());
}

require_once __DIR__ . '/../src/View/templates/footer.html';

