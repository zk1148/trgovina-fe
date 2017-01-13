<!DOCTYPE html>
<head>
    <?php include 'includes/head.php' ?>
    <title>Upravljaj z izdelki - eTrgovina</title>
</head>

<body>
<?php include 'includes/nav.php' ?>
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-9">
            <h1 class="page-header">VSI IZDELKI</h1>
            <?php foreach ($izdelki as $izdelek): ?>
                <div>

                    <div class="panel <?= $izdelek["aktiven"] == 1?"panel-default":"panel-danger" ?>">
                        <div class="panel-heading">
                            <strong><?= $izdelek["ime"] ?><br></strong>
                            <?= "Cena: ".$izdelek["cena"] ?> €
                            <a href="<?= BASE_URL . "editproduct?id=" . $izdelek["idIzdelek"] ?>"
                               class="pull-right btn">Uredi izdelek</a>
                        </div>
                        <div class="panel-body">
                            <?= $izdelek["opis"] ?>
                            <hr>

                            <form action="<?= BASE_URL . "slike" ?>" class="form" method="post"
                                  enctype="multipart/form-data">
                                <div class="input-group">
                                      <span class="input-group-btn">
                                        <span class="btn">
                                            <input type="file" name="slika" id="slika">
                                        </span>
                                      </span>
                                    <span>
                                        <button class="btn btn-info" type="submit">
                                            Dodaj sliko
                                        </button>
                                    </span>
                                    <input type="hidden" name="do" value="add">
                                    <input type="hidden" name="id" value="<?= $izdelek["idIzdelek"] ?>">
                                </div><!-- /input-group -->

                            </form>
                            <hr>
                            <div>
                                <?php foreach ($izdelek["slike"] as $slika): ?>
                                    <div class="itemsContainer">
                                        <form action="<?= BASE_URL . "slike" ?>" class="form" method="post">
                                            <input type="hidden" name="do" value="delete">
                                            <input type="hidden" name="id" value="<?= $slika["idSlika"] ?>">
                                            <img src="<?= IMAGES_URL . $slika["slika"] ?>" alt="slika"
                                                 class="img-thumbnail" style="width: 100px;height: 50px;">
                                            <div class="play">
                                                <button class="btn btn-sm btn-default" type="submit">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>


                        </div>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->

<?php include 'includes/footer.php' ?>
<script type="text/javascript">
    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });
    $(document).ready(function () {
        $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
            console.log(numFiles);
            console.log(label);
            $(this).closest('form').find('input[type="text"]').val(label);
        });
    });
</script>
</body>