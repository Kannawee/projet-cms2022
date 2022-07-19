<!-- style a faire -->
<h1>Gestion Users</h1>
<!-- gestion de success encore pareil, si success existe et !="" on display une span avec un style en dur en gros success peut être ok et not ok sinon c vide -->
<?php if(isset($success) && $success!="") { ?>
    <div class="success">
        <?php if ($success=="ok") { ?>
            <span style="color:green;">Succès de(s) modification(s).</span>
        <?php } ?>
    </div>
<?php } ?>

<?php if (isset($errors) && count($errors)>0) { ?>
<div class="error">
    <?php foreach ($errors as $key => $error) {
        echo "(".$key.") ".$error."<br>";
    } ?>
</div>
<?php } ?>

<div class="list">
    <?php if (count($listUser)>0) { ?>
        <table>
            <tr>
                <th>Login</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
            <?php foreach ($listUser as $user) { ?>
                <tr>
                    <td><?=$user->getLogin()?></td>
                    <td><?=$user->getEmail()?></td>
                    <td><?php $this->includePartial("form", $user->getRoleForm()) ?></td>
                </tr>
            <?php }
    } ?>
</div>

<style>
    .list{
        margin-top: 30px;
    }

    .error{
        color:red;
    }
</style>