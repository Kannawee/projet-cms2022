<!-- J'ai un peu modifié l'ordre et ajouter les Pages et les posts peut être leur trouver un logo -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration du site</title>
    <link href="/style.css" rel="stylesheet" />
    <meta name="description" content="Description de ma page">
</head>
<body class="body-dashboard">

    <nav class="navbar">
        <ul>
            <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']==1) { ?>
                <li class="nav-button"><img class="icon-nav" src="/assets/icones/icon_dashboard.svg" alt="logo dashboard"><a href="/administration/">Dashboard</a></li>
                <li class="nav-button"><img class="icon-nav" src="/assets/icones/icon_users.svg" alt="logo user"><a href="/administration/users">Users</a></li>
                <li class="nav-button"><img class="icon-nav" src="/assets/icones/icon_pages.svg" alt="logo posts"><a href="/administration/posts">Posts</a></li>
                <li class="nav-button"><img class="icon-nav" src="/assets/icones/icon_projects.svg" alt="logo projets"><a href="/administration/projects">Projects</a></li>
                <li class="nav-button"><img class="icon-nav" src="/assets/icones/icon_concerts.svg" alt="logo concerts"><a href="/administration/concerts">Concerts</a></li>
                <li class="nav-button"><img class="icon-nav" src="/assets/icones/icon_pages.svg" alt="logo pages"><a href="/administration/page">Pages</a></li>
                <li class="nav-button"><img class="icon-nav" src="/assets/icones/icon_newsletter.svg" alt="logo newsletters"><a href="/administration/newsletter">Newsletter</a></li>
            <?php } ?>
            <li class="nav-button"><img class="icon-nav" src="/assets/icones/icon_pages.svg" alt="logo projects"><a href="/administration/commentmod">Comment Moderation</a></li>
            <li class="nav-button"><img class="icon-nav" src="/assets/icones/icon_logout.svg"><a href="/logout">Log out</a></li>
        </ul>
    </nav>
    <section class="section-content">
        <?php include "View/".$this->view.".view.php"; ?>
    </section>
</body>
</html>
<script src="/js/main.js" type="text/javascript"></script>