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
    <input type="text" name="dbprefixe" required><br>
    
    <br><br><br>

    <label for="emailAdmin">Site Email Admin : </label><br>
    <input type="text" name="emailAdmin" required><br>
    <label for="loginAdmin">Site Login Admin : </label><br>
    <input type="text" name="loginAdmin" required><br>
    <label for="password">Site Password Admin : </label><br>
    <input type="password" name="password" required><br>
    <input type="submit">
</form>