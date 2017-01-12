<?php require_once("model/Uporabnik_B.php") ?>
<nav class="navbar navbar-inverse" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <br>
        <a class="navbar-brand" href="#"> <font size="8">3xK</font> </a>
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
            <?php endif ?>
            <li><a href="<?php echo $manageUrl; ?>"><span style="color: white;">MOJ PROFIL</span></a></li>
            <li><a href="<?php echo $logoutUrl; ?>"><span style="color: white;">ODJAVA</span></a></li>
        </ul>
    </section>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="<?php echo $manageUrl; ?>"><span><i
                                class="fa fa-user fa-fw"></i> Upravljaj račun</span></a>
                </li>
                <li>
                    <a href="store"><span><i class="fa fa-laptop fa-fw"></i> Trgovina</span></a>
                </li>
                <li>
                    <a href="<?= BASE_URL . "cart" ?>"><span><i
                                class="fa fa-shopping-cart fa-fw"></i> Voziček</span></a>
                </li>
                <li>
                    <a href="<?= BASE_URL . "narocila" ?>"><span><i class="fa fa-book fa-fw"></i> Naročila</span></a>
                </li>
                <?php if ($vloga == 1) { ?>
                    <li>
                        <a href="#">
                            <i class="fa fa-share-alt fa-fw"></i> Upravljaj s prodajalci<span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="prodajalci">Pregled</a></li>
                            <li><a href="adminpanel?id=-1">Dodaj prodajalca</a></li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                <?php } ?>
                <?php if ($vloga == 1 || $vloga == 2) { ?>
                    <li>
                        <a href="#">
                            <i class="fa fa-users fa-fw"></i> Upravljaj s strankami<span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="sellerpanel?manage">Pregled</a></li>
                            <li><a href="sellerpanel?id=-1">Dodaj stranko</a></li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-cubes fa-fw"></i> Upravljaj s produkti<span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= BASE_URL . "productpanel" ?>">Pregled</a></li>
                            <li><a href="<?= BASE_URL . "addproduct" ?>">Dodaj produkt</a></li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                <?php } ?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
