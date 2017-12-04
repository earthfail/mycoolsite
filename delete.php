<?php
include_once 'includes/dbh.inc.php';

session_start();
$access=true;
if(!isset($_SESSION['permission']) || $_SESSION['permission']<3)
		$access=false;
?>
<!DOCTYPE html>
<html>
    <head>
				<title>delete unwanted image</title>
    </head>
		<?php if($access==false){ ?>
				<body>
						<font color="red" size="4" >
								You can't delete images</font>
						<a href="login.html" >log in</a> here
				</body>
				<?php }else{ ?>
    <body>
				<form method="GET" >
						<select name="imageID" >
								<?php
								$sql="SELECT * FROM products;";
								$result=mysqli_query($conn,$sql);
								$resultCheck=mysqli_num_rows($result);
								if($resultCheck==0)
										echo "there is something wrong";
								else{
										while($row=mysqli_fetch_assoc($result))
										{
												echo "<option value=".$row['id'].">".$row['description']." ".$row['price'];
												echo "</option>".PHP_EOL;
										}
								}
								?>
						</select>
						<input type="submit" name="delete" value="delete" >
						<input type="submit" name="view" value="view" >
				</form>
				<?php
				if(isset($_GET['imageID']))
        {
            $id=$_GET['imageID'];
						$stmt=mysqli_stmt_init($conn);
						if(isset($_GET['view'])){
								$sql="SELECT fileName From products where id=?;";
								
								if(!mysqli_stmt_prepare($stmt,$sql))
                    echo "SQL statment failed to show with products id!";
								else{
                    mysqli_stmt_bind_param($stmt,"i",$id);
                    mysqli_stmt_execute($stmt);
                    $result=mysqli_stmt_get_result($stmt);
										$row=mysqli_fetch_assoc($result);
										$imgName=$row['fileName'];
										
										echo "<img src='Pictures/Products/".$imgName."'>";
								}
						}
						if(isset($_GET['delete'])){
								//first delete the file then delete its data from database
								$sql="SELECT fileName FROM products WHERE id=?";
								if(!mysqli_stmt_prepare($stmt,$sql))
										echo "SQL statment failed to delete products with id";
								else{
										mysqli_stmt_bind_param($stmt,"i",$id);
										mysqli_stmt_execute($stmt);
										$result=mysqli_stmt_get_result($stmt);
										
										$row=mysqli_fetch_assoc($result);
										$dir="Pictures/Products/";
										unlink($dir.$row['fileName']);
										echo $dir.$row['fileName']." was deleted";
										
										//Delete Image From Database
										$sql="DELETE FROM products WHERE id=?";
										if(!mysqli_stmt_prepare($stmt,$sql))
												echo "SQL statment failed to delete products with id";
										else{
												mysqli_stmt_bind_param($stmt,"i",$id);
												mysqli_stmt_execute($stmt);
										}
								}
						}
				}
				
				?>
				
    </body>
		<?php } ?>
</html>
