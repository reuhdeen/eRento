<?php

// Connect to the database
$dsn = "mysql:host=localhost;dbname=erento";
$username = "root";
$password = "erento";
$pdo = new PDO($dsn, $username, $password);

// Retrieve the filename from the query string
$filename = $_GET['filename'];

// Retrieve the file data from the database
$stmt = $pdo->prepare("SELECT filedata, filetype, filesize FROM erento.files WHERE filename = ?");
$stmt->execute([$filename]);
$file = $stmt->fetch(PDO::FETCH_ASSOC);

// Set the content-type header based on the filetype
header("Content-type: " . $file['filetype']);

// Set the content-disposition header to trigger a download
header("Content-disposition: attachment; filename=\"" . $filename . "\"");

// Output the file data to the user
echo $file['filedata'];

?>