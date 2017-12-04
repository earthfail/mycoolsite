
<?php
session_start();
include_once 'dbh.inc.php';
$target_dir = "../Pictures/Products/";
if(isset($_POST['submit']))
{
    $file=$_FILES['fileToUpload'];
    $fileBaseName=basename($file["name"]);//a dummy variable for ease of use
    $target_file = $target_dir . $fileBaseName;//where to save the image
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $allowed=array('jpg','png','jpeg','gif');
    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    
    // Check if file already exists
    if (file_exists($target_file)) {
	echo "Sorry, file already exists.";
	$uploadOk = 0;
    }
    // Check file size id bigger than 5MB
    if ($file["size"] > 5000000) {
	echo "Sorry, your file is .";
	$uploadOk = 0;
    }
    // Allow certain file formats
    if(!in_array($imageFileType,$allowed))
    {
	echo "Sorry, only ";
	foreach($allowed as $type)
	echo $type." ";
	echo "are allowed";
	$uploadOk=0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.";
	echo "<a href='../upload.html'>click here</a> to try again";
	// if everything is ok, try to upload file
    } else {
	if (move_uploaded_file($file["tmp_name"], $target_file)) {
            echo "The file ". basename( $file["tmp_name"]). " has been uploaded.".PHP_EOL;
	    echo "into file ".$target_file.PHP_EOL;
            $sql="INSERT INTO products (fileName,description,price) VALUES(?,?,?)";
            $stmt=mysqli_stmt_init($conn);
            //prepare the statment
            if(!mysqli_stmt_prepare($stmt,$sql)){
		echo "SQL statment failed! to upload image!";
            }else{
		//bind parameters
		mysqli_stmt_bind_param($stmt,"ssi",$fileBaseName,$_POST["picName"],$_POST["picPrice"]);
		//run parameter inside database
		mysqli_stmt_execute($stmt);
		//return to the main page
		header("Location: ../index.php?content=products");
            }
	} else {
            echo "Sorry, there was an error uploading your file.";
	    echo "<a href='../upload.html'>click here </a>to try again";
            //header("Location: ../message.php?content=imgfailure");
	}
    }
}
?>
