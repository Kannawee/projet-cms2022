<!-- style a faire -->
<h1>Liste des pages : </h1>

<!-- modif : formulaire add voir config dans model page getaddform attribut class de config pour changer ses class css -->
<div class="error">
    <?php if (isset($errors) && is_array($errors) && count($errors)>0) {
        foreach ($errors as $key => $error) {
            echo "(".$key.") ".$error."<br>";
        }
    } ?>
</div>
<?php $this->includePartial("form", $page->getAddForm()); ?>
<!-- modif : brbrbrbrbr bien sal fais toi plaisir :') -->
<br><br><br><br><br><br><br><br>
<div class="list">
    <table>
        <tr>
            <th>Titre</th>
            <th>Route</th>
            <th>Visible</th>
            <th>Created at</th>
            <th>Action</th>
        </tr>
        <!-- modif : on boucles sur la liste des pages et on ajoute une row a chaque fois -->
        <?php foreach ($allpages as $page) { ?>
            <tr>
                <td><?=$page->getTitle()?></td>
                <td><?=$page->getRoute()?></td>
                <td><?=$page->getVisible()?></td>
                <td><?=$page->getCreatedAt()?></td>
                <td><a href="/administration/page/edit/<?=$page->getId()?>" class="button">EDIT</a><a href="/administration/page/delete/<?=$page->getId()?>" class="button">DEL</a></td>
            </tr>
        <?php } ?>
    </table>
</div>

<style>
    .list{
        text-align: center;
    }

    .error{
        color: red;
    }
</style>