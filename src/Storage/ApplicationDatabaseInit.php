<?php

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
            echo "<div>{$exception->getMessage()}</div>";
            return false;
        }
    }

}
