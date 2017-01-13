<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'includes/head.php' ?>

    <link href="static/css/shop-homepage.css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<?php include 'includes/nav.php' ?>

<!-- Page Content -->
<div id="page-wrapper">

    <div class="row" style="padding-top: 25px;">
        <h1>TRGOVINA</h1>


        <div class="col-md-2 pull-right">
            <form action="" class="form" method="post">
                <label for="iskanje">
                    Išči v trgovini
                </label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder=" " name="iskanje" id="iskanje">
                      <span >
                        <button style="width: 100%; margin-left: auto; margin-right: auto;" type="submit">Išči</button>

                      </span>
                </div><!-- /input-group -->
            </form>
        </div>

        <div class="row">
            <div class="col-lg-9">
            <?php foreach ($izdelki as $izdelek): ?>

                    <div class="thumbnail">

                        <div class="caption" style="color:black;">

                            <a href="?id=<?= $izdelek["idIzdelek"] ?>"><font size="6" color="black"><strong><?= $izdelek["ime"] ?></strong></font></a>

                            <h4>Cena: <?= $izdelek["cena"] ?> €</h4>
                            <p><?= $izdelek["opis"] ?></p>
                        </div>
                        <?php if (!empty($izdelek["slike"])): ?>
                            <img src="<?= IMAGES_URL . $izdelek["slike"][0]["slika"] ?>" alt="slike"
                                 style="width: 320px;height: 150px;">
                        <?php else: ?>
                            <div style="width: 320px;height: 150px">
                                <i
                                        style="top: 54px; position: relative; left:103px"></i>
                            </div>
                        <?php endif; ?>
                        <div class="ratings">

                            <p>
                            <h4><font size="3" color="black">Povprečna ocena: <?= $izdelek["avg_ocena"] ?></font></h4>
                            </p>
                        </div>
                    </div>


            <?php endforeach; ?>

        </div>
        </div>

    </div>


</div>
<!-- /.container -->

<?php include 'includes/footer.php' ?>
</body>

</html>
