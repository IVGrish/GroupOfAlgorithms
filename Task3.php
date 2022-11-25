<?php
function singleDigit(int $number): array
{
    $stringNumber = (string) $number;
    $length = strlen($stringNumber);
    if ($length == 1) {
        return [];
    }
    $sum = 0;
    for ($x = 0; $x <= $length; $x++) {
        $sum += (int) substr($stringNumber, $x, 1);
    }
    return [$sum, singleDigit($sum)];
}
print_r(singleDigit(5689));