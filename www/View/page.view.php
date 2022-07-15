<h1>Liste des pages : </h1>

<?php $this->includePartial("form", $page->getAddForm()); ?>
<br><br><br><br><br><br><br><br>
<div class="list">
    <table>
        <tr>
            <th>Titre</th>
            <th>Visible</th>
            <th>Created at</th>
            <th>Action</th>
        </tr>
        <?php foreach ($allpages as $page) { ?>
            <tr>
                <td><?=$page->getTitle()?></td>
                <td><?=$page->getVisible()?></td>
                <td><?=$page->getCreatedAt()?></td>
                <td><a href="/administration/page/edit/<?=$page->getId()?>" class="button">EDIT</a><a class="button">DEL</a></td>
            </tr>
        <?php } ?>
    </table>
</div>

<style>
    .list{
        text-align: center;
    }
</style>