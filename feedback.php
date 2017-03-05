<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="style/euregio.css" media="screen">
		</style>  	
		<title>Bibliotheken der Regio Bodensee: Charta</title>
	</head>
	<body>
	
		<?php include("includes/head.php"); ?> 
		
		<div id="container1">     
			
			<?php include("includes/left.php"); ?>

			<div id="logo"></div>
			
			<div id="content1">
			
				<div id="spalte1">
				<h1>Rückmeldung zu den Bodensee-Zeitschriften</h1>			
			<h:form id="feedback_form">
				<h:inputHidden name="id" value="#{feedback.id}" />  
				<h:inputHidden name="page" value="#{feedback.page}" />
				<p>Bitte schicken sie uns Anmerkungen, Fragen, Kommentare zu:</p>
				<h2>#{feedback.journal.label}</h2>  
				<fieldset>
					<legend>Rückmeldung:</legend>		
					<p>
						<h:inputTextarea id="feedback" rows="15" cols="70" value="#{feedback.feedback}" required="true" 
						  styleClass="swbexpo_bestellung_input" requiredMessage="#{bundle.error_bestellung_name}"/><br/>
						<span class="required"><h:message for="name"/></span>
					</p>					
				</fieldset>			
				<p>
					<h:commandButton value="Absenden" action="#{feedback.send}" />
				</p>
			</div>
			</div>
			<div id="footer"></div> 
		</div>
	</body>
</html>
