<form class="<?= $data["config"]["class"]??"" ?>" method="<?= $data["config"]["method"]??"POST" ?>"  action="<?= $data["config"]["action"]??"" ?>" enctype="<?= $data["config"]["enctype"]??"" ?>" >

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
            <?= (empty($textArea["required"]))?"":'required="required"' ?>
    ><?php if(!empty($textArea["value"]) && $textArea["value"]!="") {
                echo htmlspecialchars_decode($textArea["value"]);
        }?></textarea>

    <?php endforeach; } ?>

    <?php if (isset($data["select"])) { foreach ($data["select"] as $name => $select) :?>
        <?php if (!empty($select['label'])) { ?>
            <label for="<?=$name?>"><?=$select['label']?> : </label>
        <?php } ?>
        <select name="<?=$name?>">
        <?php if (isset($select['placeholder'])) {?>
            <option><?=$select['placeholder']?></option>
        <?php } ?>
        <?php foreach ($select['options'] as $val => $lib) { ?>
            <option value="<?=$val?>"
            <?php if (isset($select['value']) && !is_null($select['value']) && $val==$select['value']) {
                echo " selected";
            } ?>
            ><?=$lib?></option>
            
        <?php } ?>
        </select>
    <?php endforeach; } ?>

    <?php if(isset($data["checkbox"])) { foreach ($data["checkbox"] as $name => $checkbox): ?>
        <?php if (!empty($checkbox['label'])) { ?>
            <br>
            <label for="<?=$name?>"><?=$checkbox['label']?> : </label>
            <input type="checkbox" name="<?=$name?>" 
            <?=(isset($checkbox['id']))?'id="'.$checkbox['id'].'"':""?>
            checked>
        <?php } ?>
    <?php endforeach; } ?>

    <!-- <?php
    $csrf = substr(bin2hex(random_bytes(128)), 0, 255);
    $_SESSION['csrf'] = $csrf;
    ?>
    <input type="hidden" name="csrf" value="<?=$csrf?>"> -->
    
    <input type="submit" value="<?= $data["config"]["submit"]??"Valider" ?>">

</form>
