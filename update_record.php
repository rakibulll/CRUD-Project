<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location:login.php");
}
error_reporting(0);
# This process updates a record. There is no display.
include_once "layout_header.php";
# 1. connect to database
require 'database/database.php';
$pdo = Database::connect();
include_once "layout_header.php";
# 2. assign user info to a variable
$email = $_POST['email'];
if (!$_POST['role']) {
    $sql = 'SELECT `role` FROM persons ' . " WHERE email = ? " . ' LIMIT 1';
    $query = $pdo->prepare($sql);
    $query->execute(array($_SESSION['email']));
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $role = $result['role'];
    } else {
        if (strpos($_SESSION['email'], "user", 0) === false) {
            $role = "admin";
        } else {
            $role = "user";
        }
    }
} else {
    $role = $_POST['role'];
}
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];
$id = $_GET['id'];
if (
    !preg_match(
        "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",
        $email
    )
) {
    echo '<p>Email Formatting Wrong!</p><br>';
    echo "<a href='display_update_form.php?id=" .
        $_GET['id'] .
        "'>Back to Update form</a>";
    include_once "layout_footer.php";
    exit();
} else {
    $email = htmlspecialchars($email);
    $fname = htmlspecialchars($fname);
    $lname = htmlspecialchars($lname);
    $phone = htmlspecialchars($phone);
    $address = htmlspecialchars($address);
    $address2 = htmlspecialchars($address2);
    $city = htmlspecialchars($city);
    $state = htmlspecialchars($state);
    $zip_code = htmlspecialchars($zip_code);
    $sql = 'SELECT `role` FROM persons ' . " WHERE email = ? " . ' LIMIT 1';
    $query = $pdo->prepare($sql);
    $query->execute(array($_SESSION['email']));
    $result = $query->fetch(PDO::FETCH_ASSOC);
    # 3. assign MySQL query code to a variable
    $sql =
        "UPDATE persons SET email=?, role=?, fname=?, lname=?, phone=?, `address`=?, address2=?, city=?, `state`=?, zip_code=? WHERE id=?";
    $query = $pdo->prepare($sql);
    $query->execute(array(
        $email,
        $role,
        $fname,
        $lname,
        $phone,
        $address,
        $address2,
        $city,
        $state,
        $zip_code,
        $id
    ));
    # 4. update the message in the database
    echo "<p>Updated</p><br>";
    echo "<a href='display_list.php'>Back to list</a>";
    include_once "layout_footer.php";
}

?>
