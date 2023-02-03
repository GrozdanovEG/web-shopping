<?php
require_once __DIR__ . '/../common/appinit.php';

use WebShoppingApp\Controller\Application;
use WebShoppingApp\Controller\PriceListHomeController;
use WebShoppingApp\Controller\AddProductToPriceListController;
use WebShoppingApp\Controller\UpdateProductFromPriceListController;
use WebShoppingApp\Controller\DeleteProductFromPriceListController;


$controllerManager->add(new PriceListHomeController())
    ->add(new AddProductToPriceListController())
    ->add(new UpdateProductFromPriceListController())
    ->add(new DeleteProductFromPriceListController());

require_once __DIR__ . '/../src/View/templates/header.html';
require_once __DIR__ . '/../src/View/templates/navigation.html';

(new Application($controllerManager))->run($userInput);

require_once __DIR__ . '/../src/View/templates/footer.html';
