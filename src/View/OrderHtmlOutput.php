<?php

namespace WebShoppingApp\View;

class OrderHtmlOutput
{
    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function toTableView(): string
    {
        $rows = '';
        // @todo implementing rendering of the rows
        return '<table>'. PHP_EOL. $rows . PHP_EOL . '</table>' . PHP_EOL;
    }
}