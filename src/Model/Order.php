<?php
declare(strict_types=1);

namespace WebShoppingApp\Model;

use DateTime;
use WebShoppingApp\View\Listable;
use WebShoppingApp\View\ListableItem;
use WebShoppingApp\View\OrderHtmlOutput;

class Order implements Listable
{
    private string $id;
    private float $total;
    private DateTime $completedAt;
    /** @var ListableItem[]  */
    private array $items = [];
    private int $visibility = 1;

    public function __construct(string $id, float $total,
                                DateTime $completedAt)
    {
        $this->id = $id;
        $this->total = $total;
        $this->completedAt = $completedAt;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function total(): float
    {
        return $this->total;
    }

    public function completedAt(): DateTime
    {
        return $this->completedAt;
    }

    public function visibility(): int
    {
        return $this->visibility;
    }

    public function hide(): void
    {
        if ($this->visibility() > 0 ) $this->visibility = 0;
    }

    public function addItem(ListableItem $item): void
    {
        $this->items[] = $item;
    }

    /** @return ListableItem[] */
    public function getItems(): array
    {
        return $this->items;
    }

    public function __toString(): string
    {
        $items = array_reduce($this->items, function($carry,$item) { return $carry .= '['.$item.'], ';} );
        return "[{$this->id()}:{$this->completedAt->format('Y-m-d H:i:s')}:{$this->total()} ::" . PHP_EOL . $items . ']' . PHP_EOL;
    }

    public function render(): string|null
    {
        return (new OrderHtmlOutput($this))->toTableRowView();
    }
}