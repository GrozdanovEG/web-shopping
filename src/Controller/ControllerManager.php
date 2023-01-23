<?php
declare(strict_types=1);

namespace WebShoppingApp\Controller;
//use WebShoppingApp\DataFlow\UserInput;
use WebShoppingApp\DataFlow\InputData;

final class ControllerManager
{
    /** @var ActionsController[] */
    private array $controllers;

    public function add(ActionsController $controller): self
    {
        $this->controllers[] = $controller;
        return $this;
    }

    public function handle(InputData $inputData): array
    {
        $inputFields = $inputData->getInputs();
        $action = isset($inputFields['action']) ? $inputFields['action']?->value() : '';
        foreach ($this->controllers as $controller) {
            if ($controller->canHandle($action)) {
                return $controller->handle($inputData);
            }
        }
        throw new \InvalidArgumentException('The request cannot be handled! Appropriate controller not found!');
        //echo 'Appropriate controller not found!';
    }
}