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