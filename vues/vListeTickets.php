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
        <div class="card">
          <div class="card-header bg-primary text-white">
            Critères d'affichage
          </div>
          <div class="card-body">
          	<div class="row form-inline">
              <div class="col-4">
              <form action="/page/listeTickets.php" method="get" class="">
              <?php if(isset($interlocuteurID)) echo "<input type='hidden' name='interlocuteurID' value='$interlocuteurID'>"; ?>
              	<div class="input-group">
                  <select class="custom-select" id="choixSte" name="societeID" autofocus>
                  <option value="" <?php if(!isset($societeEnCours)) echo ' selected '?>>Selectionner une société</option>
                  <?php foreach ($listeSocietes as $societe) {?>
                  	<option value="<?php echo $societe['id']?>"<?php if(isset($societeEnCours) && $societeEnCours->getId() == $societe['id']) echo ' selected '?>><?php echo ucfirst($societe['nom'])?></option>
                  <?php }?>
                  </select>
                  <div class="input-group-append">
                    <button class="btn btn btn-primary" type="submit" name="action" value="choixSociete">Valider</button>
                  </div>
                  
                </div></form>
              
              </div>
              
              <div class="col-4">
              <form action="/page/listeTickets.php" method="get" class="">
              	<?php if(isset($societeID)) echo "<input type='hidden' name='societeID' value='$societeID'>"; ?>
              	<?php if(isset($interlocuteurID)) echo "<input type='hidden' name='interlocuteurID' value='$interlocuteurID'>"; ?>
              	<div class="input-group">
                  <select class="custom-select" id="choixInterloc" name="interlocuteurID">
                    <option <?php if(!isset($societeEnCours)) echo ' selected '?>>Selectionner un interlocuteur</option>
                    <?php foreach ($listeInterlocuteurs as $interlocuteur) {?>
                  	<option value="<?php echo $interlocuteur->getId()?>"<?php if(isset($interlocuteurID) && $interlocuteurID == $interlocuteur->getId()) echo ' selected '?>><?php echo ucfirst($interlocuteur->getPrenom())." ".ucfirst($interlocuteur->getNom());?></option>
                  <?php }?>
                    <option value="Tous" <?php if(isset($_GET['interlocuteurID']) && $_GET['interlocuteurID'] =='Tous') echo 'selected';?>>Tous les interlocuteurs</option>
                  </select>
                  <div class="input-group-append">
                    <button class="btn btn btn-primary" type="submit" name="action" value="choixInterlocuteur">Valider</button>
                  </div>
                </div>
                </form>
              </div>
              <div class="col-4">
              <form action="/page/listeTickets.php" method="get" class="">
              	<?php if(isset($societeID)) echo "<input type='hidden' name='societeID' value='$societeID'>"; ?>
              	<?php if(isset($interlocuteurID)) echo "<input type='hidden' name='interlocuteurID' value='$interlocuteurID'>"; ?>
              	<div class="input-group">
                  <select class="custom-select" id="status" name="status">
                    <option selected>Selectionner le status de vos tickets</option>
                    <option value="1" <?php if(isset($StatusID) && $StatusID == 1) echo ' selected '?>>En cours</option>
                    <option value="0" <?php if(isset($StatusID) && $StatusID == 0) echo ' selected '?>>Cloturé</option>
                    <option>Tous</option>
                  </select>
                  <div class="input-group-append">
                    <button class="btn btn btn-primary" type="submit">Valider</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        
        <?php if (isset($listeTickets) && $listeTickets !='') { ?>
        <div class="card  mt-3">
          <div class="card-header bg-secondary  text-white">
            <span class="h4">Tickets</span>
            <?php /*<div class="input-group float-right col-2">
              <select class="custom-select" id="inputGroupSelect04" name="trier">
                <option value="id" selected>ID</option>
                <option value="date">Date</option>
              </select>
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Trier</button>
              </div>
            </div>*/?>
          </div>
          <div class="card-body">
          	<table class="table table-striped table-bordered table-hover" id="dataTable">
              <thead>
                <tr class="bg-info text-white text-dark">
                  <th scope="col" >ID</th>
                  <th scope="col" >Date</th>
                  <th scope="col" >Sujet</th>
                  <th scope="col" >Interlocuteur</th>
                  <th scope="col" >Société</th>
                  <th scope="col" >Status</th>
                  <th scope="col" >Action</th>
                </tr>
              </thead>
              <tbody>
              
              <?php foreach ($listeTickets as $ticket) {?>
                <tr>
                  <th scope="row"><?php echo $ticket->getId()?></th>
                  <td><?php echo $ticket->getDate()?></td>
                  <td><?php echo $ticket->getSujet()?></td>
                  <td><?php echo $ticket->NomFromInterlocuteurID()?></td>
                  <td><?php echo $ticket->NomFromSocieteID()?></td>
                  <td><?php if ($ticket->getStatus()==0) echo "Cloturé"; else echo "En cours"; ?></td>
                  <td>
					<form action="/page/ticket.php#ajouterTicket" method="get">
                        <input type="hidden" name="action" value="detailTicket" />
                        <input type="hidden" name="interlocuteurID" value="<?php echo $ticket->getInterlocuteurID()?>" />
                        <input type="hidden" name="societeID" value="<?php echo $ticket->getSocieteID() ?>" />
                        <input type="hidden" name="ticketID" value="<?php echo $ticket->getId() ?>" />
                        <button type="submit" class="btn btn-primary text-white float-right"><i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </td>
                </tr>
              <?php }?>  
              </tbody>
            </table>
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
