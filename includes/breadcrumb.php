<?php 
$url = $_SERVER['PHP_SELF'];
if (!isset($sectionTitle)) $sectionTitle = ucfirst(basename($_SERVER['PHP_SELF'],'.php'));
?>
<div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#"><?php echo $sectionTitle; ?></a>
            </li>
            <li class="breadcrumb-item active"><?php if (isset($sectionSubject)) echo $sectionSubject; else  echo "Page"; ?></li>
          </ol>

        </div>
        <!-- /.container-fluid -->