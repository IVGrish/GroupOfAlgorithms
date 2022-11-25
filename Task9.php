<?php

abstract class University
{
    public function __construct(protected string $firstName,
                                protected string $lastName,
                                protected int    $group,
                                protected float  $averageMark)
    {

    }

    public function setAverageMark(float $mark): void
    {
        $this->averageMark = $mark;
    }

    public function show(): string
    {
        return implode(" \n", get_object_vars($this));
    }

    abstract public function getScholarship(): string;
}

class Student extends University
{
    public function researchWork(string $work): string
    {
        foreach ($GLOBALS as $k => $v) {
            if ($v === $this) {
                $GLOBALS[$k] = new Aspirant($this->firstName, $this->lastName,
                                            $this->group,     $this->averageMark);
                break;
            }
        }
        return 'Congratulations! You are now a graduate student.';
    }

    public function getScholarship(): string
    {
        // TODO: Implement getScholarship() method.
        if ($this->averageMark == 5) {
            return "100 USD";
        } else {
            return "80 USD";
        }
    }
}

class Aspirant extends University
{
    public function getScholarship(): string
    {
        // TODO: Implement getScholarship() method.
        if ($this->averageMark == 5) {
            return "200 USD";
        } else {
            return "180 USD";
        }
    }
}

function generateString($strength = 7): string
{
    $input = 'abcdefghilkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for($i = 0; $i < $strength; $i++) {
        $randomChar = $input[rand(0, strlen($input) - 1)];
        $randomString .= $randomChar;
    }
    return $randomString;
}

function createStudents($n): array
{
    $students = array();
    $v1 = range(0, $n-1);
    foreach ($v1 as $x => $value)  {
            if (rand(0, 1)) {
                $university = "Student";
            } else {
                $university = "Aspirant";
            }
            $students[$x] = new $university(generateString(), generateString(),
                                            rand(100000, 999999), rand(1, 5));
        }
    return $students;
}

$group = createStudents(5);

function getStudents(array $students) : iterable
{
    foreach ($students as $edge) {
        yield $edge->show();
    }
    foreach ($students as $edge) {
        yield $edge->getScholarship();
    }
}

foreach (getStudents($group) as $node) {
    echo $node . "\n";
}