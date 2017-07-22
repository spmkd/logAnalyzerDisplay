<?php

$sql = "SELECT hashNumber, count(*) as hashNumberCount
FROM testdb.shortenerrorlog
WHERE shortenerrorlog.time >= '$fromDate' and shortenerrorlog.time <= '$toDate' 
GROUP BY shortenerrorlog.hashNumber
ORDER BY hashNumberCount DESC;";

$result = $conn->query($sql);

?>

<table style="width:90%" border="1">
	<tr>
		<th>hashNumber</th>
		<th>hashNumberCount</th>
		<th>TheErrorMessage</th>
	</tr>
<?php
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
            echo "<td>" . $row["hashNumber"] . "</td>";
            echo "<td>" . $row["hashNumberCount"] . "</td>";
            echo "<td>" . $row["TheErrorMessage"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}

?>

</table>