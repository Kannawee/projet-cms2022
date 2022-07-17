<!-- style mais a faire mais la page va évoluer je te dirais qd c bon -->
<h1>Page Edit</h1>
<!-- modif : lien de retour a la liste -->
<a href="/administration/page">Revenir à la liste des pages</a>
<br><br><br>
<h2>Modif page</h2>
<!-- modif : form edit voir config dans model page getEditForm, attribut class pour changer les classes css -->
<div class="error">
    <?php if (isset($errors) && is_array($errors) && count($errors)>0) {
        foreach ($errors as $key => $error) {
            echo "(".($key+1).") ".$error."<br>";
        }
    } ?>
</div>

<?php $this->includePartial("form", $page->getEditForm()); ?>
<div class="edit-page">
    <!-- modif : va être la section où on affiche les elements de la page en prévisualisation -->
    <div class="body-class" id="body-class">
        <h2 id="page-title"><?=$page->getTitle()?></h2>
    </div>

    <!-- modif : va etre la section où j'affiche les form des modifications des elems -->
    <div class="tab-edit">
        
    </div>
</div>

<style>
    #page-title{
        text-align: center;
    }

    .edit-page{
        width: 100%;
        display: flex;
        margin-top: 50px;
    }

    .error{
        color: red;
    }

    .body-class{
        width: 78%;
        background-color: white;
        border: solid 1px #2ECFF0;
        border-radius: 5px;
        padding: 15px;
        display: flex;
        flex-direction: column;
    }

    .tab-edit{
        width: 20%;
        display: flex;
        flex-direction: column;
        margin-left: 2%;
        border: solid 1px #487AFB;
        border-radius: 5px;
        padding: 15px;
        background-color: white;
    }

    .tab-edit tr {
        padding: 5px;
    }

    .elem{
        margin: 5px;
    }

    .elem-edit{
        margin-bottom: 20px;
    }

    .formEditElemPage{
        display: flex;
        flex-direction: column;
    }
</style>

