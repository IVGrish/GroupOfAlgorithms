<?php
function digitsFromOneToAnother (int $a, int $b): int
{
    if ($a < $b) {
        echo "$a";
        return digitsFromOneToAnother(++$a, $b);
    } elseif ($a > $b) {
        echo "$a";
        return digitsFromOneToAnother(--$a, $b);
    } else {
        echo "$b";
        return $b;
    }
}

digitsFromOneToAnother(9, 4);