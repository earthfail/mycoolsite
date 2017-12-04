<?php
session_start();
?>
<html>
    <head>
	<meta charset="UTF-8">
	<title>response!</title>
    </head>
    <body>
	<h1>
	    <?php
	    if(isset($_GET["content"]))
	    {
		if($_GET["content"]=="imgfailure")
		    echo "There were was a problem uploading your image";
	    }
	    if(isset($_GET["signup"]))
	    {
		if($_GET["signup"]=="failure")
		    {
			echo "User name already exist!";
			exit;
		    }
		if($_GET["signup"]=="success")
		    echo "you can now login <a href=\"login.html\">here</a>";
	    }
	    if(isset($_GET["login"]))
	    {
		if($_GET["login"]=="success")
		{
		    echo "you have logged in successfuly as <font color=\"green\">"
			.$_SESSION["name"]."</font><br>";
		    echo "access level: ";
		    if($_SESSION["permission"]=="admin")
			echo "<font color=\"red\">ADMIN</font>";
		    else
			echo $_SESSION["permission"];
		}
	    }
	    ?>
	    <br>
	    <a href="login.html" >login here</a>
	    <br>
	    <a href="index.php" >main page</a>
</h1>
