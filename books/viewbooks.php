<?php
require_once "../classes/addproduct.php";
$bookObj = new Books();
$books = $bookObj->viewBook();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Books</title>
</head>
<body>
    <button><a href="addbooks.php">Add New Book</a></button>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>TITLE</th>
            <th>AUTHOR</th>
            <th>GENRE</th>
            <th>PUB_YEAR</th>
            <th>Action</th>
        </tr>

        <?php foreach ($books as $row): ?>
            <?php $message = "Are you sure you want to delete the book '" . $row["title"] . "'?"; ?>
            <tr>
                <td><?= htmlspecialchars($row["id"]) ?></td>
                <td><?= htmlspecialchars($row["title"]) ?></td>
                <td><?= htmlspecialchars($row["author"]) ?></td>
                <td><?= htmlspecialchars($row["genre"]) ?></td>
                <td><?= htmlspecialchars($row["pub_year"]) ?></td>
                <td>
                    <a href="editproduct.php?id=<?= $row["id"] ?>">Edit</a> | 
                    <a href="deletebooks.php?id=<?= $row["id"] ?>" onclick="return confirm('<?= $message ?>')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
