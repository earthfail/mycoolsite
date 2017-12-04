<?php
if (isset($_POST['submit']))
{
    include_once 'functions.php';

    $name=$_POST["name"];
    $pwd=$_POST["pwd"];
    $result=select_users_where_name($name);
    if(is_null($result))
	echo "result is null";
    else
    {
	//use what you want with $result
	$numRows=mysqli_num_rows($result);
	if($numRows!=1)
	    echo "user doesn't exist";
	else{
	    if($row=mysqli_fetch_assoc($result)){
		$dbHashedPwd=password_verify($pwd,$row["pwd"]);
		if($dbHashedPwd==false)
		    echo "Login error! password didn't match";
		elseif($dbHashedPwd==true)
		{
		    session_start();
		    $_SESSION['name']=$row['name'];
		    $_SESSION['permission']=$row['permission'];
		    header("Location: ../message.php");
		}
	    }
	}
    }
}
