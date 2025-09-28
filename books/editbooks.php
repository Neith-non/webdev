<?php
require_once "../classes/books.php";
$booksObj = new books();

$books = [];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $bid = trim(htmlspecialchars($_GET["id"]));
        $books = $booksObj->fetchBooks($bid);

        if (!$books) {
            echo "<a href='viewbooks.php'>View Books</a>";
            exit("No book found");
        }
    } else {
        echo "<a href='viewbooks.php'>View Books</a>";
        exit("No book selected");
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bid = trim(htmlspecialchars($_POST["id"]));
    $books["title"] = trim(htmlspecialchars($_POST["title"]));
    $books["author"] = trim(htmlspecialchars($_POST["author"]));
    $books["genre"] = trim(htmlspecialchars($_POST["genre"]));
    $books["publication_year"] = trim(htmlspecialchars($_POST["publication_year"]));

    if (empty($books["title"])) {
        $errors["title"] = "Title is Required";
    }

    if (empty($books["author"])) {
        $errors["author"] = "Author is Required";
    }

    if (empty($books["genre"])) {
        $errors["genre"] = "Please select a Genre";
    }

    if (empty($books["publication_year"])) {
        $errors["publication_year"] = "Year Published is required";
    } elseif ($books["publication_year"] > 2025) {
        $errors["publication_year"] = "Year must not be in the future";
    }

    if (array_filter($errors)) {
        $booksObj->title = $books["title"];
        $booksObj->author = $books["author"];
        $booksObj->genre = $books["genre"];
        $booksObj->publication_year = $books["publication_year"];

        if ($booksObj->editBooks($bid)) {
            header("Location: viewbooks.php");
            exit;
        } else {
            echo "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Books</title>
    <style>
        label { display: block; }
        .error, span { color: red; margin: 0; }
    </style>
</head>
<body>
    <h1>Edit Books</h1>
    <label for="">Field with <span>*</span> is required</label>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $books["id"] ?? "" ?>">
        
        <label for="title">Title: </label>
        <input type="text" name="title" value="<?= $books["title"] ?? "" ?>">
        <p class="error"><?= $errors["title"] ?? "" ?></p>

        <label for="author">Author: </label>
        <input type="text" name="author" value="<?= $books["author"] ?? "" ?>">
        <p class="error"><?= $errors["author"] ?? "" ?></p>

        <label for="genre">Select Genre: </label>
        <select name="genre" id="genre">
            <option value="">--Select--</option>
            <option value="history" <?= (isset($books["genre"]) && $books["genre"] === "history") ? 'selected' : '' ?>>History</option>
            <option value="science" <?= (isset($books["genre"]) && $books["genre"] === "science") ? 'selected' : '' ?>>Science</option>
            <option value="fiction" <?= (isset($books["genre"]) && $books["genre"] === "fiction") ? 'selected' : '' ?>>Fiction</option>
        </select>
        <p class="error"><?= $errors["genre"] ?? "" ?></p>

        <label for="publication_year">Publication Year: </label>
        <input type="number" name="publication_year" value="<?= $books["publication_year"] ?? "" ?>">
        <p class="error"><?= $errors["publication_year"] ?? "" ?></p>

        <button type="submit">Update</button>
    </form>
</body>
</html>