<?php

require_once "../classes/books.php";
$booksObj = new books();


if($_SERVER["REQUEST_METHOD"] == "GET") {

if (isset($_GET["id"])) {
    $bid = trim(htmlspecialchars($_GET["id"]));
    $books = $booksObj->fetchBooks($bid);

    if (!$books) {
        echo "<a href='viewbooks.php'>View Books</a>";
        exit("No book found");
    } else {
        $booksObj->deleteBooks($bid);
        header("Location: viewbooks.php");
        exit;
    }
} else {
    echo "<a href='viewbooks.php'>View Books</a>";
    exit("No book found");
}

}