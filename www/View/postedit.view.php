<!-- style a faire -->
<h1>Post edit</h1>
<!-- modif : lien retour vers liste -->
<a href="/administration/posts">Liste des postes</a>
<!-- modif : form edit post voir config dans model post geteditform attribut class pour class css -->
<?php $this->includePartial("form", $post->getEditForm()); ?>