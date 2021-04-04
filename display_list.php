<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location:login.php");
}
include_once "layout_header.php";
?>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Person List</h1>
    </div>
</div>
<?php
require 'database/database.php';
$pdo = Database::connect();

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

echo 'Logged In As: <br><b>' . $_SESSION['email'] . '</b> </br></br>';

if ($role == 'admin') {
    echo "<div id='container'>
            <a class='btn btn-primary'  href='display_create_form.php'>Create</a>
        </div><p></p>";
}

$sql = 'SELECT * FROM persons';
foreach ($pdo->query($sql) as $row) {
    $str = "";
    $str .= "<a href='display_read_form.php?id=" . $row['id'] . "'>Read</a> ";

    if ($role == 'admin' || $_SESSION['email'] == $row['email']) {
        $str .=
            "<a href='display_update_form.php?id=" .
            $row['id'] .
            "'>Update</a> ";
    }
    if ($role == 'admin') {
        $str .=
            "<a href='display_delete_form.php?id=" .
            $row['id'] .
            "'>Delete</a> ";
    }

    $str .=
        ' (' .
        $row['id'] .
        ') ' .
        $row['fname'] .
        " " .
        $row['lname'];
    $str .= '<br>';
    echo $str;
}

echo '<br/>';

echo "<div id='container'>
    <a class='btn btn-danger' href='logout.php'>Logout</a>
</div>

<br><br>";
include_once "layout_footer.php";

