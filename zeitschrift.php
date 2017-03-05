<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
	xmlns:f="http://java.sun.com/jsf/core"
	xmlns:h="http://java.sun.com/jsf/html"
	xmlns:ui="http://java.sun.com/jsf/facelets"
	xmlns:se="http://www.bsz-bw.de/mare/swbexpo">
	<ui:composition template="/WEB-INF/layout/layout.xhtml">
		
		
		<head>
			<title>Titel</title>
		</head>
		<body>		    
			<ui:define name="content">		
				<f:metadata>					
					<f:viewParam name="id" value="#{journalMgr.id}" />	
				</f:metadata>	
				<f:event type="preRenderComponent" listener="#{journalMgr.init}"/>				
				<div style="margin-bottom: 10px;">
					<a href="#{request.contextPath}/index.html">Home</a>&nbsp;&gt;&nbsp;<a href="#{request.contextPath}/zeitschriften.html">Bodensee-Zeitschriften</a>
				</div>				
				<div class="portrait dotbot">
					<a name="portrait" />
					<h1><h:outputText value="#{journalMgr.journal.portrait.title}"/></h1>
					<div>
						<p style="float: right; padding: 18px 0 10px 10px;"><h:graphicImage url="/covers/#{journalMgr.journal.id}.jpg" style="width: 150px;"/></p>						
						<h:panelGroup rendered="#{! empty journalMgr.journal.portrait.herausgeber}">
							Herausgeber: <h:outputText value="#{journalMgr.journal.portrait.herausgeber}"/>
						</h:panelGroup><br/>
						<h:panelGroup rendered="#{! empty journalMgr.journal.portrait.verlauf}">
							Verlauf: <h:outputText value="#{journalMgr.journal.portrait.verlauf}"/>
						</h:panelGroup>
						<h:panelGroup rendered="#{! empty journalMgr.journal.portrait.erscheinungsverlauf}">
							<h:outputText value="#{journalMgr.journal.portrait.erscheinungsverlauf}" escape="false"/>
						</h:panelGroup>
					</div>
				</div>				
				<h:panelGroup rendered="#{journalMgr.journal.portrait.ocr eq 'true'}">
					<a name="suche" /><h1 style="margin: 15px 0 0 0; clear: both;">Suche in #{journalMgr.journal.portrait.title}</h1>
				</h:panelGroup>        
        		<h:form rendered="#{journalMgr.journal.portrait.ocr eq 'true'}">
        			<div class="zeitschrift" style="padding: 25px 0 30px 0;">
						<h:inputText value="#{searchMgr.trm}" style="width: 300px" />
						<h:commandButton action="#{searchMgr.search}" value="Suchen">						
								<f:setPropertyActionListener target="#{searchMgr.filter}" value="#{journalMgr.id}" />
						</h:commandButton>
					</div>	
				</h:form>											
				<a name="verlauf" />
				<h1 style="margin: 15px 0 0 0;">Blättern in #{journalMgr.journal.portrait.title}</h1>
				<p>
					<se:nav value="#{journalMgr.journal}" current="#{journalMgr.id}">	
						<f:facet name="close">
						 	<div class="zeitschrift">
								<a name="#{coll.id}" /><a href="#{request.contextPath}/zeitschrift.html?id=#{coll.parent.id}#verlauf" >#{coll.label}</a>
							</div>							
						</f:facet>
						<f:facet name="open">
						 	<div class="zeitschrift">
								<a href="#{request.contextPath}/zeitschrift.html?id=#{coll.id}##{coll.id}" >#{coll.label}</a>
							</div>
						</f:facet>
						<f:facet name="leaf">
							<div class="zeitschrift">
								<a href="#{request.contextPath}/viewer.html?id=#{coll.id}&amp;view=single" target="_blank" >#{coll.label}</a>
							</div>
						</f:facet>
						<f:facet name="leaf_toc">
							<div class="zeitschrift">
								<a href="#{request.contextPath}/viewer.html?id=#{coll.id}&amp;view=single" target="_blank" >Zum digitalisierten Volltext</a><br />
								<span class="toclabel">Aus dem Inhalt</span>
							</div>
						</f:facet>
						<f:facet name="article">
							<div class="article">
								#{article.author}: <a href="#{request.contextPath}/viewer.html?page=#{article.start}&amp;view=single" target="_blank">#{article.title}</a><br/>
								<a href="#{request.contextPath}/pdf/export?von=#{article.start}&amp;bis=#{article.end}">PDF-Export</a>
							</div>
						</f:facet>
						<f:facet name="portrait">							
													
						</f:facet>
					</se:nav>
				</p>
				<h1 style="margin: 15px 0 0 0;">Feedback zu #{journalMgr.journal.portrait.title}</h1>
				<p>
					<h:link outcome="feedback" value="Zum Feedbackformular">
						<f:param name="page" value="zeitschrift"/>
						<f:param name="id" value="#{journalMgr.id}"/>
					</h:link>
				</p>															
			</ui:define>
			
		</body>
	</ui:composition>
</html>