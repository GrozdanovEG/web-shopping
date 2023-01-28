<?php

namespace WebShoppingApp\View;

class ListableItem implements Listable
{
    /**
     * @inheritDoc
     */
    public function render(): string|null
    {
        return (new HtmlOutput($this))->toTableRowView();
    }
}