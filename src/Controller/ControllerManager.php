<?php
declare(strict_types=1);

namespace WebShoppingApp\Controller;

final class ControllerManager
{
    /** @var Controller[] */
    private array $controllers;

    public function add(Controller $controller): self
    {
        $this->controllers[] = $controller;
        return $this;
    }

    public function handle(InputData $inputData): array
    {
        $action = $inputData->getInputs()['action'] ?? '';
        foreach ($this->controllers as $controller) {
            if ($controller->canHandle($action)) {
                return $controller->handle($inputData);
            }
        }
        throw new \InvalidArgumentException('The request cannot be handled!');
    }
}