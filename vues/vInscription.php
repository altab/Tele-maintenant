<!DOCTYPE html>
<html lang="FR-fr">

  <head>

    <?php require_once '../includes/head.php';?>

    <title>Inscription - Télé-Maintenant</title>

  </head>

  <body class="bg-image">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">Créer un compte utilisateur</div>
        <div class="card-body">
          <form action="/page/inscription.php" method="post">
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="nom" name="nom" class="form-control" placeholder="Nom" required="required" autofocus="autofocus">
                    <label for="nom">Nom</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Prénom" required="required">
                    <label for="prenom">Prénom</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" required="required">
                <label for="email">Email</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Mot de passe" required="required">
                    <label for="password">Mot de passe</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" id="confirmPassword"  name="confirmPassword" class="form-control" placeholder="Confirmation Mot de passe" required="required">
                    <label for="confirmPassword">Confirmation Mot de passe</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <select id="role" name="role" class="form-control" placeholder="Je suis" required="required">
                <option value="" >Mon rôle...</option>
                <option value="0">Opérateur de télémaintenance</option>
                <option value="2">Standardiste / Dispatcher</option>
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block" name="action" value="creerUtilisateur">S'inscrire</button>
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="<?php echo "http://" . $_SERVER['SERVER_NAME']."/"?>page/login.php">Connexion</a>
            <a class="d-block small" href="#">Mot de passe oublié ?</a>
          </div>
        </div>
        <div class="card-footer text-center <?php if(isset($warning)) echo $warningColor; ?>"><?php if(isset($warning)) echo $warning; ?></div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo "http://" . $_SERVER['SERVER_NAME']."/"?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo "http://" . $_SERVER['SERVER_NAME']."/"?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo "http://" . $_SERVER['SERVER_NAME']."/"?>vendor/jquery-easing/jquery.easing.min.js"></script>

  </body>

</html>
