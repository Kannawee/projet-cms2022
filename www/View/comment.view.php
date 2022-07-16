<h1>Comments moderation</h1>

<?php if (is_array($listComment) && count($listComment)>0) { ?>
    <table>
        <tr>
            <th>Login</th>
            <th>Content</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        <?php foreach ($listComment as $key => $value) { ?>
            <tr>
                <td><?=$value['login']?></td>
                <td><?=$value['content']?></td>
                <td><?=$value['type']?></td>
                <td><a href="/administration/comment/accept/<?=$value['id']?>" class="button">OK</a><a href="/administration/comment/decline/<?=$value['id']?>" class="button">SUPP</a></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>

<style>
    td{
        padding: 10px;
    }
</style>