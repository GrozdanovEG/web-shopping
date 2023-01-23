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
        /** @todo  To be moved to ProductHtmlOutput specific class */
        $form = (new ApplicationOutputFormatter())->productButtonsGenerator($this->entity);
        $tableRowOutput = "  <td>{$form}</td>".PHP_EOL;
        $tableRowOutput .= "  <td>{$this->entity->name()}</td>".PHP_EOL;
        $tableRowOutput .= "  <td>{$this->entity->description()}</td>".PHP_EOL;
        $tableRowOutput .= "  <td>&dollar;{$this->entity->price()}</td>".PHP_EOL;
        $tableRowOutput .= "  <td>{$this->entity->quantity()}</td>".PHP_EOL;
        return '<tr>' . PHP_EOL . $tableRowOutput . PHP_EOL. '</tr>' . PHP_EOL;
    }
}