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

<?php if (isset($errors) && is_array($errors) && count($errors)>0) {
    echo 'Error : <br>';
    foreach ($errors as $key => $err) {
        echo "<span style=\"color: red;\">(".$key.") ".$err."</span><br>";
    }
    echo '<br><br>';
}

?>

<?php if (!isset($step)) { ?>

    <?php $this->includePartial("form", $installer->getFormStep1()) ?>

<?php } elseif ($step == 2) { ?>

    <?php $this->includePartial("form", $installer->getFormStep2()) ?>

<?php } elseif ($step==3) { ?>

    <?php $this->includePartial("form", $installer->getFormStep3()) ?>
<?php } ?>