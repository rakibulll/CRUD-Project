<?php include_once "layout_header.php"; ?>

<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Register new person</h1>
    </div>
</div>
<?php
error_reporting(0);
if ($_GET['err'] == 'empty') {
    echo "<p style='color:red'>All fields are REQUIRED. Please Try Again!</p></br>";
} elseif ($_GET['err'] == 'invalidEmail') {
    echo "<p style='color:red'>Invalid email. Please Try Again!</p></br>";
} elseif ($_GET['err'] == 'passRequ') {
    echo "<p style='color:red'>Try Again! Password must be 16+ characters with at least one of each: upper, lower, number and special character.</p></br>";
} elseif ($_GET['err'] == 'passVal') {
    echo "<p style='color:red'>Try Again! Wrong Password Confirmation.</p></br>";
} elseif ($_GET['err'] == 'existEmail') {
    echo "<p style='color:red'>Email already exist. Please Try Again!</p></br>";
}
?>

<form method='post' action='register_new_person.php' >
    Role: <br><select name="role">
                <option value="user" <?php if ($_GET['role'] == 'user') {
                    echo 'selected';
                } ?>>User</option>
                <option value="admin"<?php if ($_GET['role'] == 'admin') {
                    echo 'selected';
                } ?>>Admin</option>
          </select> </br>
    First name: <br><input name='fname' type='text'placeholder=<?php echo $_GET[
        'fname'
    ]; ?>> </br>
    Last name: <br><input name='lname' type='text' placeholder=<?php echo $_GET[
        'lname'
    ]; ?>> </br>
    Email: <br><input name='email' type='text' placeholder=<?php echo $_GET[
        'email'
    ]; ?>> </br>
    Password: <br><input name='password' type='password'> </br>
    Confirm Password: <br><input name='valPassword' type='password'> </br>
    Phone: <br><input name='phone' type='tel'placeholder=<?php echo $_GET[
        'phone'
    ]; ?>> </br>
    Address: <br><input name='address' type='text' placeholder=<?php echo $_GET[
        'address'
    ]; ?>> </br>
    Address 2: <br><input name='address2' type='text' placeholder=<?php echo $_GET[
        'address2'
    ]; ?>> </br>
    City: <br><input name='city' type='text' placeholder=<?php echo $_GET[
        'city'
    ]; ?>> </br>
    State: <br><input name='state' type='text' placeholder=<?php echo $_GET[
        'state'
    ]; ?>> </br>
    Zip Code: <br><input name='zip_code' type='text' placeholder=<?php echo $_GET[
        'zip_code'
    ]; ?>> </br></br> 
        <input class="btn btn-success btn-block" type="submit" value="Submit">
</form><p></p>
<button class="btn btn-info btn-block" onClick="window.location.href='login.php';" value="Return to Login">Return to Login</button>
<?php include_once "layout_footer.php"; ?>
