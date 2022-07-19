<!-- rien modifié -->
<h1>CONCERTS</h1>

<?php $this->includePartial("form", $concert->getAddForm()) ?>

<?php if (isset($errors) && is_array($errors) && count($errors)>0) { ?>
<div class="error">
    <?php foreach ($errors as $key => $error) {
        echo "(".$key.") ".$error."<br>";
    } ?>
</div>
<?php } ?>

<?php
foreach($tabConcerts as $key=>$val) {
    ?>
        <h2><?=$val->getName()?></h2>
        <p><?=$val->getDate()?></p>
        <p><?=$val->getVenue()?></p>
        <p><?=$val->getCity()?></p>
        <p><?=$val->getLink()?></p>
    <?php
}
?>


<style>
    .error{
        color: red;
    }
</style>
