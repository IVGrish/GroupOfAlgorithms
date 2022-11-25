<?php
function arrayDeleteN(array $arr, int $position): array
{
    unset($arr[$position]);
    print_r($arr);
    foreach ($arr as $key => $val) {
        if (($position + 1) == $key) {
            $arr[$key - 1] = $val;
            $position++;
        }
    }
    ksort($arr);
    array_pop($arr);
    return $arr;
}

print_r(arrayDeleteN([1, 2, 3, 4, 5], 3));