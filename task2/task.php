<?php
class TreeNode
{
    //Приватные поля
    private $val;
    private int $left_key;
    private int $right_key;
    private $id;
    private ?array $childs;

    //Контруктор и инициализацией полей
    function __construct($id,$value, $left, $right)
    {
        $this->val = $value;
        $this->left_key = $left;
        $this->right_key = $right;
        $this->id = $id;
        $this->childs = array();
    }

    //геттеры и сеттеры
    public function getVal(){
        return $this->val;
    }

    public function getLeftKey(): ?int
    {
        return $this->left_key;
    }

    public function getId(){
        return $this->id;
    }

    public function getRightKey(): ?int
    {
        return $this->right_key;
    }

    public function setChilds(?array $childs){
        $this->childs = $childs;
    }

    public function getChilds(): ?array{
        return $this->childs;
    }
}

class BinaryTree
{
    //массив, который обозначает дерево
    private array $tree;

    //Контруктор и инициализацией полей
    function __construct()
    {
        $this->tree = array();
    }

    /**
     * @return array
     */
    //геттер для дерева
    public function getTree(): array
    {
        return $this->tree;
    }

    //функция добавления узла в дерево
    public function addNode(TreeNode $node){
        array_push($this->tree, $node);
    }

    //функция, которая возвращает узел(TreeNode) по левому ключу
    public function getNodeByLeftKey($left_key): ?TreeNode
    {
        foreach ($this->tree as $node) {
            if ($node->getLeftKey() === $left_key) {
                return $node;
            }
        }
        return null;
    }

    //функция, которая возвращает все на TreeNode (array), которые на ходятся на уровне с $node переданным в функцию
    public function findBrothersByNode($node):?array{
        $node_array = array();
        if($node === null) return $node_array;
        $left_key_on_node = $node->getLeftKey();
        while (True) {
            $new_node = $this->getNodeByLeftKey($left_key_on_node);
            if($new_node === null) break;
            array_push($node_array, $new_node);
            $left_key_on_node = $new_node->getRightKey()+1;
        }
        return $node_array;
    }

    //функция, которая возвращает все дочерние TreeNode (array) $node переданного в функцию
    public function findChildsByNode($node):?array{
        $childs = $this->findBrothersByNode($this->getNodeByLeftKey($node->getLeftKey()+1));
        return $childs;
    }

    //операция вывода дерева
    public function printTree($node, $level, &$result){
        $print_string = str_repeat("-", $level).$node->getVal();
        array_push($result,$print_string);
        foreach ($node->getChilds() as $node) {
            $this->printTree($node, $level+1,$result);
        }
    }

}

//получение результата из функций
function getResult($file_path){
    $file = fopen($file_path, 'r');
    $tree = new BinaryTree();
    while(!feof($file)){
        $str = fgets($file);
        $data = explode(" ", $str);
        $node = new TreeNode($data[0],  $data[1], intval($data[2]), intval($data[3]));
        $tree->addNode($node);
    }
    foreach ($tree->getTree() as $node){
        $node->setChilds($tree->findChildsByNode($node));
    }
    $result = [];
    foreach ($tree->findBrothersByNode($tree->getNodeByLeftKey(1)) as $node) {
        $tree->printTree($node, 0,$result);
    }
    return $result;
}

//получение ответа из файла
function getGoodAnswer($file_path): ?array {
    $result = array();
    $file=fopen($file_path, 'r');
    while(!feof($file)) {
        $line = fgets($file);
        array_push($result, $line);
    }
    return $result;
}

getResult('./data/7.dat');
