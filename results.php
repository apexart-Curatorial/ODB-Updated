<?php
error_reporting(E_ALL);
session_start();
require_once 'DBX.php';
require_once 'loginCheck.php';
require_once 'header.php';

// Accept search parameters via POST or GET if present
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION["type"] = $_POST["type"] ?? '';
    $_SESSION["expression"] = $_POST["expression"] ?? '';
    $_SESSION["exactMatch"] = isset($_POST["exactMatch"]);
    $_SESSION["type2"] = $_POST["type2"] ?? '';
    $_SESSION["expression2"] = $_POST["expression2"] ?? '';
    $_SESSION["exactMatch2"] = isset($_POST["exactMatch2"]);
    header("Location: results.php");
    exit();
}

$_SESSION["lastSearch"] = $_SERVER['REQUEST_URI'];

$page = isset($_GET["page"]) ? (int) $_GET["page"] : 0;
if (!isset($_SESSION["lastOrder"])) $_SESSION["lastOrder"] = "firstname";
if (!isset($_SESSION["sortDirection"])) $_SESSION["sortDirection"] = 0;

$sortORDER = $_GET["sort"] ?? "id";
$sortDIR = "";

if ($_SESSION["lastOrder"] === $sortORDER) {
    if (isset($_SERVER['HTTP_REFERER']) && str_contains($_SERVER['HTTP_REFERER'], basename(__FILE__))) {
        $_SESSION["sortDirection"] = 1 - $_SESSION["sortDirection"];
    }
}

$_SESSION["lastOrder"] = $sortORDER;
$sortDIR = $_SESSION["sortDirection"] ? " DESC" : " ASC";

$sortORDER = "$sortORDER$sortDIR";
$type = $_SESSION["type"] ?? '';
$expression = $_SESSION["expression"] ?? '';
$exactMatch = $_SESSION["exactMatch"] ?? false;
$type2 = $_SESSION["type2"] ?? '';
$expression2 = $_SESSION["expression2"] ?? '';
$exactMatch2 = $_SESSION["exactMatch2"] ?? false;

$db = new DBX();
$result = $db->SearchSort($expression, $type, $page, false, "dontcare", $sortORDER, $exactMatch, $expression2, $type2, $exactMatch2);

if (!$result || count($result) < 1) {
    echo "<b>No matching records found</b>";
    include 'footer.php';
    exit();
}

$excludedFields = [
    'hear','creditLine','invitation','domestic','foreign','press','nn','feedback','juror','juror_past','member','foundation',
    'consulate','donor','inKindDonor','potDonor','edu','funder','alt','title','hasDonated','institution','academic','emailList',
    'returnedMail','feedbackBook','curator','artist','resident','residentRecommender','publication','programList','otherList',
    'individual','corporate','USgoverment','foreignAgency','res_contact','conference','personDeleted','SpanUpdate'
];

$qstr = $_SERVER['QUERY_STRING'];
$recordCount = count($result);

echo "<div style='margin-bottom:10px;'><b>$recordCount Records Found</b>";
echo "&nbsp;&nbsp;&nbsp;<a href='writeCSV.php' style='font-size:0.9em;'>Download CSV</a></div>";

// Sorting header
echo "<table><tr><td><b>Sort By</b>(Double click to reverse sort direction)&nbsp;&nbsp;&nbsp;</td>";
$sortableFields = ['id','lastname','firstname','company','city','state','email','country','phone'];
foreach ($sortableFields as $field) {
    echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?$qstr&sort=$field'>$field</a></td>";
}
echo "</tr></table><br/>";

// Result table
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>";
foreach (array_keys($result[0]) as $colName) {
    if (in_array($colName, $excludedFields)) continue;
    echo "<th>" . htmlspecialchars($colName) . "</th>";
}
echo "<th>Actions</th></tr>";

foreach ($result as $row) {
    echo "<tr>";
    foreach ($row as $colName => $value) {
        if (in_array($colName, $excludedFields)) continue;
        echo "<td>" . htmlspecialchars($value ?? '') . "</td>";
    }
    $id = htmlspecialchars($row['id'] ?? '');
    echo "<td>
            <a href='edit.php?id=$id'>edit</a> |
            <a href='addDonation.php?id=$id'>donations</a> |
            <a href='deletePerson.php?id=$id' onclick=\"return confirm('Are you sure you want to delete this person?');\">delete</a>
          </td>";
    echo "</tr>";
}
echo "</table>";

include 'footer.php';
?>
