<!DOCTYPE html>
<html>

<?php
session_start();
// Connect to the database

include 'db.php';

$property_images = array();
if(isset($_POST['addp'])){
// Get the form data
$property_name = mysqli_real_escape_string($db, $_POST['property_name']);
$property_type = mysqli_real_escape_string($db, $_POST['property_type']);

$count = count($_FILES['property_images']['name']);

     for($i=0;$i<$count;$i++){
        $filename = $_FILES['property_images']['name'][$i];
        $tempname = $_FILES['property_images']['tmp_name'][$i];
        $folder = "../img";

        move_uploaded_file($tempname,$folder.$filename);
        $property_images[] = $filename;
     }
// $image = $_FILES['image']['name'];
// if (!empty($image)) {
//   $target_dir = "../img";
//   $target_file = $target_dir . basename($image);
//   move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
// }

// Insert the property into the database
     $images = implode(',',$property_images);
$sql = "INSERT INTO property (property_name, property_type, property_image) VALUES ('$property_name', '$property_type', '$images')";
mysqli_query($db, $sql);

// Redirect back to the form
echo "added successfuly";
}
?>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

	<form method="post" action="" enctype="multipart/form-data">
	  <label for="property_name">Property Name:</label>
	  <input type="text" name="property_name" required>
	  <br>
	  <label for="property_type">Property Type:</label>
	  <input type="text" name="property_type" required>
	  <br>
	  <label for="image">Image:</label>
	  <input type="file" name="property_image">
	  <br>
	  <input type="submit" value="Add Property" name="addp">
	</form>

</body>
</html>