<h2>Edit Project</h2>

<a href="/administration/projects">Liste des projets</a>

<?php $this->includePartial("form", $project->getEditForm()) ?>
<br><br>
<a href="/administration/project/delete/<?=$project->getId()?>" class="button">DELETE</a>