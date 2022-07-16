<h1>Installation</h1>

<?php  if (isset($error) && $error!="") { ?>
    <div style="color: red;">
        <?php if($error == "form") {
            echo "Erreur, donnée du formulaire vide";
        } elseif ($error=="database") {
            echo "Erreur dans la creation de la database";
        } elseif($error=="table") {
            echo "Erreur dans la creation des tables";
        } elseif($error=="insert") {
            echo "Erreur dans l'insertion de l'admin";
        }?>
    </div>
<?php } ?>

<?php if (!isset($step)) { ?>
    <form action="/" method="POST">
        <label for="dbuser">Database User : </label><br>
        <input type="text" name="dbuser" required><br>
        <label for="dbpwd">Database Password : </label><br>
        <input type="password" name="dbpwd" required><br>
        <label for="dbhost">Database Host : </label><br>
        <input type="text" name="dbhost" required><br>
        <label for="dbname">Database Name : </label><br>
        <input type="text" name="dbname" required><br>
        <label for="dbport">Database Port : </label><br>
        <input type="text" name="dbport" required><br>
        <label for="dbprefixe">Database Prefixe : </label><br>
        <input type="text" name="dbprefixe" required><br><br>
        <input type="submit">
    </form>
<?php } elseif ($step == 2) { ?>
    <form action="/install/step2" method="POST">
        <label for="adminlogin">Site Admin Login : </label><br>
        <input type="text" name="adminlogin" required><br>
        <label for="adminemail">Site Admin Mail : </label><br>
        <input type="text" name="adminemail" required><br>
        <label for="password">Site Admin Password : </label><br>
        <input type="password" name="password" required><br>
        <label for="passwordconfirm">Site Admin Password Confirm : </label><br>
        <input type="password" name="passwordconfirm" required><br><br>
        
        <input type="submit">
    </form>
<?php } elseif ($step==3) { ?>
    <form action="/install/step3" method="POST">
        <label for="newsmail">Mail News : </label><br>
        <input type="email" name="newsmail" required><br>
        <label for="newspwd">Password application : </label><br>
        <input type="text" name="newspwd" required><br><br>
        
        <input type="submit">
    </form>
<?php } ?>