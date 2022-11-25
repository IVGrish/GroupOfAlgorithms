<?php
function validUrl(string $url): string
{
    $reg = "#https://[a-zA-Z]{2,256}\.[a-z]{2,6}/#";
    if (preg_match($reg, $url)) {
        return "OK\n";
    } else {
        return "Not a valid URL\n";
    }
}
$invalid = "htps://innowise,com/";
$valid = "https://innowise.com/";
print_r(validUrl($invalid));
print_r(validUrl($valid));