<?php 
require_once '../metier/Interlocuteur.php'; 

require_once '../DAO/connectDB.php';
$connexion = new connectDB();

$listeSocietes = $connexion->selectFromWhereSorted('id, nom', 'societe', '', '', 'nom', 'ASC') ; //('id, nom', 'societe', '', '');

$connexion = null;


?>
<!--  nouvel Interlocuteur -->
<div class="card  h-100">
	<div class="card-header  bg-info text-white"><i class="fas fa-user"></i> <?php  if(isset($InterlocuteurModif)) echo "Modifier l'utilisateur ".$InterlocuteurModif->getPrenom()." ".$InterlocuteurModif->getNom()." [ID:".$InterlocuteurModif->getId()."]"; else echo 'Ajouter un interlocuteur'; ?></div>
	<div class="card-body">
		<form action="/page/interlocuteurs.php" method="get">
		<?php  if(isset($InterlocuteurModif)) echo "<input type='hidden' name='idInterlocuteur' value='".$InterlocuteurModif->getId()."' />\n"; ?>
			<div class="form-group">

				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<label class="input-group-text bg-light prependPhilippe"
							for="inputGroupSelect01">Société*</label>
					</div>
					<select required class="custom-select" id="listeSoc" name="societeInterlocuteur">
					<option value="" disabled selected>Choisir une société (Obligatoire)</option>
					
						<?php 
						
						foreach ($listeSocietes as $societe) {
						    
                            $select = '';
                            if(isset($InterlocuteurModif)) {
         
                                if ($InterlocuteurModif->getSocieteID() == $societe['id']) $select = 'selected';
                            }
                            
                            echo "<option value='" . $societe['id'] . "' $select>" . ucfirst($societe['nom']) . "</option>\n";
						}?>

                      </select>
				</div>

				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text bg-light prependPhilippe">Nom*</span>
					</div>
					<input type="text" class="form-control" id="nomInterlocuteur"
						name="nomInterlocuteur"
						<?php  if(isset($InterlocuteurModif)) echo " value='".$InterlocuteurModif->getNom()."' ";?>
						placeholder="Entrer le nom de l'interlocuteur (Obligatoire)" required>
				</div>
				<div class="input-group mt-3">
					<div class="input-group-prepend">
						<span class="input-group-text bg-light prependPhilippe">Prénom*</span>
					</div>
					<input type="text" class="form-control" id="prenomInterlocuteur"
						name="prenomInterlocuteur"
						<?php  if(isset($InterlocuteurModif)) echo " value='".$InterlocuteurModif->getPrenom()."' ";?>
						placeholder="Entrer le prénom de l'interlocuteur (Obligatoire)" required>
				</div>

				<div class="input-group mt-3">
					<div class="input-group-prepend">
						<span class="input-group-text bg-light prependPhilippe">Téléphone</span>
					</div>
					<input type="text" class="form-control" id="telInterlocuteur"
						name="telInterlocuteur"
						<?php  if(isset($InterlocuteurModif)) echo " value='".$InterlocuteurModif->getTelephone()."' ";?>
						placeholder="Entrer le téléphone de l'interlocuteur"  maxlength="10">
				</div>
				<div class="input-group mt-3">
					<div class="input-group-prepend">
						<span class="input-group-text bg-light prependPhilippe">Email</span>
					</div>
					<input type=email class="form-control" id="emailInterlocuteur"
						name="emailInterlocuteur"
						<?php  if(isset($InterlocuteurModif)) echo " value='".$InterlocuteurModif->getEmail()."' ";?>
						placeholder="Entrer le mail de l'interlocuteur"> 
				</div>
				<small id="emailHelp" class="form-text text-muted">* = Champ requis.</small>
				<div class="form-group row">
					<div class="col-12">
						<button type="submit" class="btn btn-primary float-right"
							name="action" value="<?php  if(isset($InterlocuteurModif)) echo "modifierInterlocuteur"; else echo 'creerInterlocuteur'; ?>">
							<?php  if(isset($InterlocuteurModif)) echo "Modifier"; else echo 'Ajouter'; ?>
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
