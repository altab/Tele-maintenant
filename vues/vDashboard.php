<!DOCTYPE html>
<html lang="FR-fr">

  <head>

	<?php require_once '../includes/head.php';?>

    <title>Dashboard - Télé-Maintenant</title>


  </head>

  <body id="page-top">

    <?php require_once '../includes/nav.php';?>
    
	<?php require_once '../includes/sidebar.php';?>


      <div id="content-wrapper">

        <?php require_once '../includes/breadcrumb.php';?>
        
        
        <div class="container-fluid">
        <!-- Contenu -->
        
           	<div class="row">
            	<div class="col-6">
            	
            	<div class="card h-100">
  					<h5 class="card-header  bg-primary text-white">1 - Recherche Société</h5>
                	<div class="card-body">
                        <form action="/metier/dashboard.php" method="post">
                    	<fieldset>    	
            			<legend>Informations</legend>
        					<div class="row">
        						<label class="col-4 col-form-label" for="societe" > Nom de la société :</label>
                               	<div class="col-8">
                               		
                                       	<input class="form-control" list="listeSociete" id="societe" name="societe" 
                                       	<?php if(isset($societeEnCours))echo "value=$societeEnCours"; ?>>
                                       	<datalist id="listeSociete">
                                          <?php foreach ($societes as $societe) {
                                              echo "<option value='".$societe['nom']."' label='".$societe['nom']."'></option>\n";
                                          } ?>
                                        </datalist>
        						</div>
        					</div>
                		</fieldset>	
                		
                		<div class="row mt-3 d-flex">
    						<div class="col-12">
    							<input class="btn bg-success float-right text-white" type="submit" value="Valider">
    							<button class="btn btn-outline-primary mr-3 float-right">Ajouter</button>
    						</div>
    					</div>			
                		<div class="clearfix"></div>
                		</form>
                     </div>
                </div>
                            	
                	
            	</div>
            	<div class="col-6">
            		<div class="card h-100">
  					<h5 class="card-header bg-primary text-white">2 - Recherche Interlocuteur <?php if(isset($societeEnCours))echo $societeEnCours; ?></h5>
                	<div class="card-body">
                        <form action="/metier/dashboard.php" method="post">
                         <?php if(isset($societeEnCours))echo "<input type='hidden' value='$societeEnCours' name='societeEnCours'/>"; ?> 
                    	<fieldset>    	
            			<legend>Informations</legend>
        					<div class="row">
        						<label class="col-4 col-form-label" for="nom"> Nom :</label>
                               	<div class="col-8">
                                   	<input class="form-control" list="listeNom" id="nom"  name="nomInterlocuteur" <?php if(isset($interlocuteurEnCours))echo "value='".$interlocuteurEnCours->getNom()."'"; ?>>
                                   	  	<datalist id="listeNom">
                                          <?php foreach ($interlocuteurs as $interlocuteur) {
                                             echo "<option value='".$interlocuteur -> getNom()."' label='".$interlocuteur -> getNom()."'></option>\n";
                                          } ?>
                                        </datalist>
        						</div>
        					</div>
        					
        					<div class="row my-2">
        						<label class="col-4 col-form-label" for="prenom"> Prénom :</label>
                               	<div class="col-8">
                                   	<input class="form-control" list="listePrenom" id="prenom"  name="prenomInterlocuteur" <?php if(isset($interlocuteurEnCours))echo "value='".$interlocuteurEnCours->getPrenom()."'"; ?>>
                                   	  	<datalist id="listePrenom">
                                          <?php foreach ($interlocuteurs as $interlocuteur) {
                                              echo "<option value='".$interlocuteur-> getPrenom()."' label='".$interlocuteur-> getPrenom()."'></option>\n";
                                          } ?>
                                        </datalist>
        						</div>
        					</div>
        					
        					<div class="row my-2">
        						<label class="col-4 col-form-label" for="telephone" > Téléphone :</label>
                               	<div class="col-8">
                                   	<input class="form-control" list="listeTelephone" id="telephone" name="telephone" <?php if(isset($interlocuteurEnCours))echo "value='".$interlocuteurEnCours->getTelephone()."'"; ?>>
                                   	<datalist id="listeTelephone">
                                      <?php foreach ($interlocuteurs as $interlocuteur) {
                                              echo "<option value='".$interlocuteur-> getTelephone()."' label='".$interlocuteur-> getTelephone()."'></option>\n";
                                          } ?>
                                    </datalist>
        						</div>
        					</div>
        					
        					<div class="row">
        						<label class="col-4 col-form-label" for="email" > Email :</label>
                               	<div class="col-8">
                                   	<input class="form-control" list="listeEmail" id="email" name="email"<?php if(isset($interlocuteurEnCours))echo "value='".$interlocuteurEnCours->getEmail()."'"; ?>>
                                   	<datalist id="listeEmail">
                                      <?php foreach ($interlocuteurs as $interlocuteur) {
                                              echo "<option value='".$interlocuteur-> getEmail()."' label='".$interlocuteur-> getEmail()."'></option>\n";
                                          } ?>
                                    </datalist>
        						</div>
        					</div>
        					
        					
                		</fieldset>
                		<div class="row mt-3">
    						<div class="col-12">
    							<input class="btn bg-success float-right text-white" type="submit" value="Valider">
    							<button class="btn btn-outline-primary mr-3 float-right">Ajouter</button>
    						</div>
    					</div>			
                		
                		<div class="clearfix"></div>
                		</form>
                		
                     </div>
                </div>
            	
            	</div>
            </div>
            
        <!-- !Contenu -->
		</div>
        
		<?php require_once '../includes/footer.php';?>
		
      </div>
      



    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

	<?php require_once '../includes/modal.php';?>
	
    <?php require_once '../includes/bootstrap-scripts.php';?>

  </body>

</html>
