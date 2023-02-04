<?php
declare(strict_types=1);
namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;

class Application
{
    private ControllerManager $cm;
    public function __construct(ControllerManager $cm)
    {
        $this->cm = $cm;
    }
    public function run(InputData $inputData): array
    {
        try {
            $output = $this->cm->handle($inputData);
        } catch (Error $e) {
            echo '<div class="message error">Application error occurred! Sorry for the inconvenience!</div>';
            error_log("File: {$e->getFile()} ; Line: {$e->getLine()}: Message:  {$e->getMessage()}");
        } catch (Throwable $th) {
            echo '<div class="message failure">Your request cannot be processed. Check your input and/or try again later!</div>';
            error_log("File: {$th->getFile()} ; Line: {$th->getLine()}: Message:  {$th->getMessage()}");
        }
        return $output  ;
    }
}