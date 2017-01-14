<?php

function getRandomWord($len = 5)
{
    $word = array_merge(range('0', '9'), range('A', 'Z'));
    shuffle($word);
    return substr(implode($word), 0, $len);
}

$registracija = 0;
if (!(!isset($_SESSION["idUporabnik"]) && isset($_GET["id"]) && $_GET["id"] != null && $_GET["id"] == -1)) {
    if (!isset($_SESSION["idUporabnik"])) {
        header("Location:login");
        exit;
    }
} else {
    $registracija = 1;
    $_SESSION["mojaVarnost"] = getRandomWord();
}
if (isset($_SESSION["vloga_id"]) && $_SESSION["vloga_id"] == 3) {
    if (!(isset($_GET["id"]) && $_GET["id"] != null && $_GET["id"] == $_SESSION["idUporabnik"])) {
        header("Location:store");
        exit;
    }
}
?>

<!DOCTYPE html>
<head>
    <?php include 'includes/head.php' ?>
    <title>SellerPanel - eTrgovina</title>
</head>

<?php
$mode = "urediAcc";
$velikost = 6;
if (isset($_GET["id"]) && $_GET["id"] != null && $_GET["id"] != -1) {
    $mode = "edit";
    $velikost = 6;
}
if (isset($_GET["id"]) && $_GET["id"] != null && $_GET["id"] == -1) {
    $mode = "create";
    $velikost = 6;
}
if (isset($_GET["manage"])) {
    $mode = "seznamStrank";
    $velikost = 12;
}

?>

<body>
<?php include 'includes/nav.php' ?>

