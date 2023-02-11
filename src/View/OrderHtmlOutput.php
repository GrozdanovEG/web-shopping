<?php
declare(strict_types=1);
namespace WebShoppingApp\View;

class OrderHtmlOutput extends HtmlOutput
{

    public function toTableRowView(): string
    {
        $li = $this->entity();
        return <<<ROW
            <tr>                
                <td>Total: &dollar;{$li->total()}</td>           
                <td>Completed at: {$li->completedAt()->format('Y-m-d H:i')}</td> 
                <td><a href="?action=order_details&amp;order_id={$li->id()}">see details</a></td>                     
            </tr>
        ROW;
    }

    public function toTableView(): string
    {
        $items = $this->entity()->getItems();
        $rows = '';
        foreach ($items as $item) {
            $itemTotal = $item->quantity() * $item->price();
            $rows .= <<<ITEMROW
                <tr>
                    <td>{$item->name()}</td>
                    <td>&dollar;{$item->price()}</td>
                    <td>{$item->quantity()}</td>
                    <td>&dollar;{$itemTotal}</td>
                </tr>
                ITEMROW;
        }
        $caption = '<caption>Total: $'.$this->entity()->total().
                   ' , Completed at: '. $this->entity()->completedAt()->format('Y-m-d H:i'). '</caption>';
        return '<table>'. PHP_EOL . $caption . PHP_EOL. $rows . PHP_EOL . '</table>' . PHP_EOL;
    }
}