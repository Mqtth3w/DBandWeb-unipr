<html>

<body>
	
	
	<?php 
		if (!empty($_REQUEST['insert'])) {
			$insert=$_REQUEST['insert'];
		}
	
		//seleziono query di inserimento in base al form
		if ($insert == "evento") {
			$evento=$_REQUEST['nomeevento'];
			$desc=$_REQUEST['descevento'];
			$timestamp = strtotime($_REQUEST['dataevento']); 
			$day=date('d',$timestamp);
			$month=date('m',$timestamp);
			$year=date('Y',$timestamp);
			$try=str_replace("#evento#", $evento, "INSERT IGNORE INTO eventi VALUES ('#evento#','#y#-#m#-#d#','#desc#')");
			$try2=str_replace("#desc#", $desc, $try);
			$try3=str_replace("#y#", $year, $try2);
			$try4=str_replace("#m#", $month, $try3);
			$query=str_replace("#d#", $day, $try4);
		}
		else if ($insert == "cuoco") {
			$cuoco=$_REQUEST['nomecuoco'];
			$desc=$_REQUEST['desccuoco'];
			$try=str_replace("#nome#", $cuoco, "INSERT IGNORE INTO cuochi VALUES ('#nome#','#desc#')");
			$query=str_replace("#desc#", $desc, $try);
		}
		else {
			$piatto=$_REQUEST['nomepiatto'];
			$autore=$_REQUEST['autore'];
			$desc=$_REQUEST['descpiatto'];
			$evento=$_REQUEST['eventopiatto'];
			$try=str_replace("#evento#", $evento, "INSERT IGNORE INTO piatti VALUES ('#nome#','#autore#','#desc#','#evento#',0,0)");
			$try2=str_replace("#autore#", $autore, $try);
			$try3=str_replace("#nome#", $piatto, $try2);
			$query=str_replace("#desc#", $desc, $try3);
		}
		
		$user="root"; $password=""; $host="localhost"; $database="cookevents";
		$con=@mysqli_connect($host,$user,$password,$database) or die( "Unable to select database");
		mysqli_query($con,$query);
		mysqli_close($con);	
		
		//chiama funz js -> torna alla home
		echo '<script>window.location.href = "http://localhost/progettobdw/home.php";</script>' 
	?>


</body>
</html>