<html>

<body>
	
	
	<?php //cancello il piatto
		$piatto=$_REQUEST['piatto'];		
		$user="root"; $password=""; $host="localhost"; $database="cookevents";
		$con=@mysqli_connect($host,$user,$password,$database) or die( "Unable to select database");
		$query=str_replace("#nome#",$piatto,"delete from piatti where nome like '#nome#'");
		mysqli_query($con,$query);
		mysqli_close($con);
		//chiama funz js -> torna alla home
		echo '<script>window.location.href = "http://localhost/progettobdw/home.php";</script>' 
	?>


</body>
</html>