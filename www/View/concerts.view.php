<!-- rien modifié -->
<h1>CONCERTS</h1>

<?php $this->includePartial("form", $concert->getAddForm()) ?>

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
