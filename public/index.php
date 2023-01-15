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
$pdoDB = new PDO($databaseData->generatePdoDsn('mysql'),
                 $databaseData->username(), $databaseData->password());

?>

<form action="/?action=add-product" method="post" name="product">
    <label>Product Name:
        <input type="text" name="name" size="20">
    </label>
    <label>Product description :
        <input type="text" name="description" size="40">
    </label>
    <label>Product price :
        <input type="text" name="price" size="6">
    </label>
    <label>Quantity :
        <input type="text" name="quantity" size="6">
    </label>
    <input type="submit" name="send-button" value="send">
</form>
<?php
$userInput = new UserInput();
//$userInput = (new UserInput)->returnPostInputs();
//$userInput = (new UserInput)->returnGetInputs();

use WebShoppingApp\Model\Product;


echo '<pre>';
//var_dump($userInput); exit;

$product = Product::createFromInputData($userInput->getInputs());
print_r($product);
echo '</pre>';

echo '<hr>';



include __DIR__ . '/../src/View/footer.html';

