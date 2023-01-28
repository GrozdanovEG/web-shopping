<?php
declare(strict_types=1);
namespace WebShoppingApp\View;

class HtmlOutput extends Output
{
    protected Listable $entity;
    public function __construct(Listable $entity)
    {
        $this->entity = $entity;
    }

    public function toListView(): string
    {
        $listItem = $this->entity->name() ?? '';
        return '<li>'.$listItem.'</li>';
    }

    public function toTableRowView(): string
    {
        $tableRowOutput = $this->entity; // currently using the built-in entity toString conversion
        return '<tr>' . PHP_EOL . $tableRowOutput . PHP_EOL. '</tr>' . PHP_EOL;
    }
}