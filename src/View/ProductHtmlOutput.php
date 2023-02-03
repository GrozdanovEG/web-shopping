<?php
declare(strict_types=1);
namespace WebShoppingApp\View;

class ProductHtmlOutput extends HtmlOutput
{
    protected Listable $entity;

    public function __construct(Listable $entity)
    {
        $this->entity = $entity;
    }

    public function toListView(): string
    {
        //@todo fixing and refactoring required
        $li = $this->entity->fetchAll() ?? [];
        $output = '';
            $avail = ($li->quantity() >= 1 ? 'in' : 'out of');
            $addButton = $li->quantity() ?
                '<input type="hidden" name="action" value="add_to_cart">
                          <button type="submit" name="id" value="'.$li->id().'">Add to cart</button>' :
                '';
            $output .= <<<OUTPUT
                        <li>
                            <span class="image"><img src="/media/img/random.png" alt="no image available"></span>
                            <span class="name">{$li->name()}</span>
                            <span class="description">{$li->description()}</span>
                            <span class="price">&dollar;{$li->price()}</span>
                            <span class="availability">
                            <span class="button">
                                {$addButton}
                                {$avail} stock
                            </span>
                        </li>
                    OUTPUT;
        return $output. PHP_EOL;
    }

    public function toTableRowView(): string
    {
        $form = (new ApplicationOutputFormatter())->productButtonsGenerator($this->entity);
        $image = '<img src="/media/img/random.png" alt="no image available">';
        $tableRowOutput  = "<td>{$image}</td>";
        $tableRowOutput .= "  <td>{$this->entity->name()}</td>" . PHP_EOL;
        $tableRowOutput .= "  <td>{$this->entity->description()}</td>" . PHP_EOL;
        $tableRowOutput .= "  <td>&dollar;{$this->entity->price()}</td>" . PHP_EOL;
        $tableRowOutput .= "  <td>{$this->entity->quantity()}</td>" . PHP_EOL;
        $tableRowOutput .= "  <td>{$form}</td>" . PHP_EOL;
        return '<tr>' . PHP_EOL . $tableRowOutput . PHP_EOL . '</tr>' . PHP_EOL;
    }
}