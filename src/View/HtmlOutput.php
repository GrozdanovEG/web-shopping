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

    public function toTableView(): string
    {
        $form = (new ApplicationOutputFormatter())->productButtonsGenerator($this->entity);
        $tableOutput = "  <td class=\"front-cell\">{$form}</td>".PHP_EOL;
        $tableOutput .= "  <td>{$this->entity->name()}</td>".PHP_EOL;
        $tableOutput .= "  <td>{$this->entity->description()}</td>".PHP_EOL;
        $tableOutput .= "  <td>&dollar;{$this->entity->price()}</td>".PHP_EOL;
        $tableOutput .= "  <td>{$this->entity->quantity()}</td>".PHP_EOL;
        return '<tr>' . PHP_EOL . $tableOutput . PHP_EOL. '</tr>' . PHP_EOL;
    }
}