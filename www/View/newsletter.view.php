<!-- style a faire -->
<h1>Newsletter</h1>

<?php

$this->includePartial("form", $newsletter->getAddForm());

?>

<div class="table-liste">
    <!-- modif : ici on ne va afficher la table liste des news que s'il en existe -->
    <?php if (count($list)>0) { ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Titre</th>
                <th>Action</th>
            </tr>
            <!-- modif : on boucle sur la liste des news et on ajoute une row pour chaque news, si tu veux pas que ca soit une table pas de soucis -->
            <!-- il faut juste garder le foreach et les $val->getMachin -->
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