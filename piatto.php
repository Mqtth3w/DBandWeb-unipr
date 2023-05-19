<html>
<head><title> Piatto </title></head>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>

function readCookie(name) { //funzione per leggere i cookie
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
	while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
};

function spazio(str){ //toglie %20 dalla stringa e sostituisce con spazio
	var array1 = str.split('%20');
	var pt = array1[0];
	for(var i = 1; i < array1.length; i++) {
		pt = pt + " " + array1[i];
	}
	return pt;
}

function getVoto(obj) {
		var vt = $(obj).val();
		vt == "Mi piace" ? vt = 1: vt = 0;
		var pt = readCookie("piatto"); //estraggo il cookie piatto per sapere per che piatto votare
		var RegEx = /%20/;
		if (RegEx.test(pt)){
			pt = spazio(pt);
		}
		$.get("votazionepoll.php", {voto: vt, piatto: pt}).done(function(data){ //aggiorna voti su db
			$("#poll").html(data); //scrive voto aggiornaato al posto della votazione
		});
};

</script>
<body>
<?php
$piatto=$_REQUEST['piatto'];
setcookie("piatto", $piatto, strtotime("+1 year"));
?>
<center>
<br><br>
<b><?php echo "Piatto <h1>$piatto</h1>"?></b>
<br>


	<!-- reperisce e stampa info sul piatto più cuoco ed evento -->
	<?php 
		if (!empty($_REQUEST['piatto'])){
			$piatto=$_REQUEST['piatto'];
		}
		$user="root"; $password=""; $host="localhost"; $database="cookevents";
		$con=@mysqli_connect($host,$user,$password,$database) or die( "Unable to select database");
		
		$query=str_replace("#piatto#", $piatto, 
		"select p.descrizione as descpiatto, p.autore as cuoco, c.descrizione as desccuoco, p.evento as evento, e.data_ as data, e.descrizione as descevento
		from piatti p, cuochi c, eventi e
		where p.autore = c.nome and p.evento = e.nome 
		and p.nome like '#piatto#'");
		
		$result=mysqli_query($con,$query);
		$num=mysqli_num_rows($result);
		if ($num > 0) {
			$row=mysqli_fetch_assoc($result);
			$desc_piatto=$row["descpiatto"];
			$autor_piat=$row["cuoco"];
			$desc_cuoco=$row["desccuoco"];
			$evento=$row["evento"];
			$data=$row["data"];
			$desc_event=$row["descevento"];
			echo "<b>Descrizione piatto:</b> $desc_piatto <br>";
			echo "<b>Autore piatto (cuoco):</b> $autor_piat <br>";
			echo "<b>Info sul cuoco:</b> $desc_cuoco <br>";
			echo "<b>Data del piatto (data evento del piatto):</b> $data <br>"; ?>
			<b>Evento del piatto:</b> <a href="evento.php?evento=<?php echo $evento ?>"><?php echo $evento ?></a> <br><?php
			echo "<b>Descrizione evento del piatto:</b> $desc_event <br>";?>
			<br><br>
			
			<h3>Come valuti il piatto?</h3>
			<div id="poll">
				<input id="like" type="button" value="Mi piace" Onclick="getVoto(this)"><br>
				<input id="dislike" type="button" value="Non mi piace" Onclick="getVoto(this)">
			</div>
			<?php
		}
		
		
	?>
</center>

</body>
</html>