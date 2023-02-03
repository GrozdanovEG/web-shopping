<?php
require_once __DIR__ . '/../common/appinit.php';

use WebShoppingApp\Controller\Application;
use WebShoppingApp\Controller\HomeActionController;
use WebShoppingApp\Controller\ListOrdersHistoryController;
use WebShoppingApp\Controller\ListOrderDetailsController;

$controllerManager
    ->add(new ListOrdersHistoryController())
    ->add(new ListOrderDetailsController());

require_once __DIR__ . '/../src/View/templates/header.html';
require_once __DIR__ . '/../src/View/templates/navigation.html';

(new Application($controllerManager))->run($userInput);

require_once __DIR__ . '/../src/View/templates/footer.html';
