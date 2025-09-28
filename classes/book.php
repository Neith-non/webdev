<?php
include "database.php";

class Books {
    public $id = "";
    public $title = "";
    public $author = "";
    public $genre = "";
    public $publication = "";

    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addBook() {
        $sql = "INSERT INTO books (title, author, genre, publication) 
                VALUES (:title, :author, :genre, :publication)";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication", $this->year);

        return $query->execute();
    }

    public function viewBook() {
        $sql = "SELECT * FROM books";
        $query = $this->db->connect()->prepare($sql);

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }
}

$obj = new Books();
