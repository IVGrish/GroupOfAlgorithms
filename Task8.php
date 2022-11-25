<?php

class Matrix
{
    private array $twoArray = array(array());
    private int $rows;
    private int $columns;

    public function __construct(array $arr)
    {
        foreach ($arr as $key => $val) {
            foreach ($val as $clue => $item) {
                if (is_float($item)) {
                    $this->twoArray[$key][$clue] = $item;
                } else {
                    $this->twoArray[$key][$clue] = (float) $item;
                }
            }
        }
        $this->columns = count($this->twoArray);
        $this->rows = count($this->twoArray[0]);
    }

    /**
     * @throws Exception
     */
    public function addition(Matrix $matrix): Matrix
    {
        $newMatrix = array(array());
        if ($this->columns == $matrix->columns &&
            $this->rows == $matrix->rows) {
            for ($i = 0; $i < $this->columns; $i++ ) {
                for($j = 0; $j < $this->rows; $j++) {
                    $newMatrix[$i][$j] = $matrix->twoArray[$i][$j] + $this->twoArray[$i][$j];
                }
            }
        } else {
            throw new Exception('The dimension of the matrix must be the same');
        }
        return new Matrix($newMatrix);
    }

    public function multiplicationByNumber(int $number): Matrix
    {
        $newMatrix = array(array());
        for ($i = 0; $i < $this->columns; $i++ ) {
            for ($j = 0; $j < $this->rows; $j++) {
                $newMatrix[$i][$j] = $this->twoArray[$i][$j] * $number;
            }
        }
        return new Matrix($newMatrix);
    }

    /**
     * @throws Exception
     */
    public function multiplicationByMatrix(Matrix $matrix): Matrix
    {
        $newMatrix = array(array());
        for ($i = 0; $i < $this->columns; $i++) {
            for ($j = 0; $j < $matrix->rows; $j++) {
                $newMatrix[$i][$j] = 0;
            }
        }
        if ($this->rows == $matrix->columns) {
            for ($i = 0; $i < $this->columns; $i++) {
                for ($j = 0; $j < $matrix->rows; $j++) {
                    for ($k = 0; $k < $matrix->columns; $k++) {
                        $newMatrix[$i][$j] += $this->twoArray[$i][$k] * $matrix->twoArray[$k][$j];
                    }
                }
            }
        } else {
            throw new Exception('The number of columns of one matrix must equal' .
                                'the number of another matrix');
        }
        return new Matrix($newMatrix);
    }

    public function output(): Matrix
    {
        return $this;
    }
}

function randArr(int $n, float $min = 0, float $max = 100): array
{
    $array = array(array());
    $v1 = range(0, $n-1);
    $v2 = range(0, $n-1);

    foreach ($v1 as $x => $value) {
        foreach ($v2 as $y) {
            $array[$y][$x] = ($min + ($max - $min) * (rand() / getrandmax()));
        }
    }
    return $array;
}

$matrix = new Matrix(randArr(5));

try {
    print_r($matrix->addition(new Matrix(randArr(5))));
} catch (Exception $e) {
    echo 'An exception is thrown: '.  $e->getMessage(). "\n";
}

print_r($matrix->multiplicationByNumber(4));

try {
    print_r($matrix->multiplicationByMatrix(new Matrix(randArr(5))));
} catch (Exception $e) {
    echo 'An exception is thrown: '.  $e->getMessage(). "\n";
}

print_r($matrix->output());