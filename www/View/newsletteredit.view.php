<h1>Newsletter</h1>

<div><a href="/administration/newsletter">Revenir à la liste des news</a></div><br>

<?php if ($success=="ok") { ?>
    <span style="color:green;">Changement apporté avec succès</span>
<?php } elseif($success=="notok") { ?>
    <span style="color:red;">Erreur dans le changement.</span>
<?php } elseif($success=="sent") { ?>
    <span style="color:green;">News envoyée avec succès</span>
<?php } elseif($success=="notsent") {?>
    <span style="color:red;">Erreur dans l'envoie de la news.</span>
<?php } ?>

<div class="form">
    <?php $this->includePartial("form", $newsletter->getEditForm()); ?>
</div>

<div class="form-action">
    <form action="/administration/newsletter/send" method="post">
        <input type="hidden" name="id_news" value="<?=$newsletter->getId()?>">
        <input type="submit" value="SEND">
    </form>

    <form action="/administration/newsletter/delete" method="post">
        <input type="hidden" name="id_news" value="<?=$newsletter->getId()?>">
        <input type="submit" value="DELETE">
    </form>
</div>

<div class="div-table">
    <h2>Subscribed users : </h2>
    <?php if (is_array($subscribed) && count($subscribed)>0) { ?>
        <table class="table">
            <tr>
                <th>Login</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        <?php foreach ($subscribed as $user) { ?>
            <tr>
                <td><?=$user['login']?></td>
                <td><?=$user['email']?></td>
                <td>
                    <form action="/administration/newsletter/unsubscribeuser" method="post">
                        <input type="hidden" name="id_user" value="<?=$user['id']?>">
                        <input type="hidden" name="id_newsletter" value="<?=$newsletter->getId()?>">
                        <input type="submit" value="DEL">
                    </form>
                </td>
            </tr>
        <?php } ?>
        </table>
    <?php } else {
        echo 'No subscribed user.';
    } ?>

    <h2>Users list : </h2>
    <?php if (is_array($userlist) && count($userlist)>0) { ?>
        <table>
            <tr>
                <th>Login</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        <?php foreach ($userlist as $user) { ?>
            <tr>
                <td><?=$user['login']?></td>
                <td><?=$user['email']?></td>
                <td>
                    <form action="/administration/newsletter/subscribeuser" method="post">
                        <input type="hidden" name="id_user" value="<?=$user['id']?>">
                        <input type="hidden" name="id_newsletter" value="<?=$newsletter->getId()?>">
                        <input type="submit" value="ADD">
                    </form>
                </td>
            </tr>
        <?php } ?>
        </table>
    <?php } else {
        echo 'No subscribed user.';
    } ?>
</div>


<style>
    .form form {
        display: flex;
        flex-direction: column;
        width: 30%;
    }

    .form-action {
        display: flex;
        margin-top: 15px;
    }

    .form-action form {
        margin-right: 15px;
    }
</style>