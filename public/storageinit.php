<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storage Initializer</title>
    <link rel="stylesheet" href="media/styles.css">
    <style>
        body {
            max-width: 210mm;
            margin: auto;
        }
        p {
            line-height: 18pt;
            margin-top: 1em;
        }
        form * {
            margin: 1vw;
        }
    </style>
</head>
<body>
    <div>
        <h2>Storage Initializer</h2>
    </div>
    <div>
        <p>
            This file contains a small application for initial creation of the necessary storage to run the project itself.
        </p>
        <p>
            This project/application uses MySQL compatible DBMS, so the application within this file can create the necessary
            user, database, and tables with the correct format.
        </p>
    </div>
    <div>
        <p>
            Executing queries with admin privileges
        </p>
        <form action="?" method="post">
            <label>User:
                <input type="text" size="10" name="user" />
            </label>
            <br/>
            <label>Password:
                <input type="password" size="10" name="password" />
            </label>
            <br>
            <input type="hidden" name="access_level" value="admin" />
            <button type="submit" name="action" value="create_database">Create database/user with admin privileges</button>
            <button type="submit" name="action" value=recreate_database">Recreate database/user with admin privileges</button>
            <br>
            <button type="submit" name="create_tables">Create tables with admin privileges</button>
            <button type="submit" name="recreate_tables">Recreate tables with admin privileges</button>
        </form>
    </div>

    <div>
        <p>
            Creating the necessary tables with the application user privileges
        </p>
        <form action="?" method="post">
            <input type="hidden" name="access_level" value="user" />
            <button type="submit" name="create_tables">Create tables with user privileges</button>
            <button type="submit" name="recreate_tables">Recreate tables with user privileges</button>
        </form>
    </div>
</body>
</html>
<?php
/* !!! It is strongly recommended to be replaced with 'false' after DB instantiation
       to lock the possibility to be executed by someone else if the application remain
       on publicly accessible server
$EXEC_ALLOWED = false;   */
$EXEC_ALLOWED = true;

require_once __DIR__ . '/../vendor/autoload.php';
use WebShoppingApp\Storage\{StorageData,DatabaseData,Database};
$databaseData = new DatabaseData((new StorageData())->dbData());
$mysqlPdoConnection = (new Database($databaseData))->connect('mysql');
echo '<pre>';
$stmt = $mysqlPdoConnection->query('SELECT * FROM orders WHERE 1;');
$results = $stmt->fetchAll();
// connection and query successful
//var_dump($results);





$queries = [];
$queries['admin'] =<<<ADMIN_QUERY
--creating new database
CREATE DATABASE IF NOT EXISTS m3webshopping;
USE m3webshopping;

--creating a new user
CREATE USER IF NOT EXISTS m3webshopping@localhost
    IDENTIFIED BY 'wshm3';

--granting the necessary priviledges
GRANT ALL PRIVILEGES ON m3webshopping.*
    TO 'm3webshopping'@'localhost'
    IDENTIFIED BY 'wshm3';

GRANT CREATE ON *.*
    TO 'm3webshopping'@'localhost'
    IDENTIFIED BY 'wshm3';
ADMIN_QUERY;
