<?php

	require "ressources/bibliothek.controler.inc.php";
	
	$controler = new BibliothekControler();	
		
	$controler->doGetId($_GET);		
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="style/euregio.css" media="screen">
		<link rel="stylesheet" type="text/css" href="style/bibliothek.css" media="screen" />
		<title>Bibliotheken der Regio Bodensee: <?php echo $item->properties['name']->value; ?></title>
	</head>
	<body>
	
		<?php include("ressources/components/head.inc.php"); ?> 
		
		<div id="container1">     
			
			<?php include("ressources/components/left.inc.php"); ?>

			<div id="logo"></div>
			
			<div id="content">
			
				<div id="portrait">
					<h1><?php echo $controler->bibliothek['name']; ?></h1>
					
					<?php echo $controler->bibliothek['portrait']; ?>
				</div>
				
			</div>
   
			<div id="right">
				<div id="bibliothekslogo">
					<img src="<?php echo $controler->bibliothek['logo']; ?>" width="182" 
					height="53" border="0" alt="Logo der <?php echo $controler->bibliothek['name']; ?>" />		            
				</div>
				<div id="anschrift">
					<h2>Anschrift</h2>
					<?php echo $controler->bibliothek['anschrift']; ?>
				</div>
				<div id="oeffnung">
					<h2>Öffnungszeiten</h2>
					<?php echo $controler->bibliothek['oeffnung']; ?>
				</div>
			    <div id="lage">
					<h2>Lage</h2>
					<img src="<?php echo $controler->bibliothek['lage']; ?>" />
				</div>
			</div>
		</div>
	</body>
</html>