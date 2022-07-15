<h1>Gestion Users</h1>

<?php if(isset($success) && $success!="") { ?>
    <div class="success">
        <?php if ($success=="ok") { ?>
            <span style="color:green;">Succès de(s) modification(s).</span>
        <?php } else { ?>
            <span style="color:red;">Erreur de(s) modification(s).</span>
        <?php } ?>
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
</style>