<div id="page-wrapper">

    <div class="row">
        <div>
            <h1 class="page-header">
                <?php
                if ($mode === "edit") {
                    echo "UREJANJE STRANKE";
                } elseif ($mode === "urediAcc") {
                    echo "SPREMENI PROFIL";
                } elseif ($mode === "create") {
                    echo "REGISTRACIJA STRANKE";
                } elseif ($mode === "seznamStrank") {
                    echo "UPRAVLJANJE S STRANKAMI";
                }
                ?>
            </h1>



                    <?php if ($mode === "seznamStrank") {    // izpisi seznam strank
                        echo "<table cellpadding='10' border='4'>";
                        echo "<tr><th>ID</th><th>Ime</th><th>Priimek</th><th>Elektronski naslov</th><th>Telefon</th><th>Naslov</th><th>Pošta</th><th>Aktiven</th><th>Upravljaj</th></tr>";

                        class TableRows extends RecursiveIteratorIterator
                        {
                            function __construct($it)
                            {
                                parent::__construct($it, self::LEAVES_ONLY);
                            }

                            function current()
                            {
                                return parent::current();
                            }

                            function beginChildren()
                            {
                                echo "<tr>";
                            }

                            function endChildren()
                            {
                                echo "</tr>" . "\n";
                            }
                        }

                        $result = Uporabnik_B::getCustomers();

                        foreach (new TableRows(new RecursiveArrayIterator($result)) as $k => $v) {
                            if (is_numeric($k)) {
                                continue;
                            }

                            if ($k == "idUporabnik")
                                $idUporabnika = $v;

//                            if ($k == "posta") {
//                                if ($v != null) {
//                                    $posta = Uporabnik_B::get(["posta" => $v]);
//                                    echo "<td>$v " . $posta["imePoste"] . "</td>";
//                                } else
//                                    echo "<td>$v</td>";
//                            } else {
//                                echo "<td>$v</td>";
//                            }

                            if ($k == "posta") {
                                if ($v != null) {
                                    $posta = $v;
                                    echo "<td>$posta</td>";
                                } else
                                    echo "<td>$v</td>";
                            } else {
                                echo "<td>$v</td>";
                            }

                            if ($k == "aktiven") {
                                if ($v === '1') {
                                    $class = "btn btn-default btn-sm";
                                    $value = "Deaktiviraj";
                                    $aktiven = 0;
//                                    Uporabnik_B::updateAktivno(["idUporabnik" => $idUporabnika, "aktiven" => 0]);
                                } else {
                                    $class = "btn btn-default btn-sm";
                                    $value = "Aktiviraj";
                                    $aktiven = 1;
//                                    Uporabnik_B::updateAktivno(["idUporabnik" => $idUporabnika, "aktiven" => 1]);
                                }
//                                echo var_dump($aktiven);
//                                echo var_dump($value);
                                echo "<td>
                                        <a class='btn btn-default btn-sm' href='sellerpanel?id=$idUporabnika'>Uredi</a> \t
                                        <a class='$class' href='userpanel?aktiven=$aktiven&id=$idUporabnika&f=c'>$value</a>
                                     </td>";
                            }
                        }
                        echo "</table>";

                    } elseif ($mode === "urediAcc") {           // uredi stvoj profil
                        $id = $_SESSION["idUporabnik"];
                        $result = Uporabnik_B::get(["id" => $id]);

                    } elseif ($mode === "edit") {               // uredi uporabnika z dolocenim id-jem
                        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
                        $result = Uporabnik_B::get(["id" => $id]);
                    }


                    //$poste = PostaDB::getAll();

                    if ($mode !== "seznamStrank") {             // urejamo stranko ?>
                        <form action="userpanel" method="post">
                            <?php if ($mode === "urediAcc" || $mode === "edit" || $mode === "create") { ?>
                            <form class="form-inline">
                                    <div class="form-group">
                                        <label>Ime in priimek:</label><br>
                                        <input
                                            <?php if ($mode != "create" && isset($result["ime"])) echo "value='" . $result["ime"] . "'"; ?>
                                            type="text" pattern="[A-zčžšČŽŠ]*" name="ime" required>


                                        <input
                                                <?php if ($mode != "create" && isset($result["priimek"])) echo "value='" . $result["priimek"] . "'"; ?>
                                                type="text" pattern="[A-zčžšČŽŠ]*" name="priimek" required>


                                    </div>
                            </form>
                                <div class="form-group">
                                    <label>Elektronski naslov:</label><br>
                                    <input style="width: 26.5%;"
                                            <?php if ($mode != "create" && isset($result["email"])) echo "value='" . $result["email"] . "'"; ?>
                                            type="email" name="email" required>
                                </div>


                                <?php if ($mode === "edit" || $mode === "create") { ?>
                                    <div class="form-group">
                                        <label>Naslov:</label><br>
                                        <input style="width: 26.5%;"
                                            <?php if ($mode != "create" && isset($result["naslov"])) echo "value='" . $result["naslov"] . "'"; ?>
                                                type="text" name="naslov" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Telefon:</label><br>
                                        <input style="width: 26.5%;"
                                            <?php if ($mode != "create" && isset($result["telefon"])) echo "value='" . $result["telefon"] . "'"; ?>
                                            type="text" pattern="\d{3} \d{3} \d{3}" name="telefon" required>
                                    </div>



                                    <input type="hidden" name="editing" value="customer"/>
                                    <input type="hidden" name="vloga_id" value="3"/>
                                    <input type="hidden" name="registracija"
                                           value="<?php if ($registracija == 1) echo "1"; else echo "0"; ?>"/>
                                <?php }
                            } // konec urejanja ali dodajanja stranke?>

                            <hr>

                            <div class="form-group">
                                <label>Geslo:</label><br>

                                <input style="width: 26.5%;" type="password" name="password"><br>
                                <label>Potrditev gesla:</label><br>
                                <input style="width: 26.5%;" type="password" name="confirm">
                            </div>
                            <input type="hidden" name="vloga_id" value="3"/>
                            <br><br>

                            <?php if ($registracija == 1) {
                                echo ($_SESSION["mojaVarnost"])
                                ?>
                                <hr>
                                <div class="form-group">
                                    <label>Prepiši zgornjo kodo </label>
                                    <img src="captcha"/>
                                    <input type="text" name="captcha"
                                           required>
                                </div>
                                <br>
                            <?php } ?>

                            <?php
                            if ($mode === "create") {
                                echo '  <input type="hidden" name="id" value=-1>
                                        <div class="form-group">
                                            <input type="submit" value="Potrdi registracijo" name="submit" style="width: 26.5%; margin-left: auto; margin-right: auto;" onclick="return checkpassword()">
                                        </div>
                                     ';
                            } elseif ($mode === "urediAcc" || $mode === "edit") {
                                echo '	<input type="hidden" name="id" value=' . $id . '>
									    <div class="form-group">
                                            <input type="submit" value="Shrani spremembe" name="submit" style="width: 26.5%; margin-left: auto; margin-right: auto;" onclick="return checkpassword()">
                                        </div>
                                     ';
                            } ?>
                        </form>
                    <?php } ?>


                <!-- /.panel-body -->

            <!-- /.panel -->

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->

<script>
    function checkpassword() {
        var pass1 = $('input[name=password]').val();
        var pass2 = $('input[name=confirm]').val();

        if (pass1 != '' && pass1 != pass2) {
            alert("Gesli se ne ujemata.");
            $('input[name=password]').val("");
            $('input[name=confirm]').val("");
            return false;
        }
        return true;
    }
</script>

<?php include 'includes/footer.php' ?>
</body>
