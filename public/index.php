<?php
//declare(strict_types=1);
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
use \WebShoppingApp\Storage\DatabaseData;
use \WebShoppingApp\DataFlow\UserInput;

include __DIR__ . '/../src/View/header.html';
echo '        <h1>Web Shopping App</h1>';

require_once __DIR__ . '/../storage/DbData.php';
$databaseData = new DatabaseData($dbData);
try {
    $pdoDB = new PDO($databaseData->generatePdoDsn('mysql'),
        $databaseData->username(), $databaseData->password());
} catch (Exception $ex) {
    echo 'Oooops! Something unexpected happened. Try Again later!';
}

include __DIR__ . '/templates/add-product-form.html';
$userInput = new UserInput();  //$userInput = (new UserInput)->returnPostInputs();


use WebShoppingApp\Model\{Product,Order,Cart};


echo '<pre>';
//var_dump($userInput); exit;

$item = Cart::createFromInputData($userInput);
print_r($item);
echo '</pre>';

echo '<hr>';



include __DIR__ . '/../src/View/footer.html';

