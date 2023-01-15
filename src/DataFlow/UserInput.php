<?php
declare(strict_types=1);
namespace WebShoppingApp\DataFlow;

use WebShoppingApp\DataFlow\InputData;

class UserInput implements InputData
{
    /** @var InputField[]  */
    private array $inputs = [];

    public function __construct()
    {
        $this->collectInputs('GET');
        $this->collectInputs('POST');
    }

    /** @return InputField[]  */
    public function returnPostInputs(): array
    {
        return array_filter($this->getInputs(),
                            function($i) {return $i->method() === 'post';});
    }

    /** @return InputField[]  */
    public function returnGetInputs(): array
    {
        return array_filter($this->getInputs(), function($i) {return $i->method() === 'get';});
    }

    private function collectInputs(string $type): void
    {
        [$inputArray, $inputType] = $this->filterInputFieldsByMethod($type);
        $queryKeys = isset($inputArray) ? array_keys($inputArray) : null;
        $type = strtolower($type);
        if ($queryKeys !== null)
            foreach ($queryKeys as $qKey) {
                $value = htmlentities(filter_input($inputType, $qKey));

                $snakeCaseFormattedKey = str_replace('-', '_', $qKey);
                if(! isset($this->inputs[$snakeCaseFormattedKey]) ) $qKey = $snakeCaseFormattedKey;

                $this->inputs[$qKey] = new InputField($type, $value);
            }
    }

    private function filterInputFieldsByMethod(string $type): array
    {
        switch (strtolower($type)) {
            case 'post':
                $inputArray = $_POST;
                $inputType = INPUT_POST;
                break;
            case 'get':
                $inputArray = $_GET;
                $inputType = INPUT_GET;
                break;
            default:
                throw new InvalidArgumentException("Invalid input type requested");
                break;
        }
        return [$inputArray, $inputType];
    }

    /* unused for now */
    public function replaceField(string $key,InputField $field): bool {
        if ($this->inputs[$key] = $field) return true;
        return false;
    }

    /** @return InputField[]   */
    public function getInputs(): array {
        return $this->inputs;
    }

}
