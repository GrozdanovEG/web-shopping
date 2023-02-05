<?php
declare(strict_types=1);
namespace WebShoppingApp\Storage;
use PDO;

class ApplicationDatabaseInit
{
    public static function createUserAndDatabase(PDO $pdo): bool
    {
        $filename = __DIR__ . '/user-and-database.sql';
        return self::executeQueryFormFile($filename, $pdo);
    }

    public static function createTables(PDO $pdo): bool
    {
        $filename = __DIR__ . '/structure.sql';
        return self::executeQueryFormFile($filename, $pdo);
    }

    private static function executeQueryFormFile(string $filename, PDO $pdo): bool
    {
        try {
            if (file_exists($filename) && is_readable($filename))
                $query = file_get_contents($filename);
            else {
                echo '<div class="message failure">Problem with accessing the file '.$filename.'</div>';
                return false;
            }
            $pdo->query($query);
            echo '<div class="message success">Operation was sucessfully executed!</div>';
            return true;
        } catch (Exception $ex) {
            echo "<div class='message error'>Cannot execute the query</div>";
            error_log('['.$ex->getFile().':'.$ex->getLine().']'.PHP_EOL. $ex->getMessage());
            return false;
        }
    }
}
