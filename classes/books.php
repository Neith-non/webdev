<?php
require_once "database.php";

class books extends Database {
    public $id = "";
    public $title = "";
    public $author = "";
    public $genre = "";
    public $publication_year = "";

    protected $db;

    public function __construct() {
        $this->db = new Database(); 
    }

    public function addBooks() {
        $sql = "INSERT INTO books (title, author, genre, publication_year) VALUE (:title, :author, :genre, :publication_year);";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);

        return $query->execute();
    }

    public function viewBooks($search = "", $genre = "") {
        $sql = "SELECT * FROM books WHERE title LIKE CONCAT('%', :search, '%') OR genre LIKE CONCAT('%', :genre, '%') ORDER BY title ASC;";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":search", $search);
        $query->bindParam(":genre", $genre);

        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    public function fetchBooks($bid) { 
        $sql = "SELECT * FROM books WHERE id=:id";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":id", $bid);

        if ($query->execute()) {
            return $query->fetch();
        } else {
            return null;
        }
    }

    public function editBooks($bid) {
        $sql = "UPDATE books SET title=:title, author=:author, genre=:genre, publication_year=:publication_year WHERE id=:id";
        $query = $this->connect()->prepare($sql);

        $query->bindParam(":id", $bid);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);

        return $query->execute();
    }

    public function deleteBooks($bid) {
        $sql = "DELETE FROM books WHERE id = :id";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":id", $bid);

        return $query->execute();
    }
}

$obj = new books();
?>