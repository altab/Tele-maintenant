/**
 * Script divers 
 * @author Philippe Cohen
 */

function submitForm() {
  return confirm('Êtes-vous sûr de vouloir supprimer definitivement ce ticket ?\nATTENTION, cette opération est irréversible !');
}

function deleteElements() {
  return confirm('Êtes-vous sûr de vouloir supprimer definitivement ce(s) élément(s) ?');
}

function clearFormInterlocuteur() {
  var nomInterlocuteur = document.querySelector("#nomInterlocuteur");
  var prenomInterlocuteur = document.querySelector("#prenomInterlocuteur");
  var telephoneInterlocuteur = document.querySelector("#telephoneInterlocuteur");
  var emailInterlocuteur = document.querySelector("#emailInterlocuteur");
  var listeSocietes = document.querySelector('#listesociete');

  nomInterlocuteur.addEventListener("click", clearAll );
  prenomInterlocuteur.addEventListener("click", clearAll );
  telephoneInterlocuteur.addEventListener("click", clearAll );
  emailInterlocuteur.addEventListener("click", clearAll );
  listeSocietes.addEventListener("click", function(){ listeSocietes.value=''; } );
  
}

function clearAll() {

  nomInterlocuteur.value = '';
  prenomInterlocuteur.value = '';
  telephoneInterlocuteur.value = '';
  emailInterlocuteur.value = '';

}

// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable( {
        "order": [[ 0, 'desc' ]],
        "language": {
            "lengthMenu": "Voir _MENU_ lignes",
            "search": "Rechercher",
            "zeroRecords": "Pas d'enregistrements - Désolé",
            "info": "Voir page _PAGE_ sur _PAGES_",
            "paginate": {
              "previous": "Précédente",
              "next": "Suivante"
            },
            "infoEmpty": "Pas d'enregistrement disponible",
            "infoFiltered": "(Filtré sur _MAX_ enregistrements total)",
            "order": [[0, 'desc']]
        }
    } );

});