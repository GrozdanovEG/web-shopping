<?php
declare(strict_types=1);

namespace WebShoppingApp\DataFlow;
use WebShoppingApp\DataFlow\InputField;

interface InputData
{
    /** @return InputField[] */
    public function getInputs(): array;
}