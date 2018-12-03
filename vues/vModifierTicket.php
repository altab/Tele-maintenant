<!DOCTYPE html>
<html lang="FR-fr">

  <head>

	<?php require_once '../includes/head.php';?>

    <title>Télé-Maintenant - Dashboard</title>


  </head>

  <body id="page-top">

    <?php require_once '../includes/nav.php';?>
    
	<?php require_once '../includes/sidebar.php';?>


      <div id="content-wrapper">

        <?php require_once '../includes/breadcrumb.php';?>
        
        
        <div class="container-fluid">
        <!-- Contenu -->
        <?php if(isset($warning)) echo "<div class=\"row bg-warning text-dark mx-1 mb-3 pl-3 pt-1\"><h5><i class=\"fas fa-exclamation-circle\"></i> $warning</h5></div>";?>
        <div class="card mb-3">
          <div class="card-header bg-primary text-white">
            <span>Rechercher un ticket</span>
          </div>
          <div class="card-body">
              <form action="/page/modifierTicket.php" method="get">
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="id" placeholder="ID du ticket à modifier" >
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="submit" id="buttonID" name="action" value="voirID">Afficher</button>
                </div>
              </div>
              </form>
          </div>
        </div>
        

        <?php if (isset($idTicket) && $idTicket != '' && $ticketExiste) { ?>
         <?php if(!isset($statusUser) || $statusUser==0) echo"<div class=\"row bg-danger text-white mx-1 mb-3 pl-3 pt-1\"><h5><i class=\"fas fa-exclamation-circle\"></i>  Vous devez posseder les droits \"administrateur\" pour modifier un ticket</h5></div>";?>         
        <form action="/page/modifierTicket.php" method="post" onsubmit="return submitForm(this);">
          <input type="hidden" name="action" value="supprTicket">
          <input type="hidden" name="id" value="<?php echo $detailsTicket[0][0];?>">
        <div class="card">
          <div class="card-header bg-info text-white">
            <h1 class="float-left">Ticket <?php echo $detailsTicket[0][0] ." - ". ucfirst($detailsTicket[0]['sujet']);?></h1>
            <button class="btn btn btn-outline-danger btn-sm float-right" type="submit" <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?>>Supprimer ce ticket</button>
          </div>
          </form>
          <div class="card-body">
				<table class="table table-bordered rounded table-hover">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col" class="">élément</th>
                      <th scope="col" class="col-9">Valeur</th>
                      <th scope="col" class="col-1">Action</th>
                    </tr>
                  </thead>
                  <tbody>                    
                    
                    <tr>
                      <form action="/page/modifierTicket.php">
                          <input type="hidden" name="action" value="modifierSujet">
                          <input type="hidden" name="id" value="<?php echo $detailsTicket[0][0];?>">
                      <th scope="row">Sujet</th>
                      <td><input class="form-control" type="text" name="modifier" value="<?php echo $ticketEnCours->getSujet(); ?>"  <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?>></td>
                      <td>                      	
                      	<button class="btn btn-sm btn-primary" type="submit" <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?>><i class="fas fa-edit"></i></button>
                      </td>
                      </form>
                    </tr>
                    
                    <tr>
                      <form action="/page/modifierTicket.php">
                          <input type="hidden" name="action" value="modifierInterlocuteur">
                          <input type="hidden" name="id" value="<?php echo $detailsTicket[0][0];?>">
                      <th scope="row">Interlocuteur</th>
                      <td><input class="form-control" type="text" name="modifier" value="<?php echo $ticketEnCours->getInterlocuteurID(); ?>" <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?>></td>
                      <td>                      	
                      	<button class="btn btn-sm btn-primary" type="submit" <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?>><i class="fas fa-edit"></i></button>
                      </td>
                      </form>
                    </tr>
                    
                    <tr>
                      <form action="/page/modifierTicket.php">
                          <input type="hidden" name="action" value="modifierSociete">
                          <input type="hidden" name="id" value="<?php echo $detailsTicket[0][0];?>">
                      <th scope="row">Société</th>
                      <td><input class="form-control" type="text" name="modifier" value="<?php echo $ticketEnCours->getSocieteID(); ?>" <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?>></td>
                      <td>                      	
                      	<button class="btn btn-sm btn-primary" type="submit" <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?>><i class="fas fa-edit"></i></button>
                      </td>
                      </form>
                    </tr>
                    
                    <tr>
                      <form action="/page/modifierTicket.php">
                          <input type="hidden" name="action" value="modifierStatus">
                          <input type="hidden" name="id" value="<?php echo $detailsTicket[0][0];?>">
                      <th scope="row">Status</th>
                      <td><input class="form-control" type="text" name="modifier" value="<?php echo $ticketEnCours->getStatus(); ?>" <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?>></td>
                      <td>                      	
                      	<button class="btn btn-sm btn-primary" type="submit" <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?>><i class="fas fa-edit"></i></button>
                      </td>
                      </form>
                    </tr>
                    
                    <tr>
                      <form action="/page/modifierTicket.php">
                          <input type="hidden" name="action" value="modifierDate">
                          <input type="hidden" name="id" value="<?php echo $detailsTicket[0][0];?>">
                      <th scope="row">Date</th>
                      <td><input class="form-control" type="text" name="modifier" value="<?php echo $ticketEnCours->getDate(); ?>" <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?>></td>
                      <td>                      	
                      	<button class="btn btn-sm btn-primary" type="submit" <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?>><i class="fas fa-edit"></i></button>
                      </td>
                      </form>
                    </tr>
                    
                    <tr>
                      <form action="/page/modifierTicket.php">
                          <input type="hidden" name="action" value="modifierUtilisateur">
                          <input type="hidden" name="id" value="<?php echo $detailsTicket[0][0];?>">
                      <th scope="row">Opérateur</th>
                      <td><input class="form-control" type="text" name="modifier" value="<?php echo $ticketEnCours->getUtilisateurID(); ?>" <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?>></td>
                      <td>                      	
                      	<button class="btn btn-sm btn-primary" type="submit" <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?>><i class="fas fa-edit"></i></button>
                      </td>
                      </form>
                    </tr>
                    
                  </tbody>
                </table>
          </div>
        </div>
        <div class="card mt-2">
          <div class="card-body">
          	  <form action="/page/modifierTicket.php" method="post" onsubmit="return deleteElements(this);">
          	   <input type="hidden" name="action" value="supprDetails">
          	   <input type="hidden" name="id" value="<?php echo $detailsTicket[0][0];?>">
				<table class="table table-bordered rounded table-hover" id="dataTable">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col" class="">Type</th>
                   	  <th scope="col" class="">ID</th>
                   	  <th scope="col" class="">Op</th>
                      <th scope="col" class="">Date</th>
                      <th scope="col" class="">Valeur</th>
                      <th scope="col" class="">Supprimer</th>
                    </tr>
                  </thead>
                  <tbody>                    
                  <?php 
                  foreach ($detailsTicket as $detailTicket) {
                      
                      if($detailTicket['type'] == 0) $type = "<span class=\"text-warning\">Détail</span>";
                      else $type ="<span class=\"text-primary\">Action</span>";
                      
                      $detail  = new Detail($detailTicket['id'], $detailTicket['info'], $detailTicket['date'], $detailTicket['ticketID'], $detailTicket['utilisateurID']);
                     
                  ?>
					<tr>
						<th  scope="row"><label for="detailID-<?php echo $detailTicket['id']?>"><?php echo $type?></label></th>
						<td><label for="detailID-<?php echo $detail->getId();?>"><?php echo $detail->getId();?></label></td>
						<td><label for="detailID-<?php echo $detail->getId();?>"><?php echo $detail->getUtilisateurID();?></label></td>
						<td><label for="detailID-<?php echo $detail->getId();?>"><?php echo $detail->getDate();?></label></td>
						<td><label for="detailID-<?php echo $detail->getId();?>"><?php echo $detail->getInfo();?></label></td>
						<td>
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" name="detailID[<?php echo $detail->getId()?>]" value="<?php echo $detailTicket['id']?>" id="detailID-<?php echo $detail->getId()?>"  <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?> />
								<label class="custom-control-label" for="detailID-<?php echo $detail->getId()?>"></label>
							</div>
						</td>
					</tr>
                  <?php     
                  }
                  ?>  
                    
                  </tbody>
                   <tfoot class=" bg-light">
                     <tr>
                       <td colspan="6"><button type="submit" class="btn btn-danger float-right" <?php if(!isset($statusUser) || $statusUser==0) echo" disabled";?>><i class="fas fa-eraser"></i> Supprimer</button></td>
                     </tr>
                   </tfoot>
                </table>
              </form>
          </div>
        </div>
        
        
        <?php } // !if action=modifierID?>
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
