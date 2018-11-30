<?php
require_once '../DAO/connectDB.php';
$connexion = new connectDB();

$listeSocietes = $connexion->selectFromWhere('id, nom', 'societe', '', '');

$connexion = null;
?>
<!--  nouvel Interlocuteur -->
<div class="card  h-100">
	<div class="card-header  bg-info text-white"><i class="fas fa-user"></i> Ajouter un Interlocuteur</div>
	<div class="card-body">
		<form action="/page/clients.php" methode="post">
			<div class="form-group">

				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<label class="input-group-text bg-light prependPhilippe"
							for="inputGroupSelect01">Société*</label>
					</div>
					<select required class="custom-select" id="inputGroupSelect01" >
					<option value="" disabled selected>Choisir une société (Obligatoire)</option>
						<?php
                        foreach ($listeSocietes as $societe)
                            echo "<option value='" . $societe['id'] . "'>" . ucfirst($societe['nom']) . "</option>";
                        ?>

                      </select>
				</div>

				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text bg-light prependPhilippe">Nom*</span>
					</div>
					<input type="text" class="form-control" id="nomInterlocuteur"
						name="nomInterlocuteur"
						placeholder="Entrer le nom de l'interlocuteur (Obligatoire)" required>
				</div>

				<div class="input-group mt-3">
					<div class="input-group-prepend">
						<span class="input-group-text bg-light prependPhilippe">Téléphone</span>
					</div>
					<input type="text" class="form-control" id="telInterlocuteur"
						name="telInterlocuteur"
						placeholder="Entrer le téléphone de l'interlocuteur"  maxlength="10">
				</div>
				<div class="input-group mt-3">
					<div class="input-group-prepend">
						<span class="input-group-text bg-light prependPhilippe">Email</span>
					</div>
					<input type=email class="form-control" id="emailInterlocuteur"
						name="emailInterlocuteur"
						placeholder="Entrer le mail de l'interlocuteur"> 
				</div>
				<small id="emailHelp" class="form-text text-muted">* = Champ requis.</small>
				<div class="form-group row">
					<div class="col-12">
						<button type="submit" class="btn btn-primary float-right"
							name="action" value="creerInterlocuteur">Ajouter</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
