<?php

namespace WebShoppingApp\View;
use WebShoppingApp\Model\Cart;

class PriceListHtmlOutput
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
            $avail = ($li->quantity() >= 1 ? 'In' : 'Out of');
            $addButton = $li->quantity() ?
                    '<input type="hidden" name="action" value="add_to_cart">
                    <button type="submit" name="id" value="'.$li->id().'">Add to cart</button>' :
                    '';
            $output .= <<<OUTPUT
                        <li>
                            <span class="image"><img src="/media/img/random.png" alt="no image available"></span>
                            <span class="name">{$li->name()}</span>
                            <span class="price">&dollar;{$li->price()}</span>
                            <span class="order">
                                <span class="button">
                                    {$addButton}
                                </span>
                                <span class="availability">{$avail} stock</span>
                            </span>    
                            <span class="description">{$li->description()}</span>
                            <span style="clear: both"></span>
                        </li>
                    OUTPUT;
        }
        return PHP_EOL . '<ol class="pricelist">' . PHP_EOL . $output. PHP_EOL . '</ol>' . PHP_EOL;
    }
}