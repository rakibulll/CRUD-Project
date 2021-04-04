<?php
error_reporting(0);
session_start();
if (!isset($_SESSION['email'])) {
    header("Location:login.php");
}
require 'database/database.php';
$pdo = Database::connect();
include_once "layout_header.php";


$sql = 'SELECT * FROM persons ' . " WHERE email = ? " . ' LIMIT 1';

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

$id = $_GET['id'];
$sql = "SELECT * FROM persons WHERE id= ?";
$query = $pdo->prepare($sql);
$query->execute(array($id));
$result = $query->fetch();

if ($_SESSION['email'] != 'admin@admin.com' || $role != 'admin') {
    if ($_SESSION['email'] != $result['email']) {
        echo "<p>Account can not be updated</p>";
        echo "<a href='display_list.php'>Back to list</a>";
        exit();
    }
}
?>

<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Update Person</h1>
    </div>
</div>

<form method='post' action='update_record.php?id=<?php echo $id; ?>'>
    Role:       <br><?php
    $userSelected = "";
    $adminSelected = "";

    if ($role == 'admin' && $result['email'] != $_SESSION['email']) {
        if ($result['role'] == 'user') {
            $userSelected = "selected";
        } elseif ($result['role'] == 'admin') {
            $adminSelected = "selected";
        }

        echo "<select name='role'> \n
                        <option value='user' " .
            $userSelected .
            " >User</option> \n
                        <option value='admin' " .
            $adminSelected .
            ">Admin</option> \n
                        </select> </br>";
    } else {
        echo "<input name='role' type='text' value='" .
            $result['role'] .
            "'; disabled > </br>";
    }
    ?>

    First name: <br><input name='fname' type='text' value='<?php echo $result[
        'fname'
    ]; ?>'  > </br>
    Last name:  <br><input name='lname' type='text' value='<?php echo $result[
        'lname'
    ]; ?>'  > </br>
    Email:      <br><input name='email' type='text' value='<?php echo $result[
        'email'
    ]; ?>'> </br>
    Phone:      <br><input name='phone' type='text' value='<?php echo $result[
        'phone'
    ]; ?>'  > </br>
    Address:    <br><input name='address' type='text' value='<?php echo $result[
        'address'
    ]; ?>'  > </br>
    Address 2:  <br><input name='address2' type='text' value='<?php echo $result[
        'address2'
    ]; ?>'  > </br>
    City:       <br><input name='city' type='text' value='<?php echo $result[
        'city'
    ]; ?>'  > </br>
    State:      <br><input name='state' type='text' value='<?php echo $result[
        'state'
    ]; ?>'  > </br>
    Zip Code:   <br><input name='zip_code' type='text' value='<?php echo $result[
        'zip_code'
    ]; ?>'  > </br>
    <br><input class="btn btn-info" type="submit" value="Submit">
</form>
<?php include_once "layout_footer.php";
?>
