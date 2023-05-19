<html>

<body>
	
	
	<?php //cancello il cuoco
		$evento=$_REQUEST['evento'];		
		$user="root"; $password=""; $host="localhost"; $database="cookevents";
		$con=@mysqli_connect($host,$user,$password,$database) or die( "Unable to select database");
		$query1=str_replace("#nome#",$evento,"delete from piatti where evento like '#nome#'");
		$query2=str_replace("#nome#",$evento,"delete from eventi where nome like '#nome#'");
		mysqli_query($con,$query1);
		mysqli_query($con,$query2);
		mysqli_close($con);
		//chiama funz js -> torna alla home
		echo '<script>window.location.href = "http://localhost/progettobdw/home.php";</script>' 
	?>


</body>
</html>