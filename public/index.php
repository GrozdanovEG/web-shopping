<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
use \WebShoppingApp\Storage\DatabaseData;

include __DIR__ . '/../src/View/header.html';
echo '        <h1>Web Shopping App</h1>';

$APPGLOBALS['dbdata'] = [
    'host' => 'localhost',
    'username' => 'm3webshopping',
    'password' => 'wshm3',
    'databaseName' => 'm3webshopping'
];
$databaseData = new DatabaseData($APPGLOBALS['dbdata']);
$pdoDB = new PDO($databaseData->generatePdoDsn('mysql'), $databaseData->username(), $databaseData->password());


try {
    $query = file_get_contents(__DIR__.'/../src/Storage/structure.sql');
    $pdoDB->query($query);
    echo "<div>\"<code>{$query}</code>\" sucessfully executed!</div>";
} catch (\Exception $exception) {
    echo "Cannot execute the query<br>";
    echo "<div>{$exception->getMessage()}</div>";
}

print_r($database);


include __DIR__ . '/../src/View/footer.html';

