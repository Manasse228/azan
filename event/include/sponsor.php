

<div id="sponsor-carousel" class="carousel slide" data-interval="false">
    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <h2>Sponsor Officiel</h2>

                <div class="carousel-inner">
                    <div class="item active">
                        <ul>

                            <?php
                            for ($i = 0;$i < sizeof($photos); $i++) {
                                if ($photos[$i]->getTypePhoto() == 3) {

                                    ?>

                                    <li><a><img class="img-responsive" height="100" width="100"
                                                src="../images/<?php echo $photos[$i]->getLien(); ?> " alt="sponsor_photo"></a>
                                    </li>

                                    <?php
                                }
                            }
                            ?>
                            ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="light">
        <img class="img-responsive" src="images/light.png" alt="">
    </div>
</div>