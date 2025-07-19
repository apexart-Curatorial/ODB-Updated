<?php
error_reporting(E_ALL);
session_start();
require_once "DBX.php";
require_once "loginCheck.php";
require_once "header.php";

$d = new DBX();
$id = [];

if (isset($_GET['id'])) {
    $id = $d->getPersonByID($_GET['id']);
    if (!$id) {
        die("Person not found.");
    }
} else {
    die("No person ID specified.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["stuffISsubmitted"])) {
    $d->createDonation($_POST);
    echo "<font color='green'>Donation Created.</font><br/><br/>";
}
?>

<h4>Add a Donation</h4>
<p>For: <strong><?= htmlspecialchars($id['firstname'] . ' ' . $id['lastname']) ?></strong></p>

<form action="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . urlencode($_GET['id'])) ?>" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">
    <input type="hidden" name="donorID" value="<?= htmlspecialchars($_GET['id']) ?>">
    <input type="hidden" name="position" value="10">

    <label>Date:</label><br>
    <input type="text" name="date" value=""><i>&nbsp;&nbsp;&nbsp;<?= date("Y-m-d") ?></i><br><br>

    <label>Amount:</label><br>
    <input type="text" name="ammount" value=""><i>&nbsp;&nbsp;&nbsp;100</i><br><br>

    <label>Payment Method:</label><br>
    <input type="text" name="paymentMethod" value=""><i>&nbsp;&nbsp;&nbsp;Mastercard</i><br><br>

    <input type="submit" 
           value="Create Donation for <?= htmlspecialchars($id['firstname']) ?>" 
           name="stuffISsubmitted"
           onclick="return confirm('Are you sure you want to add the donation?')">
</form>

<br>
<a href="<?= htmlspecialchars($_SESSION['lastSearch'] ?? 'search.php') ?>">Back to Last Search</a><br><br><br>

<?php
// Load and display recent donations for this person
include "donationView.php";
include "footer.php";
?>

			
			
			