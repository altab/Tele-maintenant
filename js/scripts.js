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

// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable( {
        "language": {
            "lengthMenu": "Voir _MENU_ tickets",
            "search": "Rechercher",
            "zeroRecords": "Pas d'enregistrements - Désolé",
            "info": "Voir page _PAGE_ sur _PAGES_",
            "paginate": {
              "previous": "Précédente",
              "next": "Suivante"
            },
            "infoEmpty": "Pas d'enregistrement disponible",
            "infoFiltered": "(Filtré sur _MAX_ enregistrements total)"
        }
    } );
});