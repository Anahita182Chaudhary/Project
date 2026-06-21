<?php include 'db.php'; ?>

<h2>📚 Book List</h2>

<?php
$query = "SELECT * FROM books";
$result = mysqli_query($conn, $query);

if(!$result){
    die("Query Failed: " . mysqli_error($conn));
}

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        echo "<b>Title:</b> " . $row['title'] . "<br>";
        echo "<b>Author:</b> " . $row['author'] . "<br>";
        echo "<b>Category:</b> " . $row['category'] . "<br>";
        echo "<b>ISBN:</b> " . $row['isbn'] . "<br>";
        echo "<b>Quantity:</b> " . $row['quantity'] . "<br>";
        echo "-----------------------------<br>";
    }
} else {
    echo "No books found!";
}
?>