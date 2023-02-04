<?php
declare(strict_types=1);
namespace WebShoppingApp\Storage;

class ApplicationDatabaseInit {

    public static function createTables(PDO $pdoDB): bool
    {
        try {
            $query = file_get_contents(__DIR__.'/structure.sql');
            $pdoDB->query($query);
            echo "<div>\"<code>{$query}</code>\" sucessfully executed!</div>";
            return true;
        } catch (\Exception $exception) {
            echo "Cannot execute the query<br>";
            echo "<div class='message failure'>{$exception->getMessage()}</div>";
            return false;
        }
    }

}
