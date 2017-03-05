<?php

	include("../../ressources/framework/login.inc.php");
	
	require "../../ressources/framework/controler.inc.php";
	require "../../ressources/bibliothek.inc.php";	
	require "../../ressources/components/tags.php";
	
	$controler = new ItemControler(BibliothekModel::getInstance());	
		
	$controler->doPost($_POST);
		
	$controler->doGet($_GET);	
	
?>
<!DOCTYPE html !>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Bibliotheken der Regio Bodensee: Bearbeitung von Bibliotheken</title>
	</head>
	<body>
		<nav><a href="../index.php">Redaktion</a></nav>
		<div class="container">
			<?php if ($controler->reccount > 0) { ?> 
				<?php suchformular($controler); ?>
				<div>
					<?php pagination($controler); ?>		
				</div>
				<?php liste($controler, ['name']) ?>				
			<?php } else { ?>
				<p>Keine Datensätze vorhanden</p>
			<?php } ?>
			<p><a href="formular.php">Neuer Eintrag</a></p>
		</div>
	</body>
</html>
