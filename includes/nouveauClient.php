<?php require_once '../metier/Societe.php'; ?>
<!--  nouveau client -->
<div class="card  h-100">
	<div class="card-header  bg-info text-white"><i class="fas fa-industry"></i> <?php if(isset($societeModif)) echo "Modifier la société ".$societeModif->getNom()." [ID:".$societeModif->getId()."]"; else echo 'Créer une société'; ?></div>
	<div class="card-body">
		<form action="/page/clients.php" methode="post">
		<?php if(isset($societeModif)) echo "<input type='hidden' name='idSociete' value='".$societeModif->getID()."' />"; ?>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend ">
						<span class="input-group-text bg-light text-dark prependPhilippe">Nom*</span>
					</div>
					<input type="text" class="form-control" id="nomSociete"
						name="nomSociete" placeholder="Entrer le nom de la société" value="<?php if(isset($societeModif)) echo $societeModif->getNom(); ?>" 
						required>

				</div>
				<div class="input-group mt-3">
					<div class="input-group-prepend">
						<span class="input-group-text bg-light text-dark prependPhilippe">Téléphone</span>
					</div>
					<input type="text" class="form-control" id="telSociete"  value="<?php if(isset($societeModif)) echo $societeModif->getTelephone(); ?>"
						name="telSociete" placeholder="Entrer le téléphone de la société"  maxlength="10">
				</div>
				<div class="input-group mt-3">
					<div class="input-group-prepend">
						<span class="input-group-text bg-light text-dark prependPhilippe">Email</span>
					</div>
					<input type=email class="form-control" id="emailSociete" value="<?php if(isset($societeModif)) echo $societeModif->getEmail(); ?>"
						name="emailSociete" placeholder="Entrer le mail de la société">
				</div>
				<div class="input-group my-3">
					<div class="input-group-prepend">
						<span class="input-group-text bg-light text-dark prependPhilippe">Adresse</span>
					</div>
					<textarea class="form-control" id="adresseSociete"
						name="adresseSociete" rows="3"  
						placeholder="Entrer l'adresse de la société"><?php if(isset($societeModif)) echo $societeModif->getAdresse(); ?></textarea>
				</div>
				<small id="emailHelp" class="form-text text-muted">* =  champ requis.</small>
				<div class="form-group row">
					<div class="col-12">
						<button type="submit" class="btn btn-primary float-right"
							name="action" value="<?php if(isset($societeModif)) echo "modifierSociete"; else echo "creerSociete"; ?>"><?php if(isset($societeModif)) echo "Modifier"; else echo 'Ajouter'; ?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
