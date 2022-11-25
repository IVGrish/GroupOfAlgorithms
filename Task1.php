<?php
function testNumberByIf(int $inputNumber): string
{
    if ($inputNumber > 30) {
        return 'More than 30';
    } elseif ($inputNumber > 20) {
        return 'More than 20';
    } elseif ($inputNumber > 10) {
        return 'More than 10';
    } else {
        return 'Equal or less than 10';
    }
}

function testNumberBySwitch(int $inputNumber): string
{
    switch ($inputNumber) {
        case ($inputNumber > 30):
            return 'More than 30';
            break;
        case ($inputNumber > 20):
            return 'More than 20';
            break;
        case ($inputNumber > 10):
            return 'More than 10';
            break;
        default:
            return 'Equal or less than 10';
            break;
    }
}

function testNumberByTernary(int $inputNumber): string
{
    return ($inputNumber > 30) ? 'More than 30' :
          (($inputNumber > 20) ? 'More than 20' :
          (($inputNumber > 10) ? 'More than 10' : 'Equal or less than 10'));
}

echo testNumberByIf(3) . "\n";
echo testNumberBySwitch(15) . "\n";
echo testNumberByTernary(27);