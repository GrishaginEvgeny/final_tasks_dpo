<?php
phpinfo();
class TreeNode
{
    private $val;
    private int $left_key;
    private int $right_key;
    private $id;
    private array $childs;


    function __construct($id,$value, $left, $right)
    {
        $this->val = $value;
        $this->left_key = $left;
        $this->right_key = $right;
        $this->id = $id;
        $this->childs = array();
    }

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

    public function setChilds(array $childs){
        $this->childs = $childs;
    }

    public function getChilds(): ?array{
        return $this->childs;
    }
}

class BinaryTree
{
    private array $tree;

    function __construct()
    {
        $this->tree = array();
    }

    /**
     * @return array
     */
    public function getTree(): array
    {
        return $this->tree;
    }

    public function addNode(TreeNode $node){
        array_push($this->tree, $node);
    }

    public function getNodeByLeftKey($left_key): ?TreeNode
    {
        foreach ($this->tree as $node) {
            if ($node->getLeftKey() === $left_key) {
                return $node;
            }
        }
        return null;
    }

    public function findBrothersByNode($node):?array{
        var_dump($node);
        $node_array = array();
        $left_key_on_node = $node->getLeftKey();
        while (True) {
            $new_node = $this->getNodeByLeftKey($left_key_on_node);
            if($new_node === null) break;
            array_push($node_array, $new_node);
            $left_key_on_node = $new_node->getRightKey()+1;
        }
        return $node_array;
    }

    public function findChildsByNode($node):?array{
        $childs = $this->findBrothersByNode($this->getNodeByLeftKey($node->getLeftKey()+1));
        return $childs;
    }

    public function printTree($node, $level){
        //var_dump($this->tree);
        $print_string = str_repeat("-", $level).$node->getVal()."\n";
        print_r($print_string);
        foreach ($node->getChilds() as $node) {
            $this->printTree($node, $level+1);
        }
    }

}

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

    foreach ($tree->findBrothersByNode($tree->getNodeByLeftKey(1)) as $node) {
        $tree->printTree($node, 0);
    }
}

getResult('./data/7.dat');
