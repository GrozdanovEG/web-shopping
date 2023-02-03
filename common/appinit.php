<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use WebShoppingApp\DataFlow\UserInput;
$userInput = new UserInput();
//$inputData = $userInput->getInputs();

use WebShoppingApp\Controller\ControllerManager;
$controllerManager = new ControllerManager();
