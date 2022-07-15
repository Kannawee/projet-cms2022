<!-- style a faire -->
<h2>Edit Project</h2>
<!-- modif : lien retour liste -->
<a href="/administration/projects">Liste des projets</a>
<!-- modif : form edit project voir config dans model project geteditform attribut class pour class css -->
<?php $this->includePartial("form", $project->getEditForm()) ?>
<br><br>
<!-- modif : bouton delete sous forme de lien <a></a> -->
<a href="/administration/project/delete/<?=$project->getId()?>" class="button">DELETE</a>