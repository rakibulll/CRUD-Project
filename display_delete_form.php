<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location:login.php");
}
require 'database/database.php';
$pdo = Database::connect();
include_once "layout_header.php";
$id = $_GET['id'];
$sql = "SELECT * FROM persons WHERE id= ?";
$query = $pdo->prepare($sql);
$query->execute(array($id));
$result = $query->fetch();
?>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Delete <?php echo $result['fname'] .
            " " .
            $result['lname']; ?></h1>
    </div>
</div>

<p>Are you sure you want to delete this person?</p>
<form method='post' action='delete_record.php?id=<?php echo $id; ?>'>
    <button class="btn btn-success" type="submit" value="Yes">Yes</button>
</form>
<p></p>
<form method='post' action='display_list.php'>
    <button class="btn btn-danger"type="submit" value="No">No</button>
</form>

<?php include_once "layout_footer.php";
?>
