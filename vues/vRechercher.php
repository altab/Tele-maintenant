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
        
        <p> <?php if(isset($_GET['recherche']))echo "Recherche effectuée : <b>".$_GET['recherche']."</b>"; else "Pas de recherche en cours !"?></p>
        
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
