<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <?php if (!is_null($page->getDescSEO())) { ?>
        <meta name="desciption" content="<?=$page->getDescSEO()?>">
    <?php } ?>
    <?php if (!is_null($page->getKwordsSEO())) { ?>
        <meta name="keywords" content="<?=$page->getKwordsSEO()?>">
    <?php } ?>
    <title><?=$page->getTitle()?></title>
</head>

<body>
    <div id="welcome">
        <nav id="navbar">
            <ul>
                <li><a href="/">Home</a></li>

                <?php if(isset($navLink) && is_array($navLink) && count($navLink)>0) { 
                    foreach ($navLink as $key => $nav) { ?>
                        <li><a href="/page/<?=$nav->getRoute()?>"><?=$nav->getTitle()?></a></li>
                <?php }} ?>
            </ul>
            <ul>
                <?php if (!isset($_SESSION['idUser'])) { ?>
                    <li><a href="/register">Register</a></li>
                    <li><a href="/login">Log In</a></li>
                <?php } else { ?>
                    <?php if (isset($_SESSION['isAdmin']) && ($_SESSION['isAdmin']==1 || $_SESSION['isAdmin']==2)) { ?>
                        <li><a href="/administration">Admin</a></li>
                    <?php } ?>
                    <li><a href="/logout">Log out</a></li>
                <?php } ?>
            </ul>
        </nav>
        <h1 class="title-page"><?=$page->getTitle()?></h1>

        <?php if (isset($_GET['success']) ) { 
            if ($_GET['success']=="ok") { ?>
                <div style="color: #03bb03; font-weight: bold">Comment has been successfully added, it is waiting for moderation validation.</div>
            <?php } elseif ($_GET['success']=="nok") { ?>
                <div style="color: red; font-weight: bold;">Error when adding the comment.</div>
        <?php }
        } ?>

        <?php if (isset($listObj) && is_array($listObj) && count($listObj)>0) { ?>
            <?php foreach ($listObj as $obj) { 
                if ($type=="post") {?>
                    <article class="entity">
                        <span class="entity-post"><?=html_entity_decode(htmlspecialchars_decode($obj->getContent()))?></span>

                        <section class="comment-section">
                            <?php if (isset($_SESSION['idUser'])) {
                                $this->includePartial("form", $comm->getAddForm($type, $obj->getId(), $page->getRoute())); 
                            } ?>

                            <?php if (isset($listComm[$obj->getId()])) { ?>
                                <section class="list-comments">
                                    <?php foreach ($listComm[$obj->getId()] as $value) { ?>
                                        <div class="comment">
                                            User : <?=$value['login']?><br>
                                            <?php
                                                $date1 = new DateTime($value['created_at']);
                                                $date2 = new DateTime();

                                                $diff = $date1->diff($date2);

                                                echo $diff->format('Posted %d days, %H hours and %i minutes ago')."<br><br>";
                                            ?>
                                            <?=$value['content']?><br>
                                        </div>
                                    <?php } ?>
                                </section>
                            <?php } ?>
                        </section>
                    </article>
                <?php } elseif($type=="concert") { ?>
                    <article class="entity">
                        <h3><?=$obj->getName()?></h3><br>
                        <date><?=$obj->getDate()?></date><br>
                        <p>Venue : <?=$obj->getVenue()?></p><br>
                        <p>City : <?=$obj->getCity()?></p><br>
                        <p><a href="<?=$obj->getLink()?>">Acheter vos billets</a></p>


                        <section class="comment-section">
                            <?php if (isset($_SESSION['idUser'])) {
                                $this->includePartial("form", $comm->getAddForm($type, $obj->getId(), $page->getRoute())); 
                            } ?>

                            <?php if (isset($listComm[$obj->getId()])) { ?>
                                <section class="list-comments">
                                    <?php foreach ($listComm[$obj->getId()] as $value) { ?>
                                        <div class="comment">
                                            User : <?=$value['login']?><br>
                                            <?php
                                                $date1 = new DateTime($value['created_at']);
                                                $date2 = new DateTime();

                                                $diff = $date1->diff($date2);

                                                echo $diff->format('Posted %d days, %H hours and %i minutes ago')."<br><br>";
                                            ?>
                                            <?=$value['content']?><br>
                                        </div>
                                    <?php } ?>
                                </section>
                            <?php } ?>
                        </section>

                    </article>
                <?php } elseif ($type=="project") { ?>
                    <article class="entity">
                        <h3><?=$obj->getName()?></h3><br>
                        Release date : 
                        <date><?=$obj->getDate()?></date><br>
                        <?php 
                        $cover = "";
                        if (is_null($obj->getCover())) {
                            $cover = "../assets/tmp_cover.png";
                        } else {
                            $cover = $obj->getCover();
                        } ?>
                        <section class="project-info">
                            <p><img src="<?=$cover?>" /></p>
                            <section class="description-project"><?=$obj->getDescription()?></section>
                        </section>
                        <a href="/project/<?=$obj->getId()?>">See this project</a>
                        


                        <section class="comment-section">
                            <?php if (isset($_SESSION['idUser'])) {
                                $this->includePartial("form", $comm->getAddForm($type, $obj->getId(), $page->getRoute())); 
                            } ?>

                            <?php if (isset($listComm[$obj->getId()])) { ?>
                                <section class="list-comments">
                                    <?php foreach ($listComm[$obj->getId()] as $value) { ?>
                                        <div class="comment">
                                            User : <?=$value['login']?><br>
                                            <?php
                                                $date1 = new DateTime($value['created_at']);
                                                $date2 = new DateTime();

                                                $diff = $date1->diff($date2);

                                                echo $diff->format('Posted %d days, %H hours and %i minutes ago')."<br><br>";
                                            ?>
                                            <?=$value['content']?><br>
                                        </div>
                                    <?php } ?>
                                </section>
                            <?php } ?>
                        </section>

                    </article>
                <?php }
            } ?>
        <?php } ?>
    </div>
