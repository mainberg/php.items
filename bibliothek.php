<?php

	require "includes/database.inc.php";
	require "bibliothek.inc.php";
	
	$itemClass = 'Bibliothek';
		
	if (isset($_GET['id'])) {
		$item = retrieveItem($_GET['id'], $itemClass);
	} else {
		exit;
	}	
	
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
	
		<?php include("includes/head.inc.php"); ?> 
		
		<div id="container1">     
			
			<?php include("includes/left.inc.php"); ?>

			<div id="logo"></div>
			
			<div id="content">
			
				<div id="portrait">
					<h1><?php echo $item->properties['name']->value; ?></h1>
					
					<?php echo $item->properties['portrait']->value; ?>
				</div>
				
			</div>
   
			<div id="right">
				<div id="bibliothekslogo">
					<img src="<?php echo $item->properties['logo']->value; ?>" width="182" height="53" border="0" alt="Logo der <?php echo $item->name; ?>" />		            
				</div>
				<div id="anschrift">
					<h2>Anschrift</h2>
					<?php echo $item->properties['anschrift']->value; ?>
				</div>
				<div id="oeffnung">
					<h2>Öffnungszeiten</h2>
					<?php echo $item->properties['oeffnung']->value; ?>
				</div>
			    <div id="lage">
					<h2>Lage</h2>
					<img src="<?php echo $item->properties['lage']->value; ?>" />
				</div>
			</div>
		</div>
	</body>
</html>