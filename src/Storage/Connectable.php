<?php
namespace WebShoppingApp\Storage;

interface Connectable
{
    /** @return PDO|MYSQLI|false */
    public function connect(string $dbDriver): mixed;
}
