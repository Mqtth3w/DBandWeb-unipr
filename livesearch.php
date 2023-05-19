<?php 
	
	/* come lo chiamo: 

		<div class="search-box">
        <input type="text" autocomplete="off" placeholder="Cerca evento" onkeyup="showResult(this,'eventi','cerca')">
        <div class="result"></div>
		</div>
		
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script>
		function showResult(obj, ctx, opt){ //tramite collegamento a php cerca nel db match con input digitato
			// prendo l'input 
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

	*/

	
	$str=$_REQUEST["usrinput"]; 
	$src=$_REQUEST["context"]; //evnti, piatti o cuochi
	$opzione=$_REQUEST["option"]; //per settare il link alla pagina che cerca o cancella
	
	$user="root"; $password=""; $host="localhost"; $database="cookevents";
	$con=@mysqli_connect($host,$user,$password,$database) or die( "Unable to select database");
	
	if ($src == "eventi") {
		$query="SELECT nome FROM eventi WHERE nome LIKE ?"; 
	}
	else if ($src == "piatti") {
		$query="SELECT nome FROM piatti WHERE nome LIKE ?";
	}
	else {
		$query="SELECT nome FROM cuochi WHERE nome LIKE ?";
	}
	if(isset($str)){
		
		if($stmt = mysqli_prepare($con, $query)){
			// lega la variabile ($param_term) allo statement preparato come parametro 
			mysqli_stmt_bind_param($stmt, "s", $param_term);
			
			// setto il parametro
			$param_term = $str . '%';
			
			// prova ad eseguire lo statement preparato, se non va riporta errore in else
			if(mysqli_stmt_execute($stmt)){
				$result = mysqli_stmt_get_result($stmt);
				
				if(mysqli_num_rows($result) > 0){
					
					$i=0; // conto tutto ciò che fa match e lo metto in output, al massimo 5 elementi
					while(($row = mysqli_fetch_assoc($result))&&($i<5)){ //generica per tutti i search-box grazie hai parametri passati
						if ($src == "eventi" && $opzione == "cerca") {
							echo "<p><a href='evento.php?evento=" . $row["nome"] . "'>" . $row["nome"] . "</a></p>";
						}
						else if ($src == "eventi" && $opzione == "cancella"){
							echo "<p><a href='cancellaevento.php?evento=" . $row["nome"] . "'>" . $row["nome"] . "</a></p>";
						}
						else if ($opzione == "cerca"){
							echo "<p><a href='piatto.php?piatto=" . $row["nome"] . "'>" . $row["nome"] . "</a></p>";
						}
						else if ($opzione == "cancella"){
							echo "<p><a href='cancellapiatto.php?piatto=" . $row["nome"] . "'>" . $row["nome"] . "</a></p>";
						}
						else {
							echo "<p><a href='cancellacuoco.php?cuoco=" . $row["nome"] . "'>" . $row["nome"] . "</a></p>";
						}
						$i++;
					}
					
				} else {
					echo "<p>Nessun risultato</p>";
				}
			} else {
				echo "ERRORE: Non in grado di eseguire la query $query " . mysqli_error($con);
			}
    
		}
		
    mysqli_stmt_close($stmt);
		
	}
	mysqli_close($con);
	
?>