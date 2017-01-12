<?php
/**
 * Created by PhpStorm.
 * User: ep
 * Date: 5.1.2016
 * Time: 11:46
 */

require_once 'static/swiftmailer-5.x/lib/swift_required.php';

if (isset($_GET["id"]) && isset($_GET["ime"]) && isset($_GET["email"])) {
    $id = $_GET["id"];
    $ime = $_GET["ime"];
    $email = $_GET["email"];
    $aktiv_hash = hash_hmac('sha256', $email, 'nePoznasMe');
    $url = "http://localhost/netbeans/trgovina/activate?id=$id&email=$email&hash=$aktiv_hash";
} else {
    header("refresh:5;url=store");
    echo "Ni parametrov za posiljanje aktivacijske povezave na elektronski naslov.";
    exit;
}

$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
    ->setUsername('matic@vsegrad.si')
    ->setPassword('Web73Mail!');

$mailer = Swift_Mailer::newInstance($transport);

$message = Swift_Message::newInstance('Aktivacija racuna v eTrgovini')
    ->setFrom(array('matic@vsegrad.si' => 'eTrgovina JKMN'))
    ->setTo(array($email))
    ->setBody(
    'Pozdravljeni,

    pošiljamo vam povezavo za aktivacijo uporabniškega računa v trgovini eTrgovina 3XK:
    '. $url . '

    Lep dan še naprej!');

$result = $mailer->send($message);

echo "Uspeh posiljanja aktivacijskega emaila: " . $result;
header("refresh:5;url=login");
