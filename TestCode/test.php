<?php
$servername = "localhost";
$username = "testuser";
$password = "test623";
$dbname = "testdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT hashNumber, count(*) as hashNumberCount, TheErrorMessage
FROM testdb.shortenerrorlog,  testdb.errorstackdictionary
WHERE shortenerrorlog.hashNumber =  errorstackdictionary.ErrorHashNumber
GROUP BY shortenerrorlog.hashNumber , TheErrorMessage
ORDER BY hashNumberCount DESC";

$result = $conn->query($sql);

?>

<table style="width: 100%" border="1">
	<tr>
		<th>hashNumber</th>
		<th>hashNumberCount</th>
		<th>TheErrorMessage</th>
	</tr>
	<tr>
		<td>Jill</td>
		<td>Smith</td>
		<td>50</td>


<?php
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["hashNumber"] . "</td><td>" . $row["hashNumberCount"] . "</td><td>" . $row["TheErrorMessage"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}

?>

</table>

<?php
$conn->close();
?>