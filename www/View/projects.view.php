<!-- je n'y ai pas touché, j'ai juste changé les $val[''] en $val->getMachin() pcq mnt la fonction select renvoie des objets et non des tableaux :) -->
<!--  ROW CARDS PROJECTS  -->
<section class="card-block">
    <h1>Add a new project</h1>
    <div class="card">
        <?php $this->includePartial("form", $project->getAddForm()) ?>
    </div>
</section>

<section class="card-block">
    <h1>Your projects</h1>

        <div>
            <?php
                if ($tabProjects) {
                    foreach($tabProjects as $key=>$val) {
            ?>
                    <a href="/administration/projects/<?=$val['id']?>" style="text-decoration: none">
                        <div class="card card-projects">
                            <p><?=$val['name']?></p>
                            <div class="div-project-icon">
                                <p>10</p>&nbsp;
                                <svg width="24" height="20" viewBox="0 0 35 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.5 0.1875C7.82852 0.1875 1.81688e-10 8.01438 1.81688e-10 17.6875V20.9688C-5.23482e-06 21.375 0.113117 21.7732 0.326691 22.1188C0.540264 22.4644 0.845851 22.7437 1.20921 22.9253L2.19242 23.4169C2.32989 27.5246 5.70261 30.8125 9.84375 30.8125H11.4844C12.3905 30.8125 13.125 30.078 13.125 29.1719V17.1406C13.125 16.2345 12.3905 15.5 11.4844 15.5H9.84375C7.70123 15.5 5.76468 16.3804 4.375 17.7987V17.6875C4.375 10.4504 10.2629 4.5625 17.5 4.5625C24.7371 4.5625 30.625 10.4504 30.625 17.6875V17.7987C29.2353 16.3804 27.2988 15.5 25.1562 15.5H23.5156C22.6095 15.5 21.875 16.2345 21.875 17.1406V29.1719C21.875 30.078 22.6095 30.8125 23.5156 30.8125H25.1562C29.2974 30.8125 32.6701 27.5245 32.8076 23.4169L33.7907 22.9253C34.1541 22.7437 34.4597 22.4644 34.6733 22.1188C34.8869 21.7732 35 21.375 35 20.9688V17.6875C35 8.01608 27.1731 0.1875 17.5 0.1875Z" fill="#5B5DF0"/>
                                </svg>
                            </div>
                            <div class="div-project-icon">
                                <p>10</p>&nbsp;
                                <svg width="20" height="20" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.5 3.06611C27.2084 -7.57852 51.4815 11.0484 17.5 35C-16.4815 11.0507 7.79161 -7.57852 17.5 3.06611Z" fill="#5B5DF0"/>
                                </svg>
                            </div>
                            <div class="div-project-icon">
                                <p>10</p>&nbsp;
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="23.34" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1792 1536"><path fill="#5b5df0" d="M1792 640q0 174-120 321.5t-326 233t-450 85.5q-70 0-145-8q-198 175-460 242q-49 14-114 22q-17 2-30.5-9t-17.5-29v-1q-3-4-.5-12t2-10t4.5-9.5l6-9l7-8.5l8-9q7-8 31-34.5t34.5-38t31-39.5t32.5-51t27-59t26-76q-157-89-247.5-220T0 640q0-130 71-248.5T262 187T548 50.5T896 0q244 0 450 85.5t326 233T1792 640z"/></svg>
                            </div>
                            <p>
                                <?php
                                $input = $val['releaseDate'];
                                $date = strtotime($input);
                                echo date('M/d/Y', $date);
                                ?>
                            </p>
                        </div>
                    </a>
            <?php
                    }
                } else {
            ?>
                    <p>You haven't created any project yet.</p>
            <?php
                }
            ?>
        </div>
    </section>
</section>
