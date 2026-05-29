<?php 
require_once ("Models/Category.php"); 

class CategoryRepository {
    private PDO $pdo; 

    function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    function getAllCategories(): array
    {
        return $this->pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_CLASS, 'Category');
    }

}
?>