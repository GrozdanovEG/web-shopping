<?php
declare(strict_types=1);

namespace WebShoppingApp\Model;

use DateTime;

class Order
{
    private string $id;
    private float $total;
    private DateTime $completedAt;
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

    public function hideItem(): void
    {
        if ($this->visibility() > 0 ) $this->visibility = 0;
    }
}