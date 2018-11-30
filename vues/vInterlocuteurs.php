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
        
        <?php if(isset($warning)) echo "<div class=\"row bg-warning text-dark mx-1 mb-3 pt-3 px-3 pb-2\"><h5><i class=\"fas fa-exclamation-circle\"></i> $warning</h5></div>";?>
        
          <div class="row">
                <div class="col">
                	<?php require_once '../includes/nouvelInterlocuteur.php';?>
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
