<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use WebShoppingApp\DataFlow\UserInput;
$userInput = new UserInput();
$inputData = $userInput->getInputs();

if (! isset($sessionManager)) $sessionManager = new WebShoppingApp\Controller\SessionsManager();
if (! $sessionManager->isRunning()) {
    $_SESSION['CART'] = \WebShoppingApp\Model\CartFactory::createFromInputData($userInput);
}


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

//echo '<pre>';var_dump($sessionManager);echo '</pre>';

include __DIR__ . '/../src/View/templates/footer.html';

