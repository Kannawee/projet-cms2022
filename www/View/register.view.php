<!-- je n'y ai pas touché mais en gros il faudrait prévoir une section ou je peux display des errors tu peux mettre en dur, je m'occuperai d'appliquer le php dessus :) -->
<div id="welcome">
    <nav id="navbar">
        <ul>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Projets</a></li>
            <li><a href="#">Concerts</a></li>
        </ul>
        <ul>
            <li><a href="/register">S'inscrire</a></li>
            <li><a href="/login">Se connecter</a></li>
        </ul>
    </nav>
    <div>
        <div class="card">
            <div>
                <h1>S'inscrire</h1>
            </div>
            <?php $this->includePartial("form", $user->getRegisterForm()) ?>
        </div>
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

    .card {
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 8px;
        width: 30%;
        margin-left: auto;
        margin-right: auto;
        padding: 1.25rem;
        position: absolute;
        top: 35%;
        left: 35%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }

    .card h1 {
        margin: 0 0 1rem 0;
        font-size: 40px;
        letter-spacing: 6px;
    }

    .card input {
        background-color: transparent;
        border: none;
        border-bottom: 1px solid #ffffffb3;
        width: 70%;
        height: 2rem;
        font-size: 18px;
        font-weight: 200;
        color: white;
        margin-top: 1rem;
    }

    .card input::placeholder {
        color: #ffffffb3;
        font-weight: 200;
    }

    .card input:hover {
        border-bottom: 1px solid white;
    }

    .card input:last-child {
        border: 1px solid #ffffffb3;
        color: #ffffffb3;
        cursor: pointer;
        height: 3rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .card input:last-child:hover {
        border: 1px solid white;
        color: #ffffff;
    }

</style>
