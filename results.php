<?php
error_reporting(E_ALL);
session_start();
require_once 'DBX.php';
require_once 'loginCheck.php';

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

if (count($result) < 1) {
    echo "<b>No matching records found</b>";
    exit();
}

echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>";
foreach (array_keys($result[0]) as $colName) {
    echo "<th><a href='?sort=$colName'>" . htmlspecialchars($colName) . "</a></th>";
}
echo "</tr>";

foreach ($result as $row) {
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td>" . htmlspecialchars($value) . "</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>
