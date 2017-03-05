<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
	xmlns:f="http://java.sun.com/jsf/core"
	xmlns:h="http://java.sun.com/jsf/html"
	xmlns:ui="http://java.sun.com/jsf/facelets">
 <f:metadata>
	<f:viewParam name="id" value="#{viewerMgr.id}" />
	<f:viewParam name="page" value="#{viewerMgr.page}" />	
	<f:viewParam name="view" value="#{sessionBean.view}" />	
 </f:metadata>
 <f:event type="preRenderComponent" listener="#{viewerMgr.init}"/>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="#{request.contextPath}/style/euregio.css" media="screen" />
  <style type="text/css">
<!--

	.dropdown {
		color:#85837e;
		font-size:0.85em;
		width:100px;
	}


-->
  </style>
  <title>#{viewerMgr.booklet.journal.label}, #{viewerMgr.booklet.label} : #{viewerMgr.left} - #{viewerMgr.right}</title>
 </head>
 <body> 
 		<div id ="viewerhead" style="background-color:#e1e1e1;width:1280px;">
			<h:graphicImage url="/img/logoklein.gif" style="float: left; border: none"/>
			<div style="padding: 10px 0 0 20px;">
				<p>
					<a href="#{request.contextPath}/index.html">Home</a> &gt;
					<a href="#{request.contextPath}/zeitschriften.html">Bodensee-Zeitschriften</a> &gt;
					<span style="font-size: 14pt;font-weight: bold">
						<h:link outcome="zeitschrift" value="#{viewerMgr.booklet.journal.label}">						
							<f:param name="id" value="#{viewerMgr.booklet.journal.id}" />
						</h:link>
					</span>
					 &gt; <a href="#{request.contextPath}/viewer.html?id=#{viewerMgr.booklet.id}">#{viewerMgr.booklet.label}</a>
				</p>
			</div>		
			<div style="padding: 0 0 10px 20px; margin-bottom: 10px;">
				<h:form id="pageselect">
					<span style="margin-left: 0px;">
						<h:selectOneMenu value="#{sessionBean.view}" onchange="submit();" styleClass="dropdown">
							<f:selectItem itemLabel="Eine Seite" itemValue="single"/>
							<f:selectItem itemLabel="Zwei Seiten" itemValue="double"/>
							<f:selectItem itemLabel="Vorschau" itemValue="preview"/>
							<f:selectItem itemLabel="Bearbeiten" itemValue="edit"/>							
						</h:selectOneMenu>
					</span>
					<span style="margin-left: 5px;">
						<h:commandButton value="kleiner" action="#{viewerMgr.zoomOut}" />						
					</span>						
					<span style="margin-left: 10px;">
						<h:commandButton value="größer" action="#{viewerMgr.zoomIn}" />						
					</span>									
					<span style="margin-left: 10px;">
						<h:graphicImage url="/img/blind.gif" style="vertical-align: text-bottom;" rendered="#{empty viewerMgr.previous}"/>	
						<h:panelGroup >&nbsp;&nbsp;&nbsp;</h:panelGroup>
						<h:link outcome="viewer" rendered="#{! empty viewerMgr.previous}">
							<f:param name="page" value="#{viewerMgr.previous.id}" />
							<h:graphicImage url="/img/previous.gif" title="Mit Klick zurückblättern" style="vertical-align: text-bottom;"></h:graphicImage>
						</h:link>&nbsp;&nbsp;					
				 		<h:selectOneListbox id="pages" value="#{viewerMgr.page}" size="1" styleClass="dropdown" onchange="document.getElementById('pageselect:submit').click()">
							<f:selectItems value="#{viewerMgr.pages}" var="scan" itemValue="#{scan.id}" itemLabel="#{scan.label}"/>
						</h:selectOneListbox>&nbsp;&nbsp;				
						<h:link outcome="viewer" rendered="#{! empty viewerMgr.next}" >
							<f:param name="page" value="#{viewerMgr.next.id}" />
							<h:graphicImage url="/img/next.gif" title="Mit Klick weiterblättern"  style="vertical-align: text-bottom;"></h:graphicImage>
						</h:link>
						<h:graphicImage url="/img/blind.gif" style="vertical-align: text-bottom;" rendered="#{empty viewerMgr.next}"/>											
					</span>
					<span style="margin-left: 70px;">					
						<h:commandButton value="PDF-Export" action="#{viewerMgr.exportPdf}" /> von 
						<h:selectOneListbox id="von_select" value="#{viewerMgr.von}" size="1" styleClass="dropdown" >
							<f:selectItems value="#{viewerMgr.pages}" var="scan" itemValue="#{scan.id}" itemLabel="#{scan.label}"/>
						</h:selectOneListbox>&nbsp;
						<h:selectOneListbox id="bis_select" value="#{viewerMgr.bis}" size="1" styleClass="dropdown" >
							<f:selectItems value="#{viewerMgr.pages}" var="scan" itemValue="#{scan.id}" itemLabel="#{scan.label}"/>
						</h:selectOneListbox>					
					</span>
					<span style="margin-left: 70px;">
						<input type="button" value="Fenster schließen" onclick="window.close();"/>
					</span>						
					<h:commandButton id="submit" value="OK" action="viewer?faces-redirect=true&amp;includeViewParams=true" style="visibility:hidden;" />
					
					
				</h:form>
			</div>
		</div>
		<h:messages style="color:red;margin:8px;"/>
		<h:panelGroup rendered="#{sessionBean.view eq 'double'}">
			<table style="width: auto;">
				<tr>
					<td style="text-align: center;">
						<h:panelGroup rendered="#{! empty viewerMgr.left and sessionBean.zoom gt 40}">					
							<a href="#{request.contextPath}/page?#{viewerMgr.left.id}" >Zitierlink: http://www.bodenseebibliotheken.eu/page?#{viewerMgr.left.id}</a>
						</h:panelGroup>
					</td>
					<td style="text-align: center;">
						<h:panelGroup rendered="#{! empty viewerMgr.right and sessionBean.zoom gt 40}">
							<a href="#{request.contextPath}/page?#{viewerMgr.right.id}" >Zitierlink: http://www.bodenseebibliotheken.eu/page?#{viewerMgr.right.id}</a>
						</h:panelGroup>				
					</td>
				</tr>
				<tr>
					<td>
						<h:link outcome="viewer" rendered="#{! empty viewerMgr.previous}">
							<f:param name="page" value="#{viewerMgr.previous.id}" />
							<h:graphicImage url="/zoom?id=#{viewerMgr.left.id}&amp;scale=#{sessionBean.zoom}" title="Mit Klick zurückblättern"/>
						</h:link>
						<h:graphicImage url="/zoom?id=#{viewerMgr.left.id}&amp;scale=#{sessionBean.zoom}" rendered="#{empty viewerMgr.previous and ! empty viewerMgr.left}"/>
						<h:graphicImage url="img/weiss.gif" rendered="#{empty viewerMgr.left}"/>	
					</td>
					<td>
						<h:link outcome="viewer" rendered="#{ ! empty viewerMgr.next}">
							<f:param name="page" value="#{viewerMgr.next.id}" />
							<h:graphicImage url="/zoom?id=#{viewerMgr.right.id}&amp;scale=#{sessionBean.zoom}" title="Mit Klick weiterblättern" />
						</h:link>
						<h:graphicImage url="/zoom?id=#{viewerMgr.right.id}&amp;scale=#{sessionBean.zoom}" rendered="#{empty viewerMgr.next and ! empty viewerMgr.right}"/>
						<h:graphicImage url="img/weiss.gif" style="width: 620px; height: auto; " rendered="#{empty viewerMgr.right}"/>							
					</td>
				</tr>
				<tr>
					<td style="text-align: center;">
						<h:panelGroup rendered="#{! empty viewerMgr.left}">
							#{viewerMgr.left.label}
						</h:panelGroup>						
					</td>
					<td style="text-align: center;">
						<h:panelGroup rendered="#{! empty viewerMgr.right}">
							#{viewerMgr.right.label}
						</h:panelGroup>
					</td>
				</tr>
			</table>
		</h:panelGroup>
		<h:panelGroup rendered="#{sessionBean.view eq 'single'}">
			<table>
				<tr>
					<td>
						<h:panelGroup rendered="#{! empty viewerMgr.left}" style="text-align: left;">					
							<a href="#{request.contextPath}/page?#{viewerMgr.left.id}" >Zitierlink: http://www.bodenseebibliotheken.eu/page?#{viewerMgr.left.id}</a>
						</h:panelGroup>
					</td>					
				</tr>
				<tr>
					<td>
						<h:link outcome="viewer" rendered="#{! empty viewerMgr.next}">
							<f:param name="page" value="#{viewerMgr.next.id}" />
							<h:graphicImage url="/zoom?id=#{viewerMgr.left.id}&amp;scale=#{sessionBean.zoom}" title="Mit Klick weiterblättern"/>
						</h:link>
						<h:graphicImage url="/zoom?id=#{viewerMgr.left.id}&amp;scale=#{sessionBean.zoom}" rendered="#{empty viewerMgr.next}"/>
						<h:graphicImage url="img/weiss.gif" style="width: 620px; height: auto; " rendered="#{empty viewerMgr.left}"/>	
					</td>					
				</tr>
			</table>
		</h:panelGroup>
		<h:panelGroup rendered="#{sessionBean.view eq 'preview'}">
			<ui:repeat value="#{viewerMgr.preview}" var="page">
				<div style="float:left;padding: 20px; text-align: center;">
					<h:link outcome="viewer">
						<f:param name="page" value="#{page.id}" />
						<f:param name="view" value="single" />
						<h:graphicImage url="/zoom?id=#{page.id}&amp;scale=10" /><br/>
						<h:outputText value="#{page.label}"/>
					</h:link>
				</div>				
			</ui:repeat>			
		</h:panelGroup>
		<div style="padding: 5px 0 10px 60px; margin-bottom: 10px;background-color:#e1e1e1;width:1280px;clear: both;">
				<h:form id="pageselect1">
					<span style="margin-left: 0px;">
						<h:selectOneMenu value="#{sessionBean.view}" onchange="submit();" styleClass="dropdown">
							<f:selectItem itemLabel="Eine Seite" itemValue="single"/>
							<f:selectItem itemLabel="Zwei Seiten" itemValue="double"/>
							<f:selectItem itemLabel="Vorschau" itemValue="preview"/>							
						</h:selectOneMenu>
					</span>
					<span style="margin-left: 5px;">
						<h:commandButton value="kleiner" action="#{viewerMgr.zoomOut}" />						
					</span>						
					<span style="margin-left: 10px;">
						<h:commandButton value="größer" action="#{viewerMgr.zoomIn}" />						
					</span>									
					<span style="margin-left: 10px;">
						<h:graphicImage url="/img/blind.gif" style="vertical-align: text-bottom;" rendered="#{empty viewerMgr.previous}"/>	
						<h:panelGroup >&nbsp;&nbsp;&nbsp;</h:panelGroup>
						<h:link outcome="viewer" rendered="#{! empty viewerMgr.previous}">
							<f:param name="page" value="#{viewerMgr.previous.id}" />
							<h:graphicImage url="/img/previous.gif" title="Mit Klick zurückblättern" style="vertical-align: text-bottom;"></h:graphicImage>
						</h:link>&nbsp;&nbsp;					
				 		<h:selectOneListbox id="pages" value="#{viewerMgr.page}" size="1" styleClass="dropdown" onchange="document.getElementById('pageselect1:submit').click()">
							<f:selectItems value="#{viewerMgr.pages}" var="scan" itemValue="#{scan.id}" itemLabel="#{scan.label}"/>
						</h:selectOneListbox>&nbsp;&nbsp;				
						<h:link outcome="viewer" rendered="#{! empty viewerMgr.next}" >
							<f:param name="page" value="#{viewerMgr.next.id}" />
							<h:graphicImage url="/img/next.gif" title="Mit Klick weiterblättern"  style="vertical-align: text-bottom;"></h:graphicImage>
						</h:link>
						<h:graphicImage url="/img/blind.gif" style="vertical-align: text-bottom;" rendered="#{empty viewerMgr.next}"/>											
					</span>
					<span style="margin-left: 70px;">					
						<h:commandButton value="PDF-Export" action="#{viewerMgr.exportPdf}" /> von 
						<h:selectOneListbox id="von_select" value="#{viewerMgr.von}" size="1" styleClass="dropdown">
							<f:selectItems value="#{viewerMgr.pages}" var="scan" itemValue="#{scan.id}" itemLabel="#{scan.label}"/>
						</h:selectOneListbox>&nbsp;
						<h:selectOneListbox id="bis_select" value="#{viewerMgr.bis}" size="1" styleClass="dropdown">
							<f:selectItems value="#{viewerMgr.pages}" var="scan" itemValue="#{scan.id}" itemLabel="#{scan.label}"/>
						</h:selectOneListbox>					
					</span>
					<span style="margin-left: 70px;">
						<input type="button" value="Fenster schließen" onclick="window.close();"/>
					</span>						
					<h:commandButton id="submit" value="OK" action="viewer?faces-redirect=true&amp;includeViewParams=true" style="visibility:hidden;" />
					<span style="margin-left: 70px;">
						<h:button value="Feedbackformular" outcome="feedback" rendered="#{sessionBean.view eq 'single'}">
							<f:param name="id" value="#{viewerMgr.left.id}" />
							<f:param name="page" value="viewer" />
						</h:button>
					</span>
				</h:form>
			</div>						
	</body>
</html>	
