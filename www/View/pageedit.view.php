<h1>Page Edit</h1>
<a href="/administration/page">Revenir à la liste des pages</a>
<br><br><br>
<h2>Modif page</h2>
<?php $this->includePartial("form", $page->getEditForm()); ?>
<div class="edit-page">
    <div class="body-class" id="body-class">
        <h2 id="page-title"><?=$page->getTitle()?></h2>
    </div>

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

