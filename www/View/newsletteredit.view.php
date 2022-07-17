<!-- style a faire -->
<h1>Newsletter</h1>

<div><a href="/administration/newsletter">Revenir à la liste des news</a></div><br>

<!-- modif: ici c'est la gestion des erreurs vraiment un peu à l'arrache en gros je test la valeur de $success et en fonction de ca j'affiche -->
<!-- une span avec une couleur en dure. Sal non? -->
<?php if ($success=="ok") { ?>
    <span style="color:green;">Changement apporté avec succès</span>
<?php } elseif($success=="notok") { ?>
    <span style="color:red;">Erreur dans le changement.</span>
<?php } elseif($success=="sent") { ?>
    <span style="color:green;">News envoyée avec succès</span>
<?php } elseif($success=="notsent") {?>
    <span style="color:red;">Erreur dans l'envoie de la news.</span>
<?php } ?>

<!-- modif : formulaire voire confid dans model newsletter getEditForm (attribut class pour changer ses classes) -->
<div class="form">
    <?php $this->includePartial("form", $newsletter->getEditForm()); ?>
</div>

<!-- modif : div qui va contenir les boutons envoyer et delete sous forme de lien <a> -->
<div class="form-action">

    <?php if($newsletter->getActive()!=1) {  ?>
    <a href="/administration/newsletter/send/<?=$newsletter->getId()?>" class="button">SEND</a>
    <?php } ?>
    &nbsp;&nbsp;&nbsp;
    <a href="/administration/newsletter/delete/<?=$newsletter->getId()?>" class="button">DEL</a>
</div>

<div class="div-table">
    <h2>Subscribed users : </h2>
    <!-- modif : ici on regarde s'il y a des user inscrits -->
    <?php if (is_array($subscribed) && count($subscribed)>0) { ?>
        <table class="table">
            <tr>
                <th>Login</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        <!-- modif : on boucle sur les users inscrit et on ajoute une row pour chaque -->
        <?php foreach ($subscribed as $user) { ?>
            <tr>
                <td><?=$user->getLogin()?></td>
                <td><?=$user->getEmail()?></td>
                <td>
                    <a href="/administration/newsletter/unsubscribeuser/<?=$user->getId()?>/<?=$newsletter->getId()?>" class="button">DEL</a>
                </td>
            </tr>
        <?php } ?>
        </table>
    <?php } else {
        echo 'No subscribed user.';
    } ?>

    <h2>Users list : </h2>
    <!-- modif : on vérifie qu'il y ai des user non iscrits et on affiche la table le cas échéant -->
    <?php if (is_array($userlist) && count($userlist)>0) { ?>
        <table>
            <tr>
                <th>Login</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        <!-- modif : on boucle sur la liste des utilisateurs non inscrits et on rajoute une row a chaque fois -->
        <?php foreach ($userlist as $user) { ?>
            <tr>
                <td><?=$user->getLogin()?></td>
                <td><?=$user->getEmail()?></td>
                <td>
                    <a href="/administration/newsletter/subscribeuser/<?=$user->getId()?>/<?=$newsletter->getId()?>" class="button">ADD</a>
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