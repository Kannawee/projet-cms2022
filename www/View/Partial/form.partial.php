<form class="<?= $data["config"]["class"]??"" ?>" method="<?= $data["config"]["method"]??"POST" ?>"  action="<?= $data["config"]["action"]??"" ?>">

    <?php if (isset($data["inputs"])) { foreach ($data["inputs"] as $name=>$input) :?>

        <?php if(!empty($input['label'])) {
            echo '<label for="'.$name.'">'.$input['label'].' : </label>';
        } ?>

    <input
            type="<?= $input["type"]??"text" ?>"
            name="<?= $name?>"
            placeholder="<?= $input["placeholder"]??"" ?>"
            id="<?= $input["id"]??"" ?>"
            class="<?= $input["class"]??"" ?>"
            <?= empty($input["required"])?"":'required="required"' ?>
            <?= empty($input["accept"])?"":'accept="'.$input["accept"].'"' ?>
            <?php if(!empty($input["value"]) && $input["value"]!="") {
                echo 'value="'.$input["value"].'"';
            }?>

            <?php if(!empty($input["readonly"]) && $input["readonly"]) {
                echo 'readonly';
            }?>
            <?php if ($input['type']=='number' && isset($input['min'])) {
                echo 'min="'.$input['min'].'"';
            } ?>
            <?php if ($input['type']=='number' && isset($input['max'])) {
                echo 'max="'.$input['max'].'"';
            } ?>

    >

    <?php endforeach; } ?>


    <?php if (isset($data["textAreas"])) { foreach ($data["textAreas"] as $name => $textArea) :?>

        <?php if(!empty($textArea['label'])) {
            echo '<label for="'.$name.'">'.$textArea['label'].' : </label>';
        } ?>

    <textarea
            name="<?= $name?>"
            placeholder="<?= $textArea["placeholder"]??"" ?>"
            id="<?= $textArea["id"]??"" ?>"
            class="<?= $textArea["class"]??"" ?>"
            rows="<?= $textArea["rows"]??"" ?>"
            cols="<?= $textArea["col"]??"" ?>"
            <?= empty($input["required"])?"":'required="required"' ?>
    ><?php if(!empty($textArea["value"]) && $textArea["value"]!="") {
                echo $textArea["value"];
        }?></textarea>

    <?php endforeach; } ?>

    <?php if (isset($data["select"])) { foreach ($data["select"] as $name => $select) :?>
        <select name="<?=$name?>">
        <?php foreach ($select['options'] as $val => $lib) { ?>
            <option value="<?=$val?>"
            <?php if (isset($select['value']) && $val==$select['value']) {
                echo " selected";
            } ?>
            ><?=$lib?></option>
            
        <?php } ?>
        </select>
    <?php endforeach; } ?>

    <input type="submit" value="<?= $data["config"]["submit"]??"Valider" ?>">

</form>
