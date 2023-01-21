<?php
declare(strict_types=1);

namespace WebShoppingApp\View;

interface Listable
{
    /** @return string|null  */
    public function render(): string|null;
}