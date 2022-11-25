<?php

class Calculator
{
    public function __construct(private float $a, private float $b = 0)
    {

    }

    public function add(): Calculator
    {
        $add = $this->a + $this->b;
        return new Calculator($add);
    }

    public function subtract(): Calculator
    {
        $subtract = $this->a - $this->b;
        return new Calculator($subtract);
    }

    public function multiply(): Calculator
    {
        $multiply = $this->a * $this->b;
        return new Calculator($multiply);
    }

    public function divide(): Calculator
    {
        try {
            $divide = $this->a / $this->b;
        } catch (Exception $e) {
            echo 'Division by zero';
        }
        return new Calculator($divide);
    }

    public function addBy(float $b): Calculator
    {
        $this->b = $b;
        $add = $this->a + $this->b;
        return new Calculator($add);
    }

    public function subtractBy(float $b): Calculator
    {
        $this->b = $b;
        $subtract = $this->a - $this->b;
        return new Calculator($subtract);
    }

    public function multiplyBy(float $b): Calculator
    {
        $this->b = $b;
        $multiply = $this->a * $this->b;
        return new Calculator($multiply);
    }

    public function divideBy(float $b): Calculator
    {
        $this->b = $b;
        try {
            $divide = $this->a / $this->b;
        } catch (Exception $e) {
            echo 'Division by zero';
        }
        return new Calculator($divide);
    }

    public function __toString(): string
    {
        return "$this->a";
    }
}

$myCalc = new Calculator(12, 6);
echo $myCalc->add() . "\n";
echo $myCalc->multiply() . "\n";
//Calculation by chain
echo $myCalc->add()->divideBy(9) . "\n";