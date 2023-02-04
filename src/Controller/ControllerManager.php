<?php
declare(strict_types=1);

namespace WebShoppingApp\Controller;
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
        error_log('Request {'.$action.'} cannot be handled.');
        throw new \InvalidArgumentException('No appropriate controller not found!');
    }
}