<h1>Newsletter</h1>

<?php

$this->includePartial("form", $newsletter->getAddForm());

?>

<div class="table-liste">
    <?php if (count($list)>0) { ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Titre</th>
                <th>Action</th>
            </tr>
            <?php foreach ($list as $key=>$val) { ?>
                <tr>
                    <td><?=$val->getDate()?></td>
                    <td><?=$val->getTitle()?></td>
                    <td>
                        <a class="button" href="/administration/newsletter/edit/<?=$val->getId()?>">EDIT</a>
                        <a class="button" href="/administration/newsletter/delete/<?=$val->getId()?>">DEL</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
</div>






<style>
    .table-liste{
        margin-top: 70px;
    }

    .table-liste td{
        padding: 20px;
    }
</style>