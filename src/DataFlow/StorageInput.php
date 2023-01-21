<?php

namespace WebShoppingApp\DataFlow;

class StorageInput implements InputData
{
    private array $inputs = [];

    public function __construct(array $results)
    {
        $this->collectInputs($results);
    }

    private function collectInputs(array $results): void
    {
        $inputType = 'storage_input';
        $queryKeys = array_keys($results);
        foreach ($queryKeys as $key) {
            $value = $results[$key];

            $snakeCaseFormattedKey = str_replace('-', '_', $key);
            if (!isset($this->inputs[$snakeCaseFormattedKey])) $key = $snakeCaseFormattedKey;

            $this->inputs[$key] = new InputField($inputType, $value);
        }
    }

    /**
     * @inheritDoc
     */
    public function getInputs(): array
    {
        return $this->inputs;
    }
}