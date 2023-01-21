<?php

namespace WebShoppingApp\Storage;

class SqlQuery implements Buildable
{
    private string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function build(): string
    {
        // TODO: Implement build() method.
        return '';
    }
}