</body>

<style>
    .entity{
        border: solid 1px;
        border-radius: 10px;
        margin-bottom: 25px;
        padding: 10px;
        background-color: rgb(0 0 0 / 38%);
        margin-left: 20px;
        margin-right: 20px;
    }

    .entity-post{
        text-align: left;
    }

    .comment{
        border-bottom: dotted 1px #6958F0;
        width: 100%;
        padding-bottom: 10px;
        margin-top: 10px;
        background-color: rgb(0 0 0 / 40%);
    }

    .comment-section{
        margin-top: 40px;
    }

    body{
        /* background-color: #f4e6cb63; */
    }

    .title-page{
        text-align: center;
    }

    .project-info{
        display: flex;
        flex-direction: row;
        justify-content: center;
    }

    .description-project{
        margin-left: 50px;
        background-color: rgb(0 0 0 / 47%);
        width: 70%;
        text-align: left;
        padding: 20px;
        font-style: italic;
    }
</style>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200;400&display=swap');

    body {
        margin: 0 !important;
        font-family: 'Manrope', sans-serif;
        color: whitesmoke;
    }

    #welcome {
        min-height: 100%;
        background-image: url('../assets/tmp-bg.png');
        background-repeat: no-repeat;
        background-size: cover;
        text-align: center;
    }

    #navbar {
        background-image: linear-gradient(to bottom, rgba(0,0,0,0.7), rgba(255,0,0,0));
        display: inline-flex;
        width: 100%;
        justify-content: space-between;
    }

    #navbar ul {
        display: inline-flex;
        margin: 0;
        padding: 0;
    }

    #navbar li {
        list-style: none;
        padding: 1rem 2rem;
    }

    #navbar li:hover {
        background-image: linear-gradient(to bottom, rgba(0,0,0,0.9), rgba(255,0,0,0));
    }

    #navbar a {
        text-decoration: none;
        color: whitesmoke;
    }

    html, body {
        height: 100% !important;
        margin: 0 !important;
    }
</style>