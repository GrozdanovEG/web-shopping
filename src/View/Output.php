<?php
declare(strict_types=1);

namespace WebShoppingApp\View;

abstract class Output
{
    protected Listable $entity;

    public function __construct(Listable $entity)
    {
        $this->entity = $entity;
    }

    public function __toString(): string
    {
        return $this->entity->render();
    }
}