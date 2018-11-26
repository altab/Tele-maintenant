<!DOCTYPE html>
<html lang="FR-fr">

  <head>

    <?php require_once '../includes/head.php';?>

    <title>Télé-Maintenant - Connexion</title>

  </head>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Connexion</div>
        <div class="card-body">
          <form action="/page/login.php" method="post">
            <div class="form-group">
              <div class="form-label-group">
                <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
                <label for="inputEmail">Adresse Email</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="required">
                <label for="inputPassword">Mot-de-passe</label>
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="opt" value="rmbr">
                  Se souvenir de moi
                </label>
              </div>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Connexion</button>
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="#">Créer un compte</a>
            <a class="d-block small" href="#">Mot de passe oublié ?</a>
          </div>
        </div>
      	<?php if  ( isset($_GET['connexion']) && $_GET['connexion'] == 'ko' ) {?>
				<div class="card-footer bg-danger text-white text-center">
  					  Identifiant ou mot-de-passe incorrect ! 
 				</div>
			<?php }?>
      
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo "http://" . $_SERVER['SERVER_NAME']."/"?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo "http://" . $_SERVER['SERVER_NAME']."/"?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo "http://" . $_SERVER['SERVER_NAME']."/"?>vendor/jquery-easing/jquery.easing.min.js"></script>

  </body>

</html>
