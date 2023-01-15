<?php

namespace WebShoppingApp\DataFlow;

class InputField
{
    private string $method;
    private mixed $value;

    public function __construct(string $method, mixed $value)
    {
        $this->setMethod($method);
        $this->setValue($value);
    }

    public function method(): string
    {
        return $this->method;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->method.':'.$this->value;
    }

    /* Protected access for values modification */
    protected function setMethod(string $method): void
    {
        $this->method = $method;
    }
    protected function setValue(mixed $value): void
    {
        $this->value = $value;
    }
}