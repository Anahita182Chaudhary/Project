<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Online Library Catalog</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('images/main-bg.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        /* DARK OVERLAY */
        .overlay {
            background: rgba(0,0,0,0.6);
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar {
            background: rgba(59, 36, 20, 0.9);
            padding: 15px 30px;
        }
        .navbar a {
            color: white !important;
            text-decoration: none;
        }

        /* HERO */
        .hero {
            background: 
                linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                url('images/hero.jpg');
            background-size: cover;
            background-position: center;
            height: 420px;
            display: flex;
            align-items: center;
            padding: 50px;
            color: white;
        }

        .hero h1 {
            font-size: 42px;
            font-weight: bold;
        }

        /* SEARCH */
        .search-box {
            margin-top: -40px;
        }

        /* GLASS BOOK SECTION */
        .books-section {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        .section-title {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            color: white;
        }

        /* CARDS */
        .card {
            border-radius: 15px;
            transition: 0.3s;
            cursor: pointer;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(5px);
            border: none;
        }

        .card:hover {
            transform: translateY(-8px) scale(1.03);
        }

        .card img {
            height: 220px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            top:0; left:0;
            width:100%; height:100%;
            background: rgba(0,0,0,0.7);
            justify-content: center;
            align-items: center;
            z-index:1000;
        }

        .modal-content {
            position: relative;
            width: 400px;
            max-width: 90%;
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }

        .modal img {
            width: 100%;
            border-radius: 10px;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 25px;
            cursor: pointer;
        }

        .btn-pdf {
            margin-top: 15px;
            width: 100%;
        }

        /* PDF Modal */
        #pdfModal iframe {
            width: 100%;
            height: 500px;
            border: none;
        }

        #pdfModal .modal-content {
            width: 80%;
            max-width: 900px;
        }
    </style>
</head>

<body>
<div class="overlay">

<!-- NAVBAR -->
<nav class="navbar d-flex justify-content-between align-items-center">
    <span class="text-white fw-bold fs-4">📚 Library</span>

    <div>
        <a href="#" class="me-3">Home</a>
        <button class="btn btn-outline-light me-2">Login</button>
        <button class="btn btn-warning">Sign Up</button>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div>
        <h1>Discover a World of Knowledge</h1>
        <p>Explore books, journals, and digital resources to inspire your mind.</p>
    </div>
</section>

<!-- SEARCH -->
<div class="container search-box">
    <form method="GET" class="d-flex shadow p-3 bg-white rounded">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by title or author">
        <button class="btn btn-dark">Search</button>
    </form>
</div>

<!-- BOOK SECTION -->
<div class="container my-5">
    <div class="books-section">

        <h2 class="section-title">📖 Discover Our Collection</h2>

        <?php
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            echo "<h5 class='text-center text-white mb-4'>Showing results for: <b>$search</b></h5>";
        }

        $query = isset($_GET['search']) ? 
                 "SELECT * FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%'" : 
                 "SELECT * FROM books";

        $result = mysqli_query($conn, $query);
        if(!$result) { die("Query Failed: " . mysqli_error($conn)); }
        ?>

        <div class="row">
        <?php if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){ ?>
            <div class="col-md-3 mb-4">
                <div class="card p-3 shadow-sm"
                    onclick="openBookModal('<?php echo $row['image_path']; ?>', '<?php echo $row['file_path']; ?>', '<?php echo addslashes($row['title']); ?>', '<?php echo addslashes($row['author']); ?>', '<?php echo addslashes($row['isbn']); ?>', '<?php echo addslashes($row['category']); ?>', '<?php echo $row['quantity']; ?>')">

                    <img src="<?php echo $row['image_path']; ?>">
                    <h6 class="mt-2"><?php echo $row['title']; ?></h6>
                    <small><b>Author:</b> <?php echo $row['author']; ?></small>

                </div>
            </div>
        <?php } } else {
            echo "<h4 class='text-center text-white'>No books found 😔</h4>";
        } ?>
        </div>

    </div>
</div>

<!-- Book Modal -->
<div id="bookModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeBookModal()">&times;</span>
        <img id="bookImage" src="">
        <h5 id="modalTitle"></h5>
        <p><b>Author:</b> <span id="modalAuthor"></span></p>
        <p><b>ISBN:</b> <span id="modalISBN"></span></p>
        <p><b>Category:</b> <span id="modalCategory"></span></p>
        <p><b>Available:</b> <span id="modalQuantity"></span></p>
        <button class="btn btn-primary btn-pdf" onclick="openPDF()">Open PDF</button>
    </div>
</div>

<!-- PDF Modal -->
<div id="pdfModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePDFModal()">&times; Back</span>
        <iframe id="pdfFrame"></iframe>
    </div>
</div>

<script>
let currentPDF = '';

function openBookModal(imagePath, pdfPath, title, author, isbn, category, quantity){
    document.getElementById('bookImage').src = imagePath;
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalAuthor').innerText = author;
    document.getElementById('modalISBN').innerText = isbn;
    document.getElementById('modalCategory').innerText = category;
    document.getElementById('modalQuantity').innerText = quantity;
    document.getElementById('bookModal').style.display = 'flex';
    currentPDF = pdfPath;
}

function closeBookModal(){
    document.getElementById('bookModal').style.display = 'none';
}

function openPDF(){
    document.getElementById('pdfFrame').src = currentPDF;
    document.getElementById('pdfModal').style.display = 'flex';
}

function closePDFModal(){
    document.getElementById('pdfFrame').src = '';
    document.getElementById('pdfModal').style.display = 'none';
}

window.onclick = function(event){
    if(event.target === document.getElementById('bookModal')) closeBookModal();
    if(event.target === document.getElementById('pdfModal')) closePDFModal();
}
</script>

</div>
</body>
</html>