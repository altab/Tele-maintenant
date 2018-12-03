<!DOCTYPE html>
<html lang="FR-fr">

<head>

	<?php require_once '../includes/head.php';?>

    <title>Nouveau Ticket - Télé-Maintenant</title>


</head>

<body id="page-top" onload="clearFormInterlocuteur()">

    <?php require_once '../includes/nav.php';?>
    
	<?php require_once '../includes/sidebar.php';?>


      <div id="content-wrapper">

        <?php require_once '../includes/breadcrumb.php';?>
        
        
        <div class="container-fluid">
			<!-- Contenu -->

			<div class="row">

				<div class="col-6">

					<div class="card h-100">
						<div class="card-header bg-primary text-white">
							<span class="h5">1 - Recherche Société</span> <a class="btn btn-light btn-sm mr-1 float-right" href="#" data-toggle="modal" data-target="#nouvelleSociete">Ajouter</a>
						</div>

						<div class="card-body">
							<form action="/page/ticket.php" method="get" id="selectSoc">
								<fieldset>
									<legend>Informations</legend>
									<div class="row">
										<label class="col-4 col-form-label" for="societe"> Nom de la société :</label>
										<div class="col-8">

											<input class="form-control" list="listeSociete" id="societe" name="societe" <?php if(isset($societeEnCours))echo "value=$societeEnCours"; ?>>
											<datalist id="listeSociete">
                                          <?php

                                        foreach ($societes as $societe) {
                                            echo "<option value='" . $societe['nom'] . "' label='" . $societe['nom'] . "'></option>\n";
                                        }
                                        ?>
                                        </datalist>
										</div>
									</div>
								</fieldset>
							</form>
							<div class="clearfix"></div>

						</div>
						<div class="card-footer">
							<div class="col-12">
								<input form="selectSoc" class="btn bg-success float-right text-white" type="submit" value="Valider">
							</div>

						</div>

					</div>



				</div>

				<div class="col-6">
					<form action="/page/ticket.php" method="get">
						<div class="card h-100">
							<div class="card-header bg-primary text-white">
								<span class="h5">2 - Recherche Interlocuteur <?php if(isset($societeEnCours))echo ucfirst($societeEnCours); ?>
  					 	    <a class="btn btn-light btn-sm mr-1 float-right" href="#" data-toggle="modal" data-target="#nouvelInterlocuteur">Ajouter</a>
								</span>
							</div>
						
                         <?php if(isset($societeEnCours))echo "<input type='hidden' value='$societeEnCours' name='societeEnCours'/>"; ?>
                	<div class="card-body">
								<fieldset>
									<legend>Informations</legend>
									<div class="row">
										<label class="col-4 col-form-label" for="nom"> Nom :</label>
										<div class="col-8">
											<input class="form-control" list="listeNom" id="nomInterlocuteur" name="nomInterlocuteur" <?php if(isset($interlocuteurEnCours))echo "value='".$interlocuteurEnCours->getNom()."'"; ?>>
											<datalist id="listeNom">
                                          <?php

                                        foreach ($interlocuteurs as $interlocuteur) {
                                            echo "<option value='" . $interlocuteur->getNom() . "' label='" . $interlocuteur->getNom() . "'></option>\n";
                                        }
                                        ?>
                                        </datalist>
										</div>
									</div>

									<div class="row my-2">
										<label class="col-4 col-form-label" for="prenom"> Prénom :</label>
										<div class="col-8">
											<input class="form-control" list="listePrenom" id="prenomInterlocuteur" name="prenomInterlocuteur"
												<?php if(isset($interlocuteurEnCours))echo "value='".$interlocuteurEnCours->getPrenom()."'"; ?>>
											<datalist id="listePrenom">
                                          <?php

                                        foreach ($interlocuteurs as $interlocuteur) {
                                            echo "<option value='" . $interlocuteur->getPrenom() . "' label='" . $interlocuteur->getPrenom() . "'></option>\n";
                                        }
                                        ?>
                                        </datalist>
										</div>
									</div>

									<div class="row my-2">
										<label class="col-4 col-form-label" for="telephone"> Téléphone :</label>
										<div class="col-8">
											<input class="form-control" list="listeTelephone" id="telephoneInterlocuteur" name="telephone"
												<?php if(isset($interlocuteurEnCours))echo "value='".$interlocuteurEnCours->getTelephone()."'"; ?>>
											<datalist id="listeTelephone">
                                      <?php

                                    foreach ($interlocuteurs as $interlocuteur) {
                                        echo "<option value='" . $interlocuteur->getTelephone() . "' label='" . $interlocuteur->getTelephone() . "'></option>\n";
                                    }
                                    ?>
                                    </datalist>
										</div>
									</div>

									<div class="row">
										<label class="col-4 col-form-label" for="email"> Email :</label>
										<div class="col-8">
											<input class="form-control" list="listeEmail" id="emailInterlocuteur" name="email" <?php if(isset($interlocuteurEnCours))echo " value='".$interlocuteurEnCours->getEmail()."'"; ?>>
											<datalist id="listeEmail">
                                      <?php

                                    foreach ($interlocuteurs as $interlocuteur) {
                                        echo "<option value='" . $interlocuteur->getEmail() . "' label='" . $interlocuteur->getEmail() . "'></option>\n";
                                    }
                                    ?>
                                    </datalist>
										</div>
									</div>


								</fieldset>


								<div class="clearfix"></div>
							</div>
							<div class="card-footer">
								<div class="col-12">
									<input class="btn bg-success float-right text-white" type="submit" value="Valider">
								</div>
							</div>

						</div>
					</form>
				</div>
			</div>
            
            
            <div class="row">

				<div class="card m-3 w-100">

					<div class="card-header <?php if (isset($tabTicketsSociete) && $tabTicketsSociete != '') echo " bg-info  text-white"; else echo " bg-secondary text-dark"; ?>">
						<i class="fas fa-fw fa-list-alt"></i> Tickets en cours
					</div>
					<div class="card-body">
						<div class="table-responsive">
                      <?php if (isset($tabTicketsSociete) && $tabTicketsSociete != '') { ?>
                      
                       	 <table class="table table-bordered table-hover" id="dataTable">
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

                    foreach ($tabTicketsSociete as $ticketSociete) {
                        
                        if ($ticketSociete->getStatus() == 0) {
                            $status = "Cloturé";
                        } else {
                            $status = "En cours";
                        }

                        ?>
                             
                              	<tr>
										<td><?php echo $ticketSociete->getId();?></td>
										<td><?php echo $ticketSociete->getDate();?></td>
										<td><?php echo ucfirst($ticketSociete->getSujet());?></td>
										<td><?php echo $ticketSociete->NomFromInterlocuteurID ();?></td>
										<td><?php echo $ticketSociete->NomFromSocieteID ();?></td>
										<td><?php echo $status;?></td>
										<td><?php echo $ticketSociete->NomFromUtilisateurID();?></td>
										<td class="align-center">
											<form action="/page/ticket.php#ajouterTicket" method="get">
												<input type="hidden" name="action" value="detailTicket" /> <input type="hidden" name="interlocuteurID" value="<?php echo $ticketSociete->getInterlocuteurID()?>" /> <input type="hidden"
													name="societeID" value="<?php echo $ticketSociete->getSocieteID() ?>" /> <input type="hidden" name="ticketID" value="<?php echo $ticketSociete->getId() ?>" />
												<button type="submit" class="btn btn-primary text-white float-right">
													<i class="fas fa-arrow-circle-right"></i>
												</button>
											</form>
										</td>
									</tr>
                            
                          	 <?php } ?>
                          </tbody>
							</table>
                        <?php } else { echo "<p class='text-danger text-center'>Aucun ticket pour cet interlocuteur !</p>";} ?>
                      </div>
					</div>
				</div>

			</div>


			<div class="row">

				<div class="card m-3 w-100">


					<div class="card-header <?php if (!isset($statusTicket) || $statusTicket != 0 ) echo "bg-warning text-dark";?>" id="ajouterTicket">
						<i class="fas fa-fw fa-pencil-alt"></i><?php if (isset($sujetEnCours) ) echo " Modifier le ticket [".$sujetEnCours->getId()."]"; else echo " Ajouter un ticket";?>
                    	<?php

                if ((! isset($statusTicket) || $statusTicket != 0) && (isset($sujetEnCours)))
                    echo '<a href="/page/modifierTicket.php?action=voirID&id=' . $sujetEnCours->getId() . '" class="btn btn btn-outline-secondary btn-sm float-right">Modifications avancées</a>';
                ?>
                    </div>

					<div class="card-body form-group">
                    
                    <?php if(isset($interlocuteurEnCours)) {?>
                    
                   		<div class="form-group">
							<form class="form-inline" action="/page/ticket.php#ajouterTicket" method="get">
								<input type="hidden" name="action" value="nouveauTicket"> <input class="form-control col-10 mr-5" type="text" name="sujet" placeholder="Sujet du ticket"
									<?php
                    if (isset($statusTicket) && $statusTicket == 0)
                        echo " disabled=\"disabled\"";
                    if (isset($sujetEnCours))
                        echo " value=\"" . ucfirst($sujetEnCours->getSujet()) . "\" ";
                    ?>> <input type="hidden" name="interlocuteurID" value="<?php  echo $interlocuteurEnCours->getId(); ?>"> <input type="hidden" name="societeID"
									value="<?php echo recupSocieteIdFromNom($societeEnCours); ?>"> <input class="btn btn-primary ml-5" type="submit" value="Créer"
									<?php
                    if (isset($sujetEnCours))
                        echo " disabled=\"disabled\"";
                    ?>>
							</form>
						</div>

						<div class="row" id="historique">
                    	<?php
                    if (isset($detailEnCours)) {
                        $index = 0;
                        foreach ($detailEnCours as $detail) {
                            echo "<ul><li><b>" . $detail->getDate() . "</b> : " . $detail->getInfo() . " <span class='font-weight-light text-mini'>[" . $detail->NomFromUtilisateurID() . "]</span>\n";
                            $index ++;
                        }
                        for ($i = 0; $i < $index; $i ++) {
                            echo "</li></ul>\n";
                        }
                    }
                    ?>
                    	
                    	</div>
                    	<?php if (isset($sujetEnCours))  { ?>
                    		<form action="/page/ticket.php#ajouterTicket" method="get">
							<input type="hidden" name="action" value="nouveauDetail"> <input type="hidden" name="interlocuteurID" value="<?php echo $interlocuteurEnCours->getId()?>" /> <input type="hidden"
								name="societeID" value="<?php if(isset($sujetEnCours)) echo $sujetEnCours->getSocieteID() ?>" /> <input type="hidden" name="ticketID"
								value="<?php if(isset($sujetEnCours)) echo $sujetEnCours->getId() ?>" />
							<div class="form-group">
								<label for="textareaTicket">Informations complémentaires :</label>
								<textarea class="form-control" id="textareaTicket" rows="6" name="detail" <?php if ($statusTicket == 0 ) echo " disabled=\"disabled\"";?>></textarea>
							</div>
							<button type="submit" class="btn btn-success float-right" <?php if ($statusTicket == 0 ) echo " disabled=\"disabled\""; ?>>Enregistrer informations</button>
						</form>
                        <?php }?>	
                    <?php } else echo "Vous devez selectionner un interlocuteur pour saisir un nouveau ticket !"?>	
                    </div>
				</div>
			</div>
            
            <?php if (isset($sujetEnCours))  { ?>  
            <div class="row">

				<div class="card m-3 w-100">


					<div class="card-header <?php if (isset($statusTicket) && $statusTicket == 1 ) echo " bg-primary text-white";?>" id="ajouterAction">
						<i class="fas fa-cogs"></i> Ajouter une action
					</div>

					<div class="card-body form-group">

						<div class="row" id="historiqueAction">
                    	<?php
                    if (isset($actionEnCours)) {
                        $index = 0;
                        foreach ($actionEnCours as $detail) {
                            echo "<ul><li><b>" . $detail->getDate() . "</b> : " . $detail->getInfo() . " <span class='font-weight-light text-mini'>[" . $detail->NomFromUtilisateurID() . "]</span>\n";
                            $index ++;
                        }
                        for ($i = 0; $i < $index; $i ++) {
                            echo "</li></ul>\n";
                        }
                    }
                    ?>
                    	
                    	</div>

						<form action="/page/ticket.php#ajouterAction" method="get">
							<input type="hidden" name="action" value="nouvelleAction"> <input type="hidden" name="interlocuteurID" value="<?php echo $interlocuteurEnCours->getId()?>" /> <input type="hidden"
								name="societeID" value="<?php if(isset($sujetEnCours)) echo $sujetEnCours->getSocieteID() ?>" /> <input type="hidden" name="ticketID"
								value="<?php if(isset($sujetEnCours)) echo $sujetEnCours->getId() ?>" />
							<div class="form-group">
								<label for="textareaAction">Description de l'action :</label>
								<textarea class="form-control" id="textareaAction" rows="6" name="actionTicket" <?php if ($statusTicket == 0 ) echo " disabled=\"disabled\"";?>></textarea>
							</div>
							<button type="submit" class="btn btn-success float-right" <?php if ($statusTicket == 0 ) echo " disabled=\"disabled\"";?>>Enregistrer Action</button>
						</form>


					</div>
				</div>
			</div>

			<form action="/page/ticket.php" method="post">
				<input type="hidden" name="action" value="changerStatusTicket"> <input type="hidden" name="interlocuteurID" value="<?php echo $interlocuteurEnCours->getId()?>" /> <input type="hidden"
					name="societeID" value="<?php if(isset($sujetEnCours)) echo $sujetEnCours->getSocieteID() ?>" /> <input type="hidden" name="ticketID"
					value="<?php if(isset($sujetEnCours)) echo $sujetEnCours->getId() ?>" />
				<div class="form-group row">
					<div class="col-12">
	                       <?php
                    if ($statusTicket == 1)
                        echo '<button  class="btn btn-danger float-right" type="submit"><i class="fas fa-lock"></i> Cloturer ce tiket';
                    else
                        echo '<button  class="btn bg-warning text-dark float-right" type="submit"><i class="fas fa-lock-open"></i> Rouvrir ce tiket';
                    ?></button>
					</div>
				</div>
			</form>
              <?php }?>         
            
        <!-- !Contenu -->
		</div>
        
		<?php require_once '../includes/footer.php';?>
		
      </div>




	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top"> <i class="fas fa-angle-up"></i>
	</a>

	<!-- Nouveau client Modal-->
	<div class="modal fade" id="nouvelleSociete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">
						<i class="fas fa-industry text-primary"></i> Nouvelle Société
					</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
              	<?php require_once '../includes/nouveauClient.php';?>
              </div>
			</div>
		</div>
	</div>

	<!-- Nouvel Interlocuteur Modal-->
	<div class="modal fade" id="nouvelInterlocuteur" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">
						<i class="fas fa-user text-primary"></i> Nouvel Interlocuteur
					</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
              	<?php require_once '../includes/nouvelInterlocuteur.php';?>
              </div>
			</div>
		</div>
	</div>

	<?php require_once '../includes/modal.php';?>
	
	
	
    <?php require_once '../includes/bootstrap-scripts.php';?>

  </body>

</html>
