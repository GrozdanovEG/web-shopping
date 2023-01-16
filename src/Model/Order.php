<?php
declare(strict_types=1);

namespace WebShoppingApp\Model;

use DateTime;
use WebShoppingApp\DataFlow\InputData;

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

    /** @param InputData
     *  @return Order       */
    public static function createFromInputData(InputData $inputData): self
    {
        $idArr = $inputData->getInputs();
        $id = isset($idArr['id']) ? $idArr['id']->value() : uniqid('OrdNu', true);
        $total = (float)(isset($idArr['total']) ? $idArr['total']->value() : 0.0);
        $completedAd = isset($idArr['completed_at']) ? $idArr['completed_at']->value() : new DateTime('now');
        return new Order($id, $total, $completedAd);
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