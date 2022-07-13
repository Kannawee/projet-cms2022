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
                    <td><?=$val['date']?></td>
                    <td><?=$val['title']?></td>
                    <td>
                        <a class="button" href="/administration/newsletter/edit/<?=$val['id']?>">EDIT</a>
                        <a class="button" href="/administration/newsletter/delete/<?=$val['id']?>">DEL</a>
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

    .button {
        display: block;
        width: 75px;
        height: 15px;
        background: #4E9CAF;
        padding: 10px;
        text-align: center;
        border-radius: 5px;
        color: white;
        font-weight: bold;
        line-height: 15px;
        margin-bottom: 10px;
    }
</style>