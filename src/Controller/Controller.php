<?php
declare(strict_types=1);

use WebShoppingApp\DataFlow\InputData;

interface Controller
{
    /**
     * @param string $action
     * @return bool
     */
    public function canHandle(string $action): bool;

    /**
     * @param InputData $InputData
     * @return array
     */
    public function handle(InputData $InputData): array;
}