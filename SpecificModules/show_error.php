<br>

<table border="1">
  <tr>
    <th>ErrorHashNumber</th>
    <th>FullStackTrace</th>
    <th>Logged for First Time</th>
    <th>Logged for Last Time</th>
    <th>TheErrorMessage</th>
    <th>MsgHashNumber</th>
  </tr>

<?php

# A1 - show_error.php - Getting Detailed info

$tmpHashNumber = $_GET["showError"];

$showErrorSql = "SELECT * FROM errorstackdictionary 
				WHERE ErrorHashNumber='$tmpHashNumber' OR MsgHashNumber='$tmpHashNumber';";

$showErrorResult = $conn->query($showErrorSql);

if ($showErrorResult->num_rows > 0) {

	while ($row = $showErrorResult->fetch_assoc()) {
		
	echo "<tr>";
	echo "	<td> " . $row["ErrorHashNumber"] . " </td>";
	echo "	<td> " . $row["FullStackTrace"] . " </td>";
	echo "	<td> " . $row["LoggedForFirstTime"] . " </td>";
	echo "	<td> " . $row["LoggedLastTime"] . " </td>";
	echo "	<td> " . $row["TheErrorMessage"] . " </td>";
	echo "	<td> " . $row["MsgHashNumber"] . " </td>";
	echo "</tr>";
		
	}
		
} else {
	echo "<br> A1 - show_error.php - 0 results <br>";
}		

?>

</table>
<br>