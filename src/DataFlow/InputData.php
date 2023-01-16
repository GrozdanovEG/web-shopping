<?php
declare(strict_types=1);

namespace WebShoppingApp\DataFlow;

interface InputData
{
    /** @return InputField[]   */
    public function getInputs(): array;
}