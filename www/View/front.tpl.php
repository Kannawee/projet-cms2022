<!-- je n'y ai pas touché -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Template FRONT</title>
    <meta name="description" content="Description de ma page">
</head>
<body>
    <div id="welcome">
        <nav id="navbar">
            <ul>
                <li><a href="/">Home</a></li>
                <?php if (isset($navLinks) && is_array($navLinks) && count($navLinks)>0) { 
                    foreach ($navLinks as $nav) { ?>
                        <li><a href="/page/<?=$nav->getRoute()?>"><?=$nav->getTitle()?></a></li>
                    <?php } ?>
                    
                <?php } ?>
            </ul>
            <ul>
                <?php if (!isset($_SESSION['idUser'])) { ?>
                    <li><a href="/register">Register</a></li>
                    <li><a href="/login">Log in</a></li>
                <?php } else { ?>
                    <?php if (isset($_SESSION['isAdmin']) && ($_SESSION['isAdmin']==1 || $_SESSION['isAdmin']==2)) {?>
                        <li><a href="/administration">Admin</a></li>
                    <?php } ?>
                    <li><a href="/logout">Log out</a></li>
                <?php } ?>
            </ul>
        </nav>
    
        <?php include "View/".$this->view.".view.php"; ?>
    </div>

</body>
</html>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200;400&display=swap');

    body {
        margin: 0 !important;
        font-family: 'Manrope', sans-serif;
        color: whitesmoke;
    }

    #welcome {
        min-height: 100%;
        background-image: url('assets/tmp-bg.png');
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