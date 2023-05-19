<?php //aggiorno il voto per il piatto nel db e ritorno il valore aggiornato
	$voto=$_REQUEST['voto'];
	$piatto=$_REQUEST['piatto'];	
	$try="select numlike, numdislike from piatti where nome like '#piatto#'";
	$query=str_replace("#piatto#", $piatto, $try);
	$user="root"; $password=""; $host="localhost"; $database="cookevents";
	$con=@mysqli_connect($host,$user,$password,$database) or die( "Unable to select database");
	$result=mysqli_query($con,$query);
	$num=mysqli_num_rows($result);
	if ($num > 0) {
		$row=mysqli_fetch_assoc($result);
		$like=$row["numlike"];
		$dislike=$row["numdislike"];		
	}
	
	if ($voto == "1") {
		$try="update piatti 
		set numlike = numlike + 1 
		where nome like '#piatto#'";
		$like=intval($like+1);
	}
	else {
		$try="update piatti 
		set numdislike = numdislike + 1 
		where nome like '#piatto#'";
		$dislike=intval($dislike+1);
	}
	$query=str_replace("#piatto#", $piatto, $try);
	mysqli_query($con,$query);
	mysqli_close($con);

	echo "Mi piace: $like <br> Non mi piace: $dislike <br>";

?>