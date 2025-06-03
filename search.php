
<?php
error_reporting(E_ALL);
session_start();
include "DBX.php";
include "loginCheck.php";
include "header.php";
$page = isset($_GET["page"]) ? $_GET["page"] : 0;

$d = new DBX();
?>

<form action='results.php' method="POST">
<center>
<h4>People Search</h4>
<?php
if (isset($_REQUEST["norows"])) echo "<font color='red'><b>0 records found. Please try again</b></font><br/>";
?>
<table width='800'>
<tr><td>
    <blockquote>
        <br/><br/><br/><br/>Enter Search Condition: <br/><br/>
        <input type="text" value="" name="expression" style="width:300px;" /> 
        <input type="checkbox" value="1" name="exactMatch">Exact Match<br/><br/>
        Select Search Type: <br/>
        <select size="1" name="type" style="width:300px;" >
            <option value="lastname">last name</option>
            <option value="firstname">first name</option>
            <option value="title">title</option>
            <option value="company">company</option>
            <option value="phone">phone</option>
            <option value="fax">fax</option>
            <option value="alt">alt</option>
            <option value="email">email</option>
            <option value="address">address</option>
            <option value="city">city</option>
            <option value="state">state</option>
            <option value="zip">zip</option>
            <option value="country">country</option>
            <option value="id">id</option>
            <option value="comments">comments</option>
        </select>

        <hr/>

        <br/><br/>Enter Second Search Condition: <br/><br/>
        <input type="text" value="" name="expression2" style="width:300px;" /> 
        <input type="checkbox" value="1" name="exactMatch2">Exact Match<br/><br/>
        Select Search Type: <br/>
        <select size="1" name="type2" style="width:300px;" >
            <option value="lastname">last name</option>
            <option value="firstname" selected="true">first name</option>
            <option value="title">title</option>
            <option value="company">company</option>
            <option value="phone">phone</option>
            <option value="fax">fax</option>
            <option value="alt">alt</option>
            <option value="email">email</option>
            <option value="address">address</option>
            <option value="city">city</option>
            <option value="state">state</option>
            <option value="zip">zip</option>
            <option value="country">country</option>
            <option value="id">id</option>
            <option value="comments">comments</option>
        </select>
        <br/><hr/><br/>

        <?php if (($_SESSION['accessLevel']) >= 3) { ?>
        Select Mailing List Type: <br/>
        <select size="1" name="listtype" style="width:200px;" >
            <option value="foreign">foreign</option>
            <option value="domestic">domestic</option>
            <option value="dontcare">all lists</option>
        </select><br/>
        <input type="checkbox" value="1" name="save2CSV">Save to CSV<br/><br/>
        <?php } ?>

        <input type="submit" value="SEARCH" name="searchStarted" />
        <br/><br/><i>Enter _ (underscore) in the search field if you want to find all UNEMPTY records</i>
    </blockquote>
</form>
</td>

<td>
    <br/><br/><b>Search Mailing Lists only</b><br/><br/><br/>
    <center>
    <span style="width:200px; text-align:left;">
    <form action='results.php' method="GET">
        <?php
        foreach ($d->statCols as $key => $value) {
            echo '<input type="checkbox" value="1" name="'.$value.'" title="Statuses">'.$d->statNames[$key].'<br>';
        }
        ?>
        <br/><br/>
        <input type="submit" value="Search Mailing Lists only" name="checkboxSearch" /><br/><br/>

        <?php if (($_SESSION['accessLevel']) >= 3) { ?>
        Select Mailing List Type: <br/>
        <select size="1" name="listtype" style="width:180px;" >
            <option value="foreign">foreign</option>
            <option value="domestic">domestic</option>
            <option value="dontcare">all lists</option>
        </select><br/><br/>
        <input type="checkbox" value="1" name="save2CSV"/>Save to CSV<br/><br/>
        <?php } ?>
    </form>
    </span>
</td></tr>
</table>
<br/><br/><br/>
<?php include("footer.php"); ?>
