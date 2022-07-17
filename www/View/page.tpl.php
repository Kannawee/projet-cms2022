<?php if (isset($errors) && is_array($errors) && count($errors)>0) { ?>
    <div class="error">
        <?php foreach ($errors as $key => $error) {
            echo "(".($key+1).") ".$error."<br>";
        } ?>
    </div>
<?php } else { ?>
    <div class="body-page">
        <h1><?=$page->getTitle()?></h1>
    </div>
<?php } ?>