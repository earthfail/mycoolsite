<?php
include_once 'includes/dbh.inc.php';
session_start();
/* if(!isset($_SESSION['permission']) or ($_SESSION['permission']!='employee' and $_SESSION['permission']!='admin'))
 *     header("Location: login.html");*/
?>
<!DOCTYPE html>
<html>
    <head>
	<meta charset="UTF-8" />
	<title>Hello Mom</title>
	<link rel="stylesheet" type="text/css" href="Css/imagecaption.css">
    </head>
    <body>
	<table>
	<div class="gallery-box" >
	    <div class="wrapper" ><table >
	    <?php
		$target_dir="Pictures/Products/";
		$sql="SELECT * FROM products;";
		$result=mysqli_query($conn,$sql);
		$resultCheck=mysqli_num_rows($result);
		if($resultCheck==0)
		    echo "Something with database went wrong or it is empty";
		else{
		    while($row=mysqli_fetch_assoc($result)){
			echo "<div class='user-container'>";
			echo "<img class='img-single' src=\"".$target_dir.$row["fileName"]."\">";
			echo "<p class='p-title'>".$row["description"]."</p>";
			echo "</div>";
		    }
		}
	    ?>
	    </div>
	</div>
	</body>
    </body>
</html>
