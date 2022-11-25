<?php
error_reporting(E_ALL ^ E_WARNING);
class Node
{
    public function __construct (
        private string $item,
        private ?Node $next = null
    ){
    }

    public function getItem() : string
    {
        return $this->item;
    }
    public function getNext() : ?Node
    {
        return $this->next;
    }

    public function setNext(Node $node) : void
    {
        $this->next = $node;
    }
}

class Queue {

    private ?Node $head = null;
    private Node $last;

    public function put(string $item) : void
    {
        $node = new Node($item);
        if ($this->isEmpty())
        {
            $this->head = $node;
            $this->last = $node;
        } else {
            $this->last->setNext($node);
            $this->last = $node;
        }
    }
    public function get() : ?string
    {
        if ($this->isEmpty()) return null;
        $item = $this->head->getItem();
        $this->head = $this->head->getNext();
        return $item;
    }

    protected function getFirst() : ?Node
    {
        return $this->head;
    }

    public function isEmpty() : bool
    {
        return $this->getFirst() == null;
    }

    public function getList() : iterable
    {
        $curr = $this->getFirst();
        while ($curr != null) {
            yield $curr->getItem();
            $curr = $curr->getNext();
        }
    }

    public function current(): ?string
    {
        return $this->head->getItem();
    }

    public function contains(string $item): bool
    {
        foreach ($this->getList() as $curr) {
            if ($curr == $item) {
                return true;
            }
        }
        return false;
    }
}

class Graph
{
    public function __construct(private array $edges = array(array()))
    {

    }

    public function addEdge(string $node1, string $node2,
                            string $length) : void
    {
        $this->edges[$node1][$node2] = $length;
        $this->edges[$node2][$node1] = $length;
    }

    public function getEdges(string $node1) : iterable
    {
        foreach ($this->edges[$node1] as $node => $length) {
            yield $node =>$length;
        }
    }
}

class Json
{
    static public function get($save): string
    {
        $filename = "Paths.json";
        $file_handle = fopen($filename, "a+");
        $comments = fread($file_handle, filesize($filename));
        fclose($file_handle);
        $data = json_decode($comments, true);
        for ($c = 0; $c < count($data); $c++) {
            if ($save == $data[$c]) {
                return $data[$c];
            }
        }

    }

    static public function add(string $data): void
    {
        $file_handle = fopen("Paths.json", "w+");
        if (flock($file_handle, LOCK_EX)) {
            $json = [];
            $i = 0;
            $json[$i++] = $data;
            if (!fwrite($file_handle, json_encode($json))) {
                echo "Can't write to the file";
            }
            flock($file_handle, LOCK_UN);
        }
        fclose($file_handle);
    }

}

class Path
{
    private array  $matrix;
    private string $A;
    private string $B;
    private Graph  $graph;

    public function __construct(private array $a, private array $b)
    {

        $this->graph = new Graph();
        $this->matrix = $this->createMatrix();
        foreach ($this->matrix as $x => $value) {
            foreach ($value as $y => $item) {
                if ($this->a['y'] == $y && $this->a['x'] == $x) {
                    $this->matrix[$x][$y] = "A";
                    $this->A = "$x$y";
                } elseif ($this->b['y'] == $y && $this->b['x'] == $x) {
                    $this->matrix[$x][$y] = "B";
                    $this->B = "$x$y";
                }
            }
        }
        foreach ($this->matrix as $x => $value) {
            foreach ($value as $y => $item) {
                for ($sx = 0; $sx <= 1; $sx++) {
                    $sy = 1 - $sx;
                    if ($x + $sx < 8)
                        if ($y + $sy < 8)
                            $this->graph->addEdge("$x$y", ($x + $sx) .
                                ($y + $sy), $item);
                }
            }
        }
    }

    private function createMatrix(): array
    {
        $array = array(array());
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 10; $j++) {
                $array[$i][$j] = rand(0, 1);
            }
        }
        return $array;
    }

    private function show(array $path, Queue $queue): void
    {
        for ($x = 0; $x < 10; $x++) {
            for ($y = 0; $y < 10; $y++) {
                if (isset($path["$x$y"])) {
                    echo "$x$y ";
                } elseif ($queue->contains("$x$y")) {
                    echo "++ ";
                } else {
                    echo "{$this->matrix[$x][$y]}{$this->matrix[$x][$y]} ";
                }
            }
            echo " <br>\n";
        }
        //foreach ($queue->getList() as $item) {
        //    echo $item . " ";
        //}
        echo  "<br>\n";
        //readline();
    }

    public function walk(): array
    {
        $path = [];
        $queue = new Queue();
        $queue->put($this->A);
        //$this->show($path, $queue);
        while (!$queue->isEmpty()) {
            if ($queue->current() == $this->B) {
                $path[$this->B] = true;
                break;
            }
            $curr = $queue->get();
            $path[$curr] = true;
            foreach ($this->graph->getEdges($curr) as $node2 => $length) {
                if (!$path[$node2] && $length != 1) {
                    if (!$queue->contains($node2)) {
                        $queue->put($node2);
                    }
                }
            }
            //$this->show($path, $queue);
        }

        if (isset($path[$this->B])) {
            echo "Resulting field:\n";
            $this->show($path, $queue);
            echo "From $this->A to $this->B in ",
                count($path) - 1,
            " steps ";
            $sep = '';
            foreach ($path as $key => $value) {
                echo $sep, $key;
                $sep = '->';
            }
            echo "\n";
        }
        else {
            echo "There is no path from $this->A to $this->B\n";
        }
        return $path;
    }
}

$a = array("x" => 2, "y" => 3);
$b = array("x" => 1, "y" => 5);

$path = new Path($a, $b);
print_r($path->walk());

$save = serialize($path);
Json::add($save);
$save = Json::get($save);
$a = unserialize($save);
$a->walk();