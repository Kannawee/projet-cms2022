 <div id="welcome">
    <nav id="navbar">
        <ul>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Projets</a></li>
            <li><a href="#">Concerts</a></li>
        </ul>
        <ul>
            <?php if (!$connect) { ?>
                <li><a href="/register">S'inscrire</a></li>
                <li><a href="/login">Se connecter</a></li>
            <?php } else { ?>
                <li><a href="/logout">Se déconnecter</a></li>
            <?php } ?>
        </ul>
    </nav>
    <div id="title">
        <h1>Artistery.</h1>
    </div>
</div>

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

    #title {
        font-size: 6rem;
        text-align: center;
    }

    #title h1 {
        letter-spacing: 2rem;
        text-shadow: black;
    }
</style>