<body class="body-dashboard">

<nav class="navbar">

    <ul>
        <li class="nav-button selected" onclick="hideShowSection(this);"><img class="icon-nav" src="images/icones/icon_dashboard.svg"><a href="/administration/dashboard">Dashboard</a></li>
        <li class="nav-button" onclick="hideShowSection(this);"><img class="icon-nav" src="images/icones/icon_users.svg"><a href="/administration/users">Users</a></li>
        <li class="nav-button" onclick="event.preventDefault(); hideShowSection(this);"><img class="icon-nav" src="images/icones/icon_projects.svg"><a href="/administration/projects">Projects</a></li>
        <li class="nav-button" onclick="event.preventDefault(); hideShowSection(this);"><img class="icon-nav" src="images/icones/icon_concerts.svg"><a href="/administration/concerts">Concerts</a></li>
        <li class="nav-button" onclick="event.preventDefault(); hideShowSection(this);"><img class="icon-nav" src="images/icones/icon_newsletter.svg"><a href="/administration/newsletter">Newsletter</a></li>
        <li class="nav-button" onclick="hideShowSection(this);"><img class="icon-nav" src="images/icones/icon_templates.svg"><a href="templates">Templates</a></li>
        <li class="nav-title-sub">
            <img class="icon-nav" src="images/icones/icon_pages.svg">Pages
            <span class="nav-subsection">
          <ul>
            <li class="nav-button">Discography</li>
            <li class="nav-button">Concerts</li>
            <li class="nav-button">About us</li>
          </ul>
        </span>
        </li>
        <li class="nav-button"><img class="icon-nav" src="images/icones/icon_logout.svg"><a href="/logout">Log out</a></li>
    </ul>
</nav>

<section class="section-content">

    <!--  ROW CARDS PROJECTS  -->
    <section class="card-block">
        <h1>Your projects</h1>
        <div class="row">
            <div style="width: 40%; display: flex; align-items: center;">
                <div class="card">
                    <?php $this->includePartial("form", $project->getAddForm()) ?>
                </div>
            </div>
            <div style="width: 60%">
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>xxx</th>
                                <th>xxxx</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>xxxxxxxx</td>
                                <td>xxxxxxxxxx</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>

    <!--  HIDDEN ROW ADD PROJECTS / ADD SONGS  -->
    <section class="card-block">
        <h1>Details</h1>

        <div>
            <?php
                var_dump($project);
            ?>
        </div>
    </section>
</section>

</body>

<style>

    h1 {
        margin: 0;
    }

    .navbar ul li a {
        font-weight: 200;
    }

    .card-block {
        height: 46%;
        padding-top: 2%;
        /*padding-top: 4%;*/
    }

    .row {
        width: 100%;
        height: 100%;
        display: flex;
    }

    .card {
        background-color: white;
        box-shadow: rgb(138 213 243 / 55%) 0px 2px 8px 0px;
        width: 90%;
        height: 90%;
        border-radius: 12px;
        display: flex;
        justify-content: space-evenly;
        align-items: center;
    }

    .card .formAddProject {
        width: 90%;
        height: 90%;
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        flex-direction: column;
    }
</style>