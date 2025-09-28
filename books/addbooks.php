<?php
require_once "../classes/addproduct.php";
$bookObj = new Books();


$books = [];
$errors = []; 


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // sanitize
    $books["title"] = trim(htmlspecialchars($_POST["title"]));
    $books["author"] = trim(htmlspecialchars($_POST["author"]));
    $books["genre"] = trim(htmlspecialchars($_POST["genre"]));
    $books["pub_year"] = trim(htmlspecialchars($_POST["pub_year"]));

    // validation
    if (empty($books["title"])) {
        $errors["title"] = "This field *Title* is required";
    } 
    


    if (empty($books["author"])) {
        $errors["author"] = "This field *Author* is required";
    } elseif(!preg_match("/^[a-zA-Z\s]+$/", $books["author"])) {
        $errors["author"] = "This field does not contaion numbers";
    }

    if (empty($books["genre"])) {
        $errors["genre"] = "Please select *Genre* (required)";
    }

    $current_year = date("Y");
    if (empty($books["pub_year"])) {
        $errors["pub_year"] = "This field *Publication Year* is required";
    } elseif ($books["pub_year"] > $current_year) {
        $errors["pub_year"] = "Publication year cannot be in the future";
    }

    
    if (empty(array_filter($errors))) {
        $bookObj->title = $books["title"];
        $bookObj->author = $books["author"];
        $bookObj->genre = $books["genre"];
        $bookObj->pub_year = $books["pub_year"];

        if ($bookObj->addBook()) {
            header("Location: viewbooks.php");
            exit;
        } else {
            echo " Failed to add book";
        }
    }
}

    


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            width: 350px;
            background: #fff;
            padding: 20px 25px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        h4 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
            color: #333;
        }

        label {
            display: block;
            margin: 8px 0 5px;
            font-weight: bold;
            font-size: 14px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 8px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #b9b8b8ff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background: #e25a34;
        }

        .error {
            color: red;
            font-size: 12px;
            margin-top: -5px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <form action="" method="post"> 
        <h4>ADDING BOOK LIBRARY SYSTEM</h4>

        <label for="title">Title <span>*</span></label>
        <input type="text"  name="title" id="title" value="<?= $books["title"] ?? "" ?>">
        <p class="error"><?= $errors["title"] ?? "" ?></p>

        <label for="author">Author <span>*</span></label>
        <input type="text" name="author" id="author" value="<?= $books["author"] ?? ""?>">
        <p class="error"><?= $errors["author"] ?? ""?></p>

        <label for="genre">Genre <span>*</span></label>
        <select name="genre" id="genre">
            <option value="">---- SELECT GENRE ----</option>
            <option value="Science"<?= (isset($books["genre"])  && $books["genre"] == 'Science') ? "selected":""?>">Science</option>
            <option value="History<?= (isset($books["genre"]) && $books["genre"] == 'History') ? "selected":""?>">History</option>
            <option value="Fiction"<?= (isset($books["genre"]) && $books["genre"] == 'Fiction') ? "selected":""?>">Fiction</option>
        </select>
        <p class="error"><?= $errors["genre"]  ?? ""?></p>

        <label for="pub_year">Publication Year <span>*</span></label>
        <input type="text" name="pub_year" id="year" value="<?= $books["pub_year"] ?? "" ?>">
        <p class="error"><?= $errors["pub_year"] ?? "" ?></p>

        <input type="submit" value="Add Book">
    </form>
</body>
</html>
