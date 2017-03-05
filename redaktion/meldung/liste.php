<?php

	include("../../ressources/framework/login.inc.php");
	
	require "../../ressources/components/tags.php";
	require "../../ressources/framework/controler.inc.php";
	require "../../ressources/meldung.inc.php";		
	
	
	$controler = new ItemControler(MeldungModel::getInstance());	
		
	$controler->doPost($_POST);
		
	$controler->doGet($_GET);	
	
?>
<!DOCTYPE html !>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Bibliotheken der Regio Bodensee: Bearbeitung von Meldungen</title>
	</head>
	<body>
		<div class="container">
			<?php if ($controler->reccount > 0) { ?> 
				<?php suchformular($controler); ?>
				<div>
					<?php pagination($controler); ?>		
				</div>
				<?php liste($controler, ['datum','ort','titel']) ?>
			<?php } else { ?>
				<p>Keine Datensätze vorhanden</p>
			<?php } ?>
			<p><a href="formular.php">Neuer Eintrag</a></p>
		</div>
	</body>
</html>
