<?php
/**************************************************************************************
 * Main Search Page - search.php
 * Author: Your Name <email@something.com>
 * This file searches the database editeddddddddddddddddd
 **************************************************************************************/
 
//Get variables from config.php to connect to mysql server
require 'config.php';

// connect to the mysql database server.
mysql_connect ($dbhost, $dbusername, $dbuserpass);
//select the database
mysql_select_db($dbname) or die('Cannot select database');

//search variable = data in search box or url
if(isset($_GET['search']))
{
$search = $_GET['search'];
}

//trim whitespace from variable
$search = trim($search);
$search = preg_replace('/\s+/', ' ', $search);

//seperate multiple keywords into array space delimited
$keywords = explode(" ", $search);

//Clean empty arrays so they don't get every row as result
$keywords = array_diff($keywords, array(""));

//Set the MySQL query
if ($search == NULL or $search == '%'){
} else {
for ($i=0; $i<count($keywords); $i++) {
$query = "SELECT * FROM table_name " .
"WHERE column1 LIKE '%".$keywords[$i]."%'".
" OR column2 LIKE '%".$keywords[$i]."%'" .
" OR column3 LIKE '%".$keywords[$i]."%'" .
" OR column4 LIKE '%".$keywords[$i]."%'" .
" ORDER BY column1";
}

//Store the results in a variable or die if query fails
$result = mysql_query($query) or die(mysql_error());
}
if ($search == NULL or $search == '%'){
} else {
//Count the rows retrived
$count = mysql_num_rows($result);
}

echo "<html>";
echo "<head>";
echo "<title>Your Title Here</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\" />";
echo "</head>";
echo "<body onLoad=\"self.focus();document.searchform.search.focus()\">";
echo "<center>";
echo "<br /><form name=\"searchform\" method=\"GET\" action=\"search.php\">";
echo "<input type=\"text\" name=\"search\" size=\"20\" TABINDEX=\"1\" />";
echo " <input type=\"submit\" value=\"Search\" />";
echo "</form>";
//If search variable is null do nothing, else print it.
if ($search == NULL) {
} else {
echo "You searched for <b><FONT COLOR=\"blue\">";
foreach($keywords as $value) {
   print "$value ";
}
echo "</font></b>";
}
echo "<p> </p><br />";
echo "</center>";

//If users doesn't enter anything into search box tell them to.
if ($search == NULL){
echo "<center><b><FONT COLOR=\"red\">Please enter a search parameter to continue.</font></b><br /></center>";
} elseif ($search == '%'){
echo "<center><b><FONT COLOR=\"red\">Please enter a search parameter to continue.</font></b><br /></center>";
//If no results are returned print it
} elseif ($count <= 0){
echo "<center><b><FONT COLOR=\"red\">Your query returned no results from the database.</font></b><br /></center>";
//ELSE print the data in a table
} else {
//Table header
echo "<center><table id=\"search\" bgcolor=\"#AAAAAA\">";
echo "<tr>";
echo "<td><b>COLUMN 1:</b></td>";
echo "<td><b>COLUMN 2:</b></td>";
echo "<td><b>COLUMN 3:</b></td>";
echo "<td><b>COLUMN 4:</b></td>";
echo "<td><b>COLUMN 5:</b></td>";
echo "<td><b>COLUMN 6:</b></td>";
echo "<tr>";
echo "</table></center>";

//Colors for alternation of row color on results table
$color1 = "#d5d5d5";
$color2 = "#e5e5e5";
//While there are rows, print it.
while($row = mysql_fetch_array($result))
{
//Row color alternates for each row
$row_color = ($row_count % 2) ? $color1 : $color2;
//table background color = row_color variable
echo "<center><table bgcolor=".$row_color.">";
echo "<tr>";
echo "<td>".$row['column1']."</td>";
echo "<td>".$row['column2']."</td>";
echo "<td>".$row['column3']."</td>";
echo "<td>".$row['colomn4']."</td>";
echo "<td>".$row['column5']."</td>";
echo "<td >".$row['column6']."</td>";
echo "</tr>";
echo "</table></center>";
$row_count++;
//end while
}
//end if
}

echo "</body>";
echo "</html>";
if ($search == NULL or $search == '%') {
} else {
//clear memory
mysql_free_result($result);
}
?>
