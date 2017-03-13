<?php

	require "ressources/components/tags.php";	
	require "ressources/journal.controler.inc.php";
	
	$controler = new JournalControler();	
		
	$controler->doGet($_GET);
	
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="style/euregio.css" media="screen">
		<style type="text/css">
			
		</style>
		<title>Bibliotheken der Regio Bodensee: Projekte</title>
	</head>
	<body>
	
		<?php include("ressources/components/head.inc.php"); ?> 
		
		<div id="container1">     
			
			<?php include("ressources/components/left.inc.php"); ?>

			<div id="logo"></div>
			
			<div id="content1">
			
				<div id="spalte1">			
					
					<h1><?php echo $controler->root['label']; ?></h1>
					<?php $controler->renderChildren($controler->root) ?>
				
				</div>
			</div>
			<div id="footer"></div> 
		</div>
	</body>
</html>