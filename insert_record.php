<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location:login.php");
}
# This process inserts a record. There is no display.
# 1. connect to database
require 'database/database.php';
$pdo = Database::connect();

$email = $_POST['email'];
$password = $_POST['password'];
$valPassword = $_POST['valPassword'];
$role = $_POST['role'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];

$header =
    "&email=" .
    $email .
    "&role=" .
    $role .
    "&fname=" .
    $fname .
    "&lname=" .
    $lname .
    "&phone=" .
    $phone .
    "&address=" .
    $address .
    "&address2=" .
    $address2 .
    "&city=" .
    $city .
    "&state=" .
    $state .
    "&zip_code=" .
    $zip_code;

$sql = "SELECT id FROM persons WHERE email = ?";
$query = $pdo->prepare($sql);
$query->execute(array($email));
$result = $query->fetch(PDO::FETCH_ASSOC);

if (
    empty($email) ||
    empty($password) ||
    empty($valPassword) ||
    empty($role) ||
    empty($fname) ||
    empty($lname) ||
    empty($phone) ||
    empty($address) ||
    empty($address2) ||
    empty($city) ||
    empty($state) ||
    empty($zip_code)
) {
    header("Location:display_create_form.php?err=empty" . $header);
} elseif (
    !preg_match(
        "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",
        $email
    )
) {
    header("Location:display_create_form.php?err=invalidEmail" . $header);
} else {
    $sql = "SELECT id FROM persons WHERE email = ?";
    $query = $pdo->prepare($sql);
    $query->execute(array($email));
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        header(
            "Location:display_create_form.php?err=existEmail" .
                "&email=" .
                $email .
                $header
        );
    } else {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        $validatePass = strcmp($password, $valPassword);
        if (
            !$uppercase ||
            !$lowercase ||
            !$number ||
            !$specialChars ||
            strlen($password) < 16
        ) {
            header("Location:display_create_form.php?err=passRequ" . $header);
        } elseif ($validatePass != 0) {
            header("Location:display_create_form.php?err=passVal" . $header);
        } else {
            //sanatize data
            $email = htmlspecialchars($email);
            $password = htmlspecialchars($password);
            $fname = htmlspecialchars($fname);
            $lname = htmlspecialchars($lname);
            $phone = htmlspecialchars($phone);
            $address = htmlspecialchars($address);
            $address2 = htmlspecialchars($address2);
            $city = htmlspecialchars($city);
            $state = htmlspecialchars($state);
            $zip_code = htmlspecialchars($zip_code);
            $password_salt = MD5(microtime());
            $password_hash = MD5($password . $password_salt);
            # 3. assign MySQL query code to a variable
            $sql =
                "INSERT INTO persons (`role`, email, password_hash, password_salt, fname, lname, phone, `address`, address2, city, `state`, zip_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute(array(
                $role,
                $email,
                $password_hash,
                $password_salt,
                $fname,
                $lname,
                $phone,
                $address,
                $address2,
                $city,
                $state,
                $zip_code
            ));
            # 4. insert the message into the database
            include_once "layout_header.php";
            echo "<p>New Person Added.</p><br>";
            echo "<a href='display_list.php'>Back to display list</a>";
        }
    }
}
include_once "layout_footer.php";
