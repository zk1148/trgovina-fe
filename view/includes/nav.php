<?php require_once("model/Uporabnik_B.php") ?>
<nav class="navbar navbar-inverse" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <br>
        <a class="navbar-brand" href="store"> <font size="8">3xK</font> </a>
    </div>
    <!-- /.navbar-header -->

    <?php
    $manageUrl = "login";
    if (isset($_SESSION["idUporabnik"])) {
        $id = $_SESSION["idUporabnik"];
        if (isset($_SESSION["vloga_id"]) && $_SESSION["vloga_id"] == 1) {
            $manageUrl = "adminpanel";
        } else if (isset($_SESSION["vloga_id"]) && $_SESSION["vloga_id"] == 2) {
            $manageUrl = "sellerpanel";
        } else if (isset($_SESSION["vloga_id"]) && $_SESSION["vloga_id"] == 3) {
            $manageUrl = "sellerpanel?id=$id";
        }
    }

    $vloga = 0;
    if (isset($_SESSION["vloga_id"])) {
        $vloga = $_SESSION["vloga_id"];
    }

    $logoutUrl = "logout";
    if ($vloga != 0) {
        $logoutUrl = "logout";
    }
    ?>

    <section id="login">
        <!--<p>jeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee</p>-->
        <ul class="nav navbar-top-links navbar-right">
            <?php if(isset($_SESSION["idUporabnik"])): ?>
                <li><span style="color: white;">Prijavljen je uporabnik <?= Uporabnik_B::get(["id" => $_SESSION["idUporabnik"]])["ime"] ?></span></li>
            <?php else: ?>
                <li><a href="<?= BASE_URL."login" ?>"><span style="color: white;">PRIJAVA</span></a></li>
            <?php endif ?>+
            <li><a href="<?php echo $manageUrl; ?>"><span style="color: white;">MOJ PROFIL</span></a></li>
            <li><a href="<?php echo $logoutUrl; ?>"><span style="color: white;">ODJAVA</span></a></li>
        </ul>
    </section>
    <!-- /.navbar-top-links -->

    <br>
    <ul class="nav navbar-nav">

        <li>
            <a href="store"><span><i class="fa fa-fw"></i> <font color="white">TRGOVINA</font></span></a>
        </li>
        <li>
            <a href="<?= BASE_URL . "cart" ?>"><span><i
                            class="fa fa-fw"></i> <font color="white">KOŠARICA</font></span></a>
        </li>
        <li>
            <a href="<?= BASE_URL . "narocila" ?>"><span><i class="fa fa-fw"></i> <font color="white">NAROČILA</font></span></a>
        </li>
        <?php if ($vloga == 1) { ?>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><font color="white">UPRAVLJAJ S PRODAJALCI</font><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="prodajalci">Pregled prodajalcev</a></li>
                    <li><a href="adminpanel?id=-1">Dodaj prodajalca</a></li>
                </ul>
            </li>
        <?php } ?>
        <?php if ($vloga == 1 || $vloga == 2) { ?>

            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><font color="white">UPRAVLJAJ S STRANKAMI</font><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="sellerpanel?manage">Pregled strank</a></li>
                    <li><a href="sellerpanel?id=-1">Dodaj stranko</a></li>
                </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><font color="white">UPRAVLJAJ S PRODUKTI</font><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?= BASE_URL . "productpanel" ?>">Pregled produktov</a></li>
                    <li><a href="<?= BASE_URL . "addproduct" ?>">Dodaj produkt</a></li>
                </ul>
            </li>
        <?php } ?>
    </ul>


    <!-- /.navbar-static-side -->
</nav>
