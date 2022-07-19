<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#contentPost'
    });
</script>

<!-- style a faire -->
<h1>Gestion des posts</h1>
<!-- modif : form add post voir config dans model post getaddform attribut class pour class css -->
<?php $this->includePartial("form", $post->getAddForm()); ?>

<div class="list">
    <!-- modif : on vérifie s'il existe des posts si oui on affiche la table -->
    <?php if (isset($listPost) && count($listPost)>0) { ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Publié</th>
                <th>Action</th>
            </tr>
            <!-- modif : on boucle sur la liste des posts et on ajoute une row pr chaque post -->
            <?php foreach ($listPost as $key => $value) { ?>
                <tr>
                    <td><?= ($value->getTitle()=="")?"<i>Empty</i>":$value->getTitle()?></td>
                    <td><?=html_entity_decode(htmlspecialchars_decode($value->getContent()))?></td>
                    <td><?=$value->getPublished()?></td>
                    <td>
                        <!-- modif : bouton edit/delete sous forme de lien <a></a> -->
                        <a href="/administration/post/edit/<?=$value->getId()?>" class="button">EDIT</a>
                        <a href="/administration/post/delete/<?=$value->getId()?>" class="button">DEL</a>
                    </td>
                </tr>
            <?php } ?>
    <?php } ?>

</div>

<style>

    .list{
        margin-top: 50px;
    }

</style>