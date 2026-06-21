<?php include 'db.php'; ?>

<h2>Add Book</h2>

<form method="POST">
    Title: <input type="text" name="title" required><br><br>
    Author: <input type="text" name="author" required><br><br>
    Category: <input type="text" name="category"><br><br>
    ISBN: <input type="text" name="isbn"><br><br>
    Quantity: <input type="number" name="quantity"><br><br>

    <button type="submit">Add Book</button>
</form>

<?php
if(isset($_POST['title'])){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $isbn = $_POST['isbn'];
    $quantity = $_POST['quantity'];

    $query = "INSERT INTO books (title, author, category, isbn, quantity)
              VALUES ('$title', '$author', '$category', '$isbn', '$quantity')";

    if(mysqli_query($conn, $query)){
        echo "<p>✅ Book Added Successfully!</p>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>