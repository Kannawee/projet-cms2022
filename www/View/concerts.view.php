<!-- rien modifié -->
<h1>CONCERTS</h1>

<?php $this->includePartial("form", $concert->getAddForm()) ?>

<?php
foreach($tabConcerts as $key=>$val) {
    ?>
        <h2><?=$val['name']?></h2>
        <p><?=$val['date']?></p>
        <p><?=$val['venue']?></p>
        <p><?=$val['city']?></p>
        <p><?=$val['link']?></p>
    <?php
}
?>
