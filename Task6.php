<?php
function stringCapTrim(string $input): string
{
    return str_replace(array(' ', '-', '_'), '',
           ucwords(strtolower(trim($input)), ' -_'));
}

$string = '      The quick-brown_fox jumps over the_lazy-dog     ';
print_r(stringCapTrim($string));