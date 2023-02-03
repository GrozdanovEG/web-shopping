<?php
require_once __DIR__ . '/../common/appinit.php';

use WebShoppingApp\Controller\Application;
use WebShoppingApp\Controller\LoadPriceListController;
use WebShoppingApp\Controller\ListCartContentController;
use WebShoppingApp\Controller\AddProductToCartController;
use WebShoppingApp\Controller\ResetCartContentController;
use WebShoppingApp\Controller\UpdateCartContentController;
use WebShoppingApp\Controller\ShoppingCheckoutController;
use WebShoppingApp\Controller\FinishCheckoutController;

$controllerManager
    ->add(new LoadPriceListController())
    ->add(new ListCartContentController())
    ->add(new AddProductToCartController())
    ->add(new ResetCartContentController())
    ->add(new UpdateCartContentController())
    ->add(new ShoppingCheckoutController())
    ->add(new FinishCheckoutController());

require_once __DIR__ . '/../src/View/templates/header.html';
require_once __DIR__ . '/../src/View/templates/navigation.html';

echo <<<SMALLMENU
<div>
   <a href="/shop.php?action=cart">see the cart</a> |
   <a href="/shop.php?action=reset_cart">reset cart content</a> |
</div>
SMALLMENU;

(new Application($controllerManager))->run($userInput);

require_once __DIR__ . '/../src/View/templates/footer.html';
