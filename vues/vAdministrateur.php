<!DOCTYPE html>
<html lang="FR-fr">

  <head>

	<?php require_once '../includes/head.php';?>

    <title>Administration - Télé-Maintenant</title>


  </head>

  <body id="page-top">

    <?php require_once '../includes/nav.php';?>
    
	<?php require_once '../includes/sidebar.php';?>


      <div id="content-wrapper">

        <?php require_once '../includes/breadcrumb.php';?>
        
        
        <div class="container-fluid">
        <!-- Contenu -->
        
        <div class="card">
        	<div class="card-header bg-primary text-white"><i class="fas fa-user"></i> Liste des utilisateurs [ADMINISTRATEUR : <?php echo $infosUtilisateur['nom']." ".$infosUtilisateur['prenom'];?>]</div>
        	<div class="card-body">
        		<table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>email</th>
                            <th>icone</th>
                            <th>role</th>
                            <th>Actif</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($listeUtilisateurs) && !isset($utilisateurEnCours)) {
                            foreach ($listeUtilisateurs as $utilisateur) { ?>
                        <tr  <?php if ($utilisateur->getActif() == 0) echo " class=\"text-danger\"";?>>
                            <td><?php echo $utilisateur->getId() ?></td>
                            <td><?php echo $utilisateur->getNom() ?></td>
                            <td><?php echo $utilisateur->getPrenom() ?></td>
                            <td><?php echo $utilisateur->getEmail() ?></td>
                            <td><?php echo $utilisateur->getIcone() ?></td>
                            <td><?php echo $utilisateur->getRole() ?></td>
                            <td><?php echo $utilisateur->getActif() ?></td>
                            <td>
                                <form action="/page/administrateur.php" method="post"  class="form-inline" onsubmit="deleteElements()">
                                    <input type="hidden" name="utilisateurID" value="<?php echo $utilisateur->getId() ?>">
                                    <button type="submit" name="action" value="supprimerUtilisateur" class="btn btn-danger text-white eraser mr-2" ><i class="fas fa-times-circle"></i></button>
                                    <a href="/page/administrateur.php?action=modifierUtilisateur&utilisateurID=<?php echo $utilisateur->getId() ?>" class="btn btn-primary text-white"><i class="fas fa-arrow-circle-right"></i></a>
                                </form></td>
                        </tr>
                   <?php    }
                    } elseif (isset($listeUtilisateurs) && isset($utilisateurEnCours)) { 
                    		 foreach ($listeUtilisateurs as $utilisateur) { 
                    	
                    		     if($utilisateur->getId() !=$utilisateurEnCours->getId() ) { ?>
                    	
                            	<tr>
                                    <td><?php echo $utilisateur->getId() ?></td>
                                    <td><?php echo $utilisateur->getNom() ?></td>
                                    <td><?php echo $utilisateur->getPrenom() ?></td>
                                    <td><?php echo $utilisateur->getEmail() ?></td>
                                    <td><?php echo $utilisateur->getIcone() ?></td>
                                    <td><?php if ($utilisateur->getRole() == 0) echo 'Operateur' ?>
                                    	<?php if ($utilisateur->getRole() == 1) echo 'Administrateur' ?>
                                    	<?php if ($utilisateur->getRole() == 2) echo 'Standardiste' ?>
                                    </td>
                                    <td>
                                    <?php if ($utilisateur->getActif() == 0) echo "Non-Actif"; else  echo "Actif"; ?>
                                    </td>
                                    <td>
                                    <a href="/page/administrateur.php?action=supprimerUtilisateur&utilisateurID=<?php echo $utilisateur->getId() ?>" class="btn btn-danger text-white"><i class="fas fa-times-circle"></i></a>
                                    <a href="/page/administrateur.php?action=modifierUtilisateur&utilisateurID=<?php echo $utilisateur->getId() ?>" class="btn btn-primary text-white"><i class="fas fa-arrow-circle-right"></i></a></td>
                                </tr>
                                
                                <?php } else {?>
                             	
                             	
                                 	<tr  class="form-group">
                                 	<form action="/page/administrateur.php" method="get">
                                 	<input type="hidden" name="utilisateurID" value="<?php echo $utilisateurEnCours->getId() ?>">
                                        <td><?php echo $utilisateurEnCours->getId() ?></td>
                                        <td><input type="text" name='nom' value="<?php echo $utilisateurEnCours->getNom() ?>" class="form-control"></td>
                                        <td><input type="text" name='prenom' value="<?php echo $utilisateurEnCours->getPrenom() ?>" class="form-control"></td>
                                        <td><input type="text" name='email' value="<?php echo $utilisateurEnCours->getEmail() ?>" class="form-control"></td>
                                        <td><input type="text" name='icone' value="<?php echo $utilisateurEnCours->getIcone() ?>" class="form-control"></td>
                                        <td>
                                        	<select class="form-control" name="role">
                                              <option value="0" <?php if ($utilisateurEnCours->getRole() == 0)echo  'selected ' ?>>Operateur</option>
                                              <option value="2" <?php if ($utilisateurEnCours->getRole() == 2)echo  'selected ' ?>>Administrateur</option>
                                              <option value="1" <?php if ($utilisateurEnCours->getRole() == 1)echo  'selected ' ?>>Standardiste</option>
                                            </select>
                                        </td>
                                        <td>
                                        	<select class="form-control" name="actif">
                                              <option value="0" <?php if ($utilisateurEnCours->getActif() == 0)echo  'selected ' ?>>Operateur</option>
                                              <option value="1" <?php if ($utilisateurEnCours->getActif() == 1)echo  'selected ' ?>>Standardiste</option>
                                            </select>
                                        </td>
                                        <td>
                                        <a href="/page/administrateur.php?action=supprimerUtilisateur&utilisateurID=<?php echo $utilisateur->getId() ?>" class="btn btn-danger text-white"><i class="fas fa-times-circle"></i></a>
                                        <button type="submit" class="btn btn-primary text-white" name="action" value="majUtilisateur"><i class="fas fa-arrow-circle-right"></i></button></td>
                                    </form>
                                    </tr>
                                
                     	
                    	
                   <?php        }
                    	}
                    }?>
                   </tbody>
                </table>
        	
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
