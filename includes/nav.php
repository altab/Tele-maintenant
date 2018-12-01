<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="/index.php"><i class="fas fa-user-edit"></i> Télé-Maintenant</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" >
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="/page/rechercher.php" method="get">
        <div class="input-group">
          <input type="text" name="recherche" class="form-control" placeholder="<?php if(isset($_GET['recherche']))echo $_GET['recherche']; else echo "Rechercher..."?>">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" >
            [ <?php echo $nomUtilisateurEnCours?> ] <i class="fas fa-user-circle fa-fw"></i> 
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#"><i class="fas fa-cogs text-muted"></i> Paramètres</a>
            <div class="dropdown-divider"></div>
            
				<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="far fa-times-circle text-muted"></i> Quitter</a>
			</form>
          </div>
        </li>
      </ul>
    </nav>