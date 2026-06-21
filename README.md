Online Library Catalog

A web-based library management system built with PHP and MySQL. Users can browse and search books, log in, and manage the book catalog.

Features

- User login system ("login.php")
- Browse and search book catalog ("view.php")
- Add new books to the catalog ("add.php")
- MySQL database integration for persistent storage

Tech Stack

- Backend: PHP
- Database: MySQL
- Frontend: HTML, CSS, Bootstrap 5

Setup Instructions

Prerequisites

- XAMPP (or any local server with PHP + MySQL)

Steps

1. Clone this repository

git clone https://github.com/Anahita182Chaudhary/Project.git

2. Move the project folder

Copy the project folder into:

C:\xampp\htdocs\

3. Start XAMPP

Open XAMPP Control Panel and start:

- Apache
- MySQL

4. Create the Database

Open:

http://localhost/phpmyadmin

Create a database named:

library_db

5. Import the Database

Select the "library_db" database and import the file:

library_db.sql

6. Run the Project

Open your browser and visit:

http://localhost/library

Project Structure

library/
├── add.php
├── db.php
├── index.php
├── login.php
├── view.php
├── library_db.sql
├── books/
├── images/
└── README.md

Author

Anahita Chaudhary