<?php

if (isset($_POST['submit']))
{
    include_once 'functions.php';

    $name = $_POST['name'];
    $pwd = $_POST['pwd'];
    $permission="user";
    $result=select_users_where_name($name);
    if(is_null($result))
	echo "result is null";
    else{
	$numRows= mysqli_num_rows($result);
	//there exist a user with the name
	if($numRows>0){
	    //user already exist!
	    header("Location: ../message.php?signup=failure");
	}
	else{
	    $sql = "INSERT INTO users (name, pwd,permission) VALUES (?, ?, ?);";
	    $stmt = mysqli_stmt_init($conn);
	    if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo "The SQL statement '$sql' could not be queried!";
	    } else {
		$pwdHash = password_hash($pwd, PASSWORD_DEFAULT);
		mysqli_stmt_bind_param($stmt, "sss", $name, $pwdHash,$permission);
		mysqli_stmt_execute($stmt);
		header("Location: ../message.php?signup=success");
	    }
	}
    }
}
