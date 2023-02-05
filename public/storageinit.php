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
            This project/application uses MySQL compatible DBMS, so the application within this file can create for you the necessary
            user, database, and tables with the correct format.
        </p>
    </div>
    <div>
        <h3>Guidelines</h3>
        <ol>
            <li>
                <p>
                    You have the options to create a new user within your DBMS for managing this project database storage,
                    or to use existing account, including the <em>root</em> one;
                </p>
            </li>
            <li>
                <p>
                    You have the options to create the new units (database, tables) if they don't exist, or to recreate them
                    even if they exist. Bear in mind the second option will clear all the data stored in the units before
                    their recreation.
                </p>
            </li>
            <li>
                <p>
                    To execute the queries with admin privileges use the first form enter your credentials as "username" and
                    "password" and use the appropriate button depending on the behavior you need. The user with admin privileges
                    must be allowed to create new users, databases and also grant option.<br>
                    For example if you have a configured MySQL DBMS with user '<em>admin</em>' (with sufficient rights) and password '<em>azerty</em>', enter
                    this data in the input fields of the form and click on the appropriate button!
                </p>
            </li>
        </ol>
    </div>
    <div>
<?php
$EXEC_ENABLED = false;
/* !!! It is strongly recommended to be replaced with 'false' after DB instantiation
 *     to lock the possibility to be executed by someone else if the application remain
 *     running on publicly accessible server
 */
$EXEC_ENABLED = true; // Comment this line after finishing the db initialization

require_once __DIR__ . '/../vendor/autoload.php';
use WebShoppingApp\Storage\{StorageData,DatabaseData,Database};
use WebShoppingApp\Storage\ApplicationDatabaseInit;
$defaultDbDataObj = new DatabaseData((new StorageData())->dbData());

[$mode, $accessLevel, $dbDataObj] = findModeAndDatabaseData();
$pdo = getPdoConnection($dbDataObj);
$recreationPossible = false;

if ($pdo && $accessLevel === 'admin') {
    $databaseExists = databaseExists($defaultDbDataObj->databaseName(), $pdo);
    $usernameExists = usernameExists($defaultDbDataObj->username(), $pdo);
    $recreationPossible = $databaseExists || $usernameExists;
}

if ( $EXEC_ENABLED ) {
    try {
       if ($mode && $pdo) handleDbStorageCreation($mode, $pdo);
    } catch (Throwable $th) {
        echo '<div class="message failure">The operation was not successful, sorry!</div>' . PHP_EOL;
        error_log($th->getMessage());
    }
} else {
    echo '<div class="message warning">The script execution is disabled by the host administrator!</div>' . PHP_EOL;
}
?>
        <p>
            Form 1: <strong>Executing queries with admin privileges</strong>
        </p>
        <form action="?" method="post">
            <label>DB Hostname:
                <input type="text" size="10" name="hostname" value="localhost" />
            </label>
            <br/>
            <label>DB Username:
                <input type="text" size="10" name="username" />
            </label>
            <br/>
            <label>DB Password:
                <input type="password" size="10" name="password" />
            </label>
            <br>
            <input type="hidden" name="access_level" value="admin" />
            <button type="submit" name="action" value="create_database">Create database and user with admin privileges</button>
            <?php if($recreationPossible): ?>
            <button type="submit" name="action" value="recreate_database">Recreate database and user with admin privileges</button>
            <?php endif; ?>
            <br>
            <button type="submit" name="action" value="create_tables">Create tables with admin privileges</button>
            <?php if($recreationPossible): ?>
            <button type="submit" name="action" value="recreate_tables">Recreate tables with admin privileges</button>
            <?php endif; ?>
        </form>
    </div>
    <div>
        <p>
            Form 2: <strong>Creating the necessary tables with the application user privileges</strong>
        </p>
        <form action="?" method="post">
            <input type="hidden" name="access_level" value="user" />
            <button type="submit" name="action" value="create_tables">Create tables with user privileges</button>
            <?php if($recreationPossible): ?>
            <button type="submit" name="action" value="recreate_tables">Recreate tables with user privileges</button>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
