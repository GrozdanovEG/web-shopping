<?php

namespace WebShoppingApp\Storage;

interface Storage
{
    /** @return PDO|MYSQLI */
    public function connect(): mixed;
}