<!DOCTYPE html>
<html lang="FR-fr">

  <head>

	<?php require_once '../includes/head.php';?>

    <title>Télé-Maintenant - Clients</title>


  </head>

  <body id="page-top">

    <?php require_once '../includes/nav.php';?>
    
	<?php require_once '../includes/sidebar.php';?>


      <div id="content-wrapper">

        <?php require_once '../includes/breadcrumb.php';?>
        
        
        <div class="container-fluid">
        <!-- Contenu -->
        
        <?php if(isset($warning)) echo "<div class=\"row $warningColor mx-1 mb-3 pt-3 px-3 pb-2\"><h5><i class=\"fas fa-exclamation-circle\"></i> $warning</h5></div>";?>
        
          <div class="row">
                <div class="col">
                 
                	<?php require_once '../includes/nouvelInterlocuteur.php';?>
                </div>
          </div>
          
          
          
          <?php if (isset($listeInterlocuteur) && $listeInterlocuteur !='') { ?>
            <div class="row">
            <div class="col-12">
            <div class="card  mt-3">
              <div class="card-header bg-secondary text-white">
                <span class="h4" id="listeSociete">Liste des interlocuteurs</span>
                <a class="btn btn-light btn-sm mr-1 float-right" href="/page/interlocuteurs.php" >Nouvel Interlocuteur</a>
              </div>
              <div class="card-body">
              	<table class="table table-striped table-bordered table-hover" id="dataTable">
                  <thead>
                    <tr class="bg-info text-white text-dark">
                      <th scope="col" >ID</th>
                      <th scope="col" >Nom</th>
                      <th scope="col" >Prenom</th>
                      <th scope="col" >Téléphone</th>
                      <th scope="col" >Email</th>
                      <th scope="col" >Société</th>
                      <th scope="col" >Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  <?php foreach ($listeInterlocuteur as $interlocuteur) {?>
                    <tr>
                      <th scope="row"><?php echo $interlocuteur->getId()?></th>
                      <td><?php echo $interlocuteur->getNom()?></td>
                      <td><?php echo $interlocuteur->getPrenom()?></td>
                      <td><?php echo $interlocuteur->getTelephone()?></td>
                      <td><?php echo $interlocuteur->getEmail()?></td>
                      <td><?php echo $interlocuteur->NomFromSocieteID()?></td>
                      <td>
                      
    					<form action="/page/interlocuteurs.php" method="get">
                            <input type="hidden" name="action" value="modifierInterlocuteur" />
                            <button type="submit" class="btn btn-primary text-white float-right mx-1" name="idInterlocuteur" value="<?php echo $interlocuteur->getId()?>"><i class="fas fa-arrow-circle-right"></i></button>
                        </form>
                        <?php if(!isset($statusUser) || $statusUser==1) {?>
                      	<form action="/page/interlocuteurs.php" method="post" onsubmit="return submitForm(this);">
                            <input type="hidden" name="action" value="supprimerInterlocuteur" />
                            <button type="submit" class="btn btn-danger text-white float-right mx-1" name="idInterlocuteurSuppr" value="<?php echo $interlocuteur->getId()?>"><i class="fas fa-times-circle"></i></button>
                        </form>
                      <?php }?>
                      </td>
                    </tr>
                  <?php }?>  
                  </tbody>
                </table>
              </div>
           </div>
           </div>
           </div>
           <?php }?>
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