<?php
/* locally defined functions and classes */
function handleDbStorageCreation(string $mode, PDO $pdo): void
{
    $defaultDbDataObj = new DatabaseData((new StorageData())->dbData());
    switch ($mode) {

    case 'create_tables':
        ApplicationDatabaseInit::createTables($pdo);

    case 'recreate_tables':
        $databaseUnitsDropper = new DatabaseUnitsDropper(new DropQueryFacilitator($defaultDbDataObj));
        $databaseUnitsDropper->dropTables($pdo);
        ApplicationDatabaseInit::createTables($pdo);
        break;

    case 'create_database':
        ApplicationDatabaseInit::createUserAndDatabase($pdo);
        break;

    case 'recreate_database':
        $databaseUnitsDropper = new DatabaseUnitsDropper(new DropQueryFacilitator($defaultDbDataObj));
        $databaseUnitsDropper->dropDatabase($pdo);
        $databaseUnitsDropper->dropUser($pdo);
        ApplicationDatabaseInit::createUserAndDatabase($pdo);
        break;

    default:
        break;
    }
}

function usernameExists(string $username, PDO $pdo): bool
{
    $userRecordsFound = [];
    try {
    $stmt = $pdo->query("SELECT user FROM mysql.user WHERE user = '".$username."';");
    $userRecordsFound = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch(Throwable $th) {
        error_log('['.$th->getFile(). ':'. $th->getLine(). ']' .$th->getMessage() . PHP_EOL . $th->getTraceAsString());
    }
    return (count($userRecordsFound) > 0);
}

function databaseExists(string $dbName, PDO $pdo): bool
{
    $databasesRecordsFound = [];
    try {
    $stmt = $pdo->query("SHOW DATABASES");
    $databasesRecordsFound = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch(Throwable $th) {
        error_log('['.$th->getFile(). ':'. $th->getLine(). ']' .$th->getMessage() . PHP_EOL . $th->getTraceAsString());
    }
    return in_array($dbName, $databasesRecordsFound, true);
}

function getPdoConnection(DatabaseData $dbDataObj): PDO|false
{
    try {
        $dsn = "mysql:host={$dbDataObj->host()};";
        if ($dbDataObj->databaseName() !== '')
            $dsn = $dsn."dbname={$dbDataObj->databaseName()}";
        $pdo = new PDO($dsn, $dbDataObj->username(), $dbDataObj->password());
    } catch (PDOException $e) {
        error_log('['.$e->getFile(). ':'. $e->getLine(). ']' .$e->getMessage() . PHP_EOL . $e->getTraceAsString());
        return false;
    }
    return $pdo;
}

function findModeAndDatabaseData(): array {
    $dbDataArray = (new StorageData())->dbData();
    $POST_FILTERED = ['action' => ''];
    if (count($_POST) > 0) {
        $dbDataObj = new DatabaseData($dbDataArray);
        foreach (array_keys($_POST) as $postKey) {
            $POST_FILTERED[$postKey] = htmlentities(filter_input(INPUT_POST, $postKey));
        }
        $dbDataArray = [
            'host' => $POST_FILTERED['hostname'] ?? $dbDataObj->host(),
            'username' =>  $POST_FILTERED['username'] ?? $dbDataObj->username(),
            'password' =>  $POST_FILTERED['password'] ?? $dbDataObj->password(),
        ];
        if ( $POST_FILTERED['action'] === 'create_database' ||
            $POST_FILTERED['action'] === 'recreate_database') $dbDataArray['databaseName'] = '';
        else $dbDataArray['databaseName'] = $dbDataObj->databaseName();
    }
    return [$POST_FILTERED['action'], $POST_FILTERED['access_level'], (new DatabaseData($dbDataArray))];
}

class DropQueryFacilitator
{
    private array $queries;

    public function __construct(DatabaseData $dbDataObj)
    {
        $this->queries = [
            'dropuser' => 'DROP USER IF EXISTS ' . $dbDataObj->username() . ';',
            'dropdtatabase' => 'DROP DATABASE IF EXISTS ' . $dbDataObj->databaseName() . ';',
            'droptables' => 'DROP TABLE IF EXISTS order_items, orders, products;'
        ];
    }

    public function dropUserQuery(): string
    {
        return $this->queries['dropuser'];
    }

    public function dropDatabaseQuery(): string
    {
        return $this->queries['dropdtatabase'];
    }

    public function dropTablesQuery(): string
    {
        return $this->queries['droptables'];
    }
}

class DatabaseUnitsDropper
{
    private DropQueryFacilitator $dqf;

    public function __construct(DropQueryFacilitator $dqf)
    {
        $this->dqf = $dqf;
    }

    public function dropUser(PDO $pdo): bool
    {
        try {
            $pdo->query($this->dqf->dropUserQuery());
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function dropDatabase(PDO $pdo): bool
    {
        try {
            $pdo->query($this->dqf->dropDatabaseQuery());
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function dropTables(PDO $pdo): bool
    {
        try {
            $pdo->query($this->dqf->dropTablesQuery());
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
