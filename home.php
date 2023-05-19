<html>
<head> 
	<title> Home </title> 
	<style>
		body{
			font-family: Arail, sans-serif;
		}
		/* grafica del search box */
		.search-box{
			width: 290px;
			position: relative;
			display: inline-block;
			font-size: 14px;
		}
		.search-box input[type="text"]{
			height: 32px;
			padding: 5px 10px;
			border: 1px solid #CCCCCC;
			font-size: 14px;
		}
		.result{
			position: absolute;        
			z-index: 999;
			top: 100%;
			left: 0;
		}
		.search-box input[type="text"], .result{
			width: 100%;
			box-sizing: border-box;
		}
		/* grafica dei risultati */
		.result p{
			margin: 0;
			padding: 7px 10px;
			border: 1px solid #CCCCCC;
			border-top: none;
			cursor: pointer;
		}
		.result p:hover{
			background: #f3f3f3;
		}
	</style>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script>
	function showResult(obj, ctx, opt){ //tramite collegamento a php cerca nel db match con input digitato
		/* prendo l'input */
		var inputVal = $(obj).val();
		var resultDropdown = $(obj).siblings(".result"); //prendo il div vuoto per mostrare l'output
		if(inputVal.length){
			$.get("livesearch.php", {usrinput: inputVal, context: ctx, option: opt}).done(function(data){ //mando l'input al php per vedere se sta nel db
				// mostro l'output nel div vuoto
				resultDropdown.html(data);
			});
		} else{
			resultDropdown.empty();
		}
	};
	</script>

</head>
<body>
<br><br>
	<center>
	<div class="search-box">
        <input type="text" autocomplete="off" placeholder="Cerca evento" onkeyup="showResult(this,'eventi','cerca')">
        <div class="result"></div>
    </div>
	<div class="search-box">
        <input type="text" autocomplete="off" placeholder="Cancella evento" onkeyup="showResult(this,'eventi','cancella')">
        <div class="result"></div>
    </div>
	<div class="search-box">
        <input type="text" autocomplete="off" placeholder="Cerca piatto" onkeyup="showResult(this,'piatti','cerca')">
        <div class="result"></div>
    </div>
	<div class="search-box">
        <input type="text" autocomplete="off" placeholder="Cancella piatto" onkeyup="showResult(this,'piatti','cancella')">
        <div class="result"></div>
    </div>
	<div class="search-box">
        <input type="text" autocomplete="off" placeholder="Cancella cuoco" onkeyup="showResult(this,'cuoco','')">
        <div class="result"></div>
    </div>
	<br><br><br><br><br><br><br><br><br><br>
	<b>Inserisci evento</b><br>
	<form action="gestisciinput.php" >
		<input type="hidden" name="insert" value="evento">
		<input name="nomeevento" type="text" placeholder="Nome evento" maxlength="255" required>
		<input name="dataevento" type="date" required>
		<input name="descevento" type="text" placeholder="Descrizione evento" size="50" maxlength="1000" required>
		<input type="submit" value="Inserisci evento">
	</form>
	<br>
	<b>Inserisci cuoco</b><br>
	<form action="gestisciinput.php" >
		<input type="hidden" name="insert" value="cuoco">
		<input name="nomecuoco" type="text" placeholder="Nome cuoco" maxlength="255" required>
		<input name="desccuoco" type="text" placeholder="Info cuoco" size="50" maxlength="1000" required>
		<input type="submit" value="Inserisci cuoco">
	</form>
	<br>
	<!-- reperisco eventi e cuochi per menu a tendina inserimento piatto e per mostrare nella home gli eventi-->
	<?php
		$user="root"; $password=""; $host="localhost"; $database="cookevents";
		$con=@mysqli_connect($host,$user,$password,$database) or die( "Unable to select database");
		$query1="SELECT * from eventi";
		$query2="SELECT * from cuochi";
		$eventi=mysqli_query($con,$query1);
		$cuochi=mysqli_query($con,$query2);
		mysqli_close($con);
	?>
	
	<b>Inserisci piatto</b><br>
	<form action="gestisciinput.php" >
		<input type="hidden" name="insert" value="piatto">
		<input name="nomepiatto" type="text" placeholder="Nome piatto" maxlength="255" required>
		<select name="autore" required>
			<option value="">Seleziona cuoco</option>
			<?php
				while ($row=mysqli_fetch_assoc($cuochi)) {
					?>
					<option value="<?php echo $row["nome"] ?>"><?php echo $row["nome"] ?></option>
					<?php
				}
			?>
		</select>
		<select name="eventopiatto" required>
			<option value="">Seleziona evento</option>
			<?php
				while ($row=mysqli_fetch_assoc($eventi)) {
					?>
					<option value="<?php echo $row['nome'] ?>"><?php echo $row["nome"] ?> (<?php echo $row["data_"] ?>)</option>
					<?php			
				}
			?>
		</select>
		<input name="descpiatto" type="text" placeholder="Descrizione piatto" size="50" maxlength="1000" required>
		<input type="submit" value="Inserisci piatto">
	</form>
	
	<font color="red">
		<b>ATTENZIONE:</b> Cancellare un cuoco comporta la cancellazione di tutti i suoi piatti.<br>
		Cancellare un evento comporta la cancellazione di tutti i piatti partecipanti all'evento.<br>
		L'inserimento di dati già presenti verrà ingorato.<br>
	</font>
	
	</center>
	
	<br>
	
	<?php //mostro gli eventi nella home
		echo "<b><center><h2>Eventi valutazione piatti</h2></center></b>";
		echo "<center><a href='classificapiatti.php'>Classifica globale piatti</a></center><br><br>";
		$eventi->data_seek(0);
		while ($row=mysqli_fetch_assoc($eventi)) {
			$nome=$row["nome"];
			$data=$row["data_"];
			$desc=$row["descrizione"];?>
			Evento: <a href="evento.php?evento=<?php echo $nome ?>"><?php echo $nome ?></a>
			<br>Data: <?php echo $data?><br>Descrizione: <?php echo $desc ?>
			<br><a href='classificapiatti.php?evento=<?php echo $nome ?>'>Classifica piatti dell'evento</a><br><hr><br>
			<?php 
		}
	?>

</body>
</html>