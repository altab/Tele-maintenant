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

			<!-- Icon Cards-->
			<div class="row">
				<div class="col-xl-3 col-sm-6 mb-3">
					<div class="card text-white bg-primary o-hidden h-100">
						<div class="card-body">
							<div class="card-body-icon">
								<i class="fas fa-fw fa-list-alt"></i>
							</div>
							<div class="mr-5"><?php echo $nbTickets; ?> tickets en créés !</div>
						</div>
						<a class="card-footer text-white clearfix small z-1"
							href="/page/ticket.php"> <span class="float-left">Details</span>
							<span class="float-right"> <i class="fas fa-angle-right"></i>
						</span>
						</a>
					</div>
				</div>
				<div class="col-xl-3 col-sm-6 mb-3">
					<div class="card text-white bg-danger o-hidden h-100">
						<div class="card-body">
							<div class="card-body-icon">
								<i class="fas fa-fw fa-list"></i>
							</div>
							<div class="mr-5"><?php echo $nbCloturesTickets; ?> tickets cloturés !</div>
						</div>
						<a class="card-footer text-white clearfix small z-1"
							href="/page/ticket.php""> <span class="float-left">Details</span>
							<span class="float-right"> <i class="fas fa-angle-right"></i>
						</span>
						</a>
					</div>
				</div>
				<div class="col-xl-3 col-sm-6 mb-3">
					<div class="card text-white bg-success o-hidden h-100">
						<div class="card-body">
							<div class="card-body-icon">
								<i class="fas fa-fw fa-user-tie"></i>
							</div>
							<div class="mr-5"><?php echo $nbClients; ?> Clients !</div>
						</div>
						<a class="card-footer text-white clearfix small z-1"
							href="/page/clients.php"> <span class="float-left">Details</span>
							<span class="float-right"> <i class="fas fa-angle-right"></i>
						</span>
						</a>
					</div>
				</div>
				<div class="col-xl-3 col-sm-6 mb-3">
					<div class="card text-white bg-warning o-hidden h-100">
						<div class="card-body">
							<div class="card-body-icon">
								<i class="fas fa-fw fa-users"></i>
							</div>
							<div class="mr-5"><?php echo $nbInterlocuteurs; ?> interlocuteurs !</div>
						</div>
						<a class="card-footer text-white clearfix small z-1" href="#"> <span
							class="float-left">Details</span> <span class="float-right"> <i
								class="fas fa-angle-right"></i>
						</span>
						</a>
					</div>
				</div>
			</div>


			<p>Bienvenue sur Télé-Maintenant votre solution Helpdesk de gestion
				de tickets.</p>
			<p>Veuillez utiliser le menu ci-contre pour utiliser l'application.</p>


			<div class="row">

				<div class="card m-3 w-100">

					<div
						class="card-header <?php if (isset($tabTicketsOperateur) && $tabTicketsOperateur != '') echo " bg-info  text-white"; else echo " bg-secondary text-dark"; ?>">
						<i class="fas fa-fw fa-list-alt"></i> Tickets en cours pour <?php echo $nomUtilisateurEnCours; ?>
					</div>
					<div class="card-body">
						<div class="table-responsive">
                      <?php if (isset($tabTicketsOperateur) && $tabTicketsOperateur != '') { ?>
                      
                       	 <table class="table table-bordered table-hover"
								id="dataTable">
								<thead>
									<tr>
										<th>ID</th>
										<th>Date</th>
										<th>Sujet</th>
										<th>Interlocuteur</th>
										<th>Société</th>
										<th>Status</th>
										<th>Operateur</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                             <?php

                            foreach ($tabTicketsOperateur as $ticketOperateur) {
                                
                                if     ($ticketOperateur->getStatus() == 0)
                                    $status = "Cloturé";
                                elseif ($ticketOperateur->getStatus() == 1)
                                    $status = "En cours";
                                elseif ($ticketOperateur->getStatus() == 2)
                                    $status = "A traiter";
                                else 
                                    $status = "Inconnu";

                            ?>
                             
                              	<tr <?php if ($ticketOperateur->getStatus() == 2) echo "class=\"text-danger font-weight-bold\"";?>>
										<td><?php echo $ticketOperateur->getId();?></td>
										<td><?php echo $ticketOperateur->getDate();?></td>
										<td><?php echo ucfirst($ticketOperateur->getSujet());?></td>
										<td><?php echo $ticketOperateur->NomFromInterlocuteurID ();?></td>
										<td><?php echo $ticketOperateur->NomFromSocieteID ();?></td>
										<td><?php echo $status;?></td>
										<td><?php echo $ticketOperateur->NomFromUtilisateurID();?></td>
										<td class="align-center">
											<form action="/page/ticket.php#ajouterTicket" method="get">
												<input type="hidden" name="action" value="detailTicket" /> <input
													type="hidden" name="interlocuteurID"
													value="<?php echo $ticketOperateur->getInterlocuteurID()?>" />
												<input type="hidden" name="societeID"
													value="<?php echo $ticketOperateur->getSocieteID() ?>" /> <input
													type="hidden" name="ticketID"
													value="<?php echo $ticketOperateur->getId() ?>" />
												<button type="submit"
													class="btn btn-primary text-white float-right">
													<i class="fas fa-arrow-circle-right"></i>
												</button>
											</form>
										</td>
									</tr>
                            
                          	 <?php } ?>
                          </tbody>
							</table>
							</form>
                        <?php } else echo "<p class='text-danger text-center'>Aucun ticket en cours pour cet opérateur !</p>"; ?>
                      </div>
					</div>
				</div>

			</div>

			<!-- !Contenu -->
		</div>
        
		<?php require_once '../includes/footer.php';?>
		
      </div>




	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top"> <i
		class="fas fa-angle-up"></i>
	</a>

	<?php require_once '../includes/modal.php';?>
	
    <?php require_once '../includes/bootstrap-scripts.php';?>

  </body>

</html>
