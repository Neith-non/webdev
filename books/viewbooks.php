<?php
require_once "../classes/books.php";

$booksObj = new books();
$search = $genre = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $search = isset($_GET["search"]) ? trim(htmlspecialchars($_GET["search"])) : "";
    $genre = isset($_GET["genre"]) ? trim(htmlspecialchars($_GET["genre"])) : "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
</head>
<body>
    <h1>Books</h1>
    <form action="" method="get">
        <label for="">Search: </label>
        <input type="search" name="search" id="search" value="<?= $search ?>">
        <select name="genre" id="genre">
            <option value="">--ALL--</option>
            <option value="history" <?= ($genre === "history") ? 'selected' : '' ?>>History</option>
            <option value="science" <?= ($genre === "science") ? 'selected' : '' ?>>Science</option>
            <option value="fiction" <?= ($genre === "fiction") ? 'selected' : '' ?>>Fiction</option>
        </select>
        <input type="submit" value="Search">
    </form>

    <h1>Books Lists</h1>
    <button><a href="addbooks.php">Add Books</a></button>
    <table border="1">
        <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Publication Year</th>
            <th>Actions</th>
        </tr>
        <?php
        $results = $booksObj->viewBooks($search, $genre);
        if ($results) {
            foreach ($results as $book) 
                $message = "Are you sure you want to delete the book: " . $book["title"] . "?";
        ?>
            <tr>
                <td><?= $book["id"] ?></td>
                <td><?= $book["title"] ?></td>
                <td><?= $book["author"] ?></td>
                <td><?= $book["genre"] ?></td>
                <td><?= $book["publication_year"] ?></td>
                <td>
                    <a href="editbooks.php?id=<?= $book["id"] ?>">Edit</a>
                    <a href="deletebooks.php?id=<?= $book["id"] ?>" onclick="return confirm('<?= $message ?>')">Delete</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>