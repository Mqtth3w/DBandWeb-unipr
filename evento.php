<html>
<head> <title>Piatti</title> </head>

<body>

<?php
$evento=$_REQUEST['evento'];
?>

<br><br>
<b><center><?php echo "Evento <h1>$evento</h1>"?></center></b>
<br>


	<!-- reperisce e stampa info sull'evento ed i suoi piatti -->
	<?php #reperisco info evento
		$user="root"; $password=""; $host="localhost"; $database="cookevents";
		$con=@mysqli_connect($host,$user,$password,$database) or die( "Unable to select database");
		
		$query_evento=str_replace("%evento%", $evento, "SELECT descrizione, data_ from eventi where nome='%evento%'");
		$dati_evento=mysqli_query($con,$query_evento);
		$num_e=mysqli_num_rows($dati_evento);
		if ($num_e > 0) {
			$dati_e=mysqli_fetch_assoc($dati_evento);
			$desc_e=$dati_e["descrizione"];
			$data_e=$dati_e["data_"];
			echo "Data evento: $data_e <br>";
			echo "Descrizione evento: $desc_e<br><br><br><br>";
		}
		
		#reperisco piatti evento
		echo "<b><center><h2>Piatti evento</h2></center></b>";
		$query_piatti=str_replace("%evento%", $evento, "SELECT nome, descrizione from piatti where evento='%evento%'");
		$result=mysqli_query($con,$query_piatti);
		mysqli_close($con);
		$num=mysqli_num_rows($result);
		$i=0;
		while ($i < $num) {
			$row=mysqli_fetch_assoc($result);
			$nome=$row["nome"];
			$desc=$row["descrizione"];
			echo "Piatto: <a href='piatto.php?piatto=" . $nome . "'>" . $nome . "</a><br>Descrizione: $desc<br><hr><br>";
			$i++;
		}
	?>



</body>
</html>