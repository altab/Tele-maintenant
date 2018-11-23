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
  					<h5 class="card-header  bg-primary text-white">Société</h5>
                	<div class="card-body">
                            
                    	<fieldset>    	
            			<legend>Informations</legend>
        					<div class="row">
        						<label class="col-4 col-form-label" for="societe" > Nom de la société :</label>
                               	<div class="col-8">
                                   	<input class="form-control" list="société" id="societe">
                                   	<datalist id="société">
                                      <option value="ACME">
                                      <option value="Neo-Cortex">
                                      <option value="Morley">
                                      <option value="Stark Industries">
                                      <option value="Wayne Entreprises">
                                    </datalist>
        						</div>
        					</div>
                		</fieldset>	
                		
                		<div class="row mt-3 d-flex">
    						<div class="col-12">
    							<input class="btn bg-success float-right text-white" type="submit" value="valider">
    							<button class="btn btn-outline-primary mr-3 float-right">Ajouter</button>
    						</div>
    					</div>			
                		<div class="clearfix"></div>
                		
                     </div>
                </div>
                            	
                	
            	</div>
            	<div class="col-6">
            		<div class="card h-100">
  					<h5 class="card-header bg-primary text-white">Interlocuteur</h5>
                	<div class="card-body">
                            
                    	<fieldset>    	
            			<legend>Informations</legend>
        					<div class="row">
        						<label class="col-4 col-form-label" for="nom" > Nom :</label>
                               	<div class="col-8">
                                   	<input class="form-control" list="nom" id="nom">
                                   	<datalist id="nom">
                                      <option value="Elodie">
                                      <option value="Marie">
                                      <option value="Philippe">
                                      <option value="Sonia">
                                      <option value="Mathieu">
                                    </datalist>
        						</div>
        					</div>
        					
        					<div class="row my-2">
        						<label class="col-4 col-form-label" for="telephone" > Téléphone :</label>
                               	<div class="col-8">
                                   	<input class="form-control" list="telephone" id="telephone">
                                   	<datalist id="telephone">
                                      <option value="0400000000">
                                      <option value="0632659874">
                                      <option value="0612345678">
                                      <option value="0600112233">
                                      <option value="0611112222">
                                    </datalist>
        						</div>
        					</div>
        					
        					<div class="row">
        						<label class="col-4 col-form-label" for="email" > Email :</label>
                               	<div class="col-8">
                                   	<input class="form-control" list="email" id="email">
                                   	<datalist id="email">
                                      <option value="elodie@mail.com">
                                      <option value="marie@mail.com">
                                      <option value="philippe@mail.com">
                                      <option value="sonia@mail.com">
                                      <option value="mathieu@mail.com">
                                    </datalist>
        						</div>
        					</div>
        					
        					
                		</fieldset>	
                		<div class="row mt-3">
    						<div class="col-12">
    							<input class="btn bg-success float-right text-white" type="submit" value="valider">
    							<button class="btn btn-outline-primary mr-3 float-right">Ajouter</button>
    						</div>
    					</div>			
                		<div class="clearfix"></div>
                		
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
