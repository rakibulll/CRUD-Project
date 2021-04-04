<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location:login.php");
}
include_once "layout_header.php";
# connect
require 'database/database.php';
$pdo = Database::connect();

$id = $_GET['id'];
$sql = "SELECT * FROM persons WHERE id= ?";
$query = $pdo->prepare($sql);
$query->execute(array($id));
$result = $query->fetch();
?>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Read Person</h1>
    </div>
</div>
<form method='post' action='display_list.php'>
    Role:       <br><input name='role' type='text' value='<?php echo $result[
        'role'
    ]; ?>' disabled > </br>
    First name: <br><input name='fname' type='text' value='<?php echo $result[
        'fname'
    ]; ?>' disabled > </br>
    Last name:  <br><input name='lname' type='text' value='<?php echo $result[
        'lname'
    ]; ?>' disabled > </br>
    Email:      <br><input name='email' type='text' value='<?php echo $result[
        'email'
    ]; ?>' disabled > </br>
    Phone:      <br><input name='phone' type='text' value='<?php echo $result[
        'phone'
    ]; ?>' disabled > </br>
    Address:    <br><input name='address' type='text' value='<?php echo $result[
        'address'
    ]; ?>' disabled > </br>
    Address 2:  <br><input name='address2' type='text' value='<?php echo $result[
        'address2'
    ]; ?>' disabled > </br>
    City:       <br><input name='city' type='text' value='<?php echo $result[
        'city'
    ]; ?>' disabled > </br>
    State:      <br><input name='state' type='text' value='<?php echo $result[
        'state'
    ]; ?>' disabled > </br>
    Zip Code:   <br><input name='zip_code' type='text' value='<?php echo $result[
        'zip_code'
    ]; ?>' disabled > </br>
    <br><input class="btn btn-primary" type="submit" value="Return to Display List">
</form>
<?php include_once "layout_footer.php";
?>
