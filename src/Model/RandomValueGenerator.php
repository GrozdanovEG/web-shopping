<?php
declare(strict_types=1);
namespace WebShoppingApp\Model;

class RandomValueGenerator
{
     private string $digits = '0123456789';
     private string $alphaLetters = 'ABCDEFGHEJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
     private int $stringSizeLimit = 512;

    public function number(int $min = 10, int $max = 10): string
    {
        $chars = $this->digits;
        return $this->generate($chars, $min, $max);
    }

    public function alpha(int $min = 10, int $max = 10): string
    {
        $chars = $this->alphaLetters;
        return $this->generate($chars, $min, $max);
    }

    public function mixed(int $min = 10, int $max = 10): string
    {
        $chars = $this->alphaLetters . $this->digits;
        return $this->generate($chars, $min, $max);
    }

    private function generate(string $chars, int $min, int $max): string
    {
        /* @todo handling scenario with user input where $min > $max
         * consulting with https://www.php.net/manual/en/function.rand.php */
        while($max > strlen($chars) &&
              strlen($chars) <= $this->stringSizeLimit) $chars .= $chars;

        //$maxSizeAllowed = strlen($chars);
        //if ($max > $maxSizeAllowed) $max = $maxSizeAllowed;
        $min = max($min, 0);

        return substr(str_shuffle($chars), 0, rand($min, $max));
    }

    public function numbersStats(): string
    {
        $chars = $this->digits;
        return '['.strlen($chars).":{$chars}]";
    }

    public function alphaStats(): string
    {
        $chars = $this->alphaLetters;
        return '['.strlen($chars).":{$chars}]";
    }

    public function charsStats(): string
    {
        $chars = $this->alphaLetters . $this->digits;
        return '['.strlen($chars).":{$chars}]";
    }

}