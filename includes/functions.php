<?php
include_once 'dbh.inc.php';
function select_users_where_name($name)
{

    $sql="SELECT * FROM users WHERE name=?;";
    //creat a prepared statment
    $stmt=mysqli_stmt_init($GLOBALS['conn']);
    //prepare the statment
    if(!mysqli_stmt_prepare($stmt,$sql))
	echo "SQL statment failed!";
    else{
	//bind parameters
	mysqli_stmt_bind_param($stmt,"s",$name);
	//run parameter inside database
	mysqli_stmt_execute($stmt);
	$result=mysqli_stmt_get_result($stmt);
	//return the result
	return $result;
    }
    return null;
}
