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
     	$folder = "img/";
        $filename = $_FILES['property_images']['name'][$i];
        $target_file = $folder . basename($filename);
        $tempname = $_FILES['property_images']['tmp_name'][$i];
        

        move_uploaded_file($tempname,$target_file);
        $property_images[] = $filename;
        echo $filename;
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
	  <input type="file" name="property_images[]" multiple>
	  <br>
	  <input type="submit" value="Add Property" name="addp">
	</form>
<br><br>
<?php
	$query = "SELECT * FROM property";
	$result = mysqli_query($db,$query);

	// Loop through the properties and display their images
	while($row = mysqli_fetch_assoc($result)){
	   $property_id = $row['property_id'];
	   $property_images = explode(',',$row['property_image']);

	   // Display the property ID
	   echo "<h2>Property ID: $property_id</h2>";

	   // Loop through the property images and display them
	   foreach($property_images as $image){
	   	echo $image;
	      echo "<img src='img/" .$image. "'>";
	   }
	}

?> 
</body>
</html>