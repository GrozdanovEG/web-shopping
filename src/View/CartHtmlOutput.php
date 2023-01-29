<?php
declare(strict_types=1);
namespace WebShoppingApp\View;

class CartHtmlOutput
{
    /** @var Listable[]  */
    protected array $entities;

    public function __construct(array $entities)
    {
        $this->entities = $entities;
    }

    public function toListView(): string
    {
        $listableItems = $this->entities ?? [];
        $output = '';
        foreach ($listableItems as $li) {
            $output .= <<<OUTPUT
                        <li>
                            <span class="image"><img src="/media/img/random.png" alt="no image available"></span>
                            <span class="name">{$li->name()}</span>
                            <span class="price">&dollar;{$li->price()}</span>
                            <span class="quantity"><input type="number" value="{$li->quantity()}"></span>
                        </li>
                    OUTPUT;
        }
        return '<ol>' . PHP_EOL . $output. PHP_EOL . '</ol>' . PHP_EOL;
    }

    public function toTableView(): string
    {
        $listableItems = $this->entities ?? [];
        $rows = '';
        $total = 0.0;
        foreach ($listableItems as $li) {
            $itemTotal = ($li->quantity() * $li->price());
            $productStatus = $li->quantity() ? 'incart' : 'removed';
            $rows .= <<<ROW
                        <tr class="{$productStatus}">
                            <td>{$li->name()}</td>
                            <td>&dollar;{$li->price()}</td>
                            <td><input type="number" name="{$li->id()}" value="{$li->quantity()}"></td>
                            <td>Total: &dollar;{$itemTotal}</td>
                        </tr>
                    ROW;
            $total += $itemTotal;
        }
        $rows .=  '<tr><td colspan="4">Cart total: &dollar;'.$total.'</td></tr>';
        return '<table>' . PHP_EOL . $rows. PHP_EOL . '</table>' . PHP_EOL;
    }

}