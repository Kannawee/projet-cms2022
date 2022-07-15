<h1>Gestion des posts</h1>

<?php $this->includePartial("form", $post->getAddForm()); ?>

<div class="list">

    <?php if (isset($listPost) && count($listPost)>0) { ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Publié</th>
                <th>Action</th>
            </tr>
            <?php foreach ($listPost as $key => $value) { ?>
                <tr>
                    <td><?= ($value->getTitle()=="")?"<i>Empty</i>":$value->getTitle()?></td>
                    <td><?=$value->getContent()?></td>
                    <td><?=$value->getPublished()?></td>
                    <td>
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