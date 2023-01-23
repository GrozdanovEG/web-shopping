<?php
declare(strict_types=1);

namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;

interface ActionsController
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
    public function handle(InputData $inputData): array;
}