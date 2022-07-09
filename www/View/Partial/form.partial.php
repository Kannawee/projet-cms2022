<form class="<?= $data["config"]["class"]??"" ?>" method="<?= $data["config"]["method"]??"POST" ?>"  action="<?= $data["config"]["action"]??"" ?>">

    <?php if (isset($data["inputs"])) { foreach ($data["inputs"] as $name=>$input) :?>

    <input
            type="<?= $input["type"]??"text" ?>"
            name="<?= $name?>"
            placeholder="<?= $input["placeholder"]??"" ?>"
            id="<?= $input["id"]??"" ?>"
            class="<?= $input["class"]??"" ?>"
            <?= empty($input["required"])?"":'required="required"' ?>
            <?= empty($input["accept"])?"":'accept="'.$input["accept"].'"' ?>
    >

    <?php endforeach; } ?>


    <?php if (isset($data["textAreas"])) { foreach ($data["textAreas"] as $name => $textArea) :?>

    <textarea
            name="<?= $name?>"
            placeholder="<?= $textArea["placeholder"]??"" ?>"
            id="<?= $textArea["id"]??"" ?>"
            class="<?= $textArea["class"]??"" ?>"
            rows="<?= $textArea["rows"]??"" ?>"
            cols="<?= $textArea["col"]??"" ?>"
            <?= empty($input["required"])?"":'required="required"' ?>
    ></textarea>

    <?php endforeach; } ?>

    <input type="submit" value="<?= $data["config"]["submit"]??"Valider" ?>">

</form>
