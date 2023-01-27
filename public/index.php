<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use WebShoppingApp\DataFlow\UserInput;
$userInput = new UserInput();
$inputData = $userInput->getInputs();

use WebShoppingApp\Controller\SessionsManager;
use WebShoppingApp\Model\Cart;
if (! isset($sessionManager)) $sessionManager = new SessionsManager();
if ( $sessionManager->isRunning() ) {
    if($sessionManager->cart) {
        echo 'The cart is not null';
        var_dump($sessionManager->cart);
    } else {
        echo 'The cart must be created';
        $sessionManager->cart = new Cart();
    }
}

$cart = $sessionManager->cart;
echo '<pre>' . $cart ;var_dump($cart);echo '</pre>';



use WebShoppingApp\Controller\ControllerManager;
use WebShoppingApp\Controller\HomeActionController;
use WebShoppingApp\Controller\AddProductToPriceListController;
use WebShoppingApp\Controller\FetchProductsFromPriceListController;
use WebShoppingApp\Controller\UpdateProductFromPriceListController;
use WebShoppingApp\Controller\DeleteProductFromPriceListController;
use WebShoppingApp\Controller\AddProductToCartController;

$controllerManager = new ControllerManager();
$controllerManager->add(new HomeActionController())
    ->add(new AddProductToPriceListController())
    ->add(new UpdateProductFromPriceListController())
    ->add(new DeleteProductFromPriceListController())
    ->add(new AddProductToCartController());

require_once __DIR__ . '/../src/View/templates/header.html';
require_once __DIR__ . '/../src/View/templates/navigation.html';
$output = $controllerManager->handle($userInput);

require_once __DIR__ . '/../src/View/templates/footer.html';

