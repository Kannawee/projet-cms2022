<h1>Newsletter</h1>

<?php if ($success=="ok") { ?>
    <span style="color:green;">Changement apporté avec succès</span>
<?php } elseif($success=="notok") { ?>
    <span style="color:red;">Erreur dans le changement.</span>
<?php } ?>

<?php

$this->includePartial("form", $newsletter->getEditForm());

?>

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
</div