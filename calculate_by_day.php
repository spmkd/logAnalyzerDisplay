<?php

$date1 = new DateTime($toDate); 
$date2 = new DateTime($fromDate);

$dateCheck1 = new DateTime(substr($toDate,1,10));
$dateCheck2 = new DateTime(substr($fromDate,1,10));

$searchFromDate = $date2->format('Y-m-d H:i');
$searchToDate = $date1->format('Y-m-d H:i');

$movingDate = $date2;

$resultFromMovingDate = array();

$interval = $dateCheck1->diff($dateCheck2);

$number_of_days = $interval->days;

?>

<table border="1">
	<tr>
		<th>hashNumber</th>
		<th>hashNumberCount</th>
<?php 

for ($x = 0; $x <= $number_of_days; $x++) {
    
    if ($x != 0)
    {
        date_add($movingDate, date_interval_create_from_date_string('1 days'));
    }
    
    $resultFromMovingDate[$x] = $movingDate->format('Y-m-d');
    $singleDayLink=$_SERVER['PHP_SELF'] . "?fromDate=" . $resultFromMovingDate[$x] . "T00:00&toDate=" . $resultFromMovingDate[$x] . "T23:59";
    
    echo "		<th nowrap> <a href=$singleDayLink> $resultFromMovingDate[$x] </a></th>";
} 

?>
	</tr>
	
<?php 

# A1 # Get a list of all hashNumbers sorted by number of occurances 

$sql = "SELECT hashNumber, count(*) as hashNumberCount
FROM testdb.shortenerrorlog
WHERE shortenerrorlog.time >= '$searchFromDate' and shortenerrorlog.time <= '$searchToDate'
GROUP BY shortenerrorlog.hashNumber
ORDER BY hashNumberCount DESC;";

$result = $conn->query($sql);

$hashListOrdered = array();
$hashListOrderedCount = array();
$numberOfUniqueHashErrors = 0;

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        
        $hashListOrdered[$numberOfUniqueHashErrors] = $row["hashNumber"];
        $hashListOrderedCount[$numberOfUniqueHashErrors] = $row["hashNumberCount"];
        
        $numberOfUniqueHashErrors++;
        
    }
    
} else {
    echo "<br> A1 - 0 results <br>";
}

# A1 END #

# A2 # Get a List Of All hashERROR Counts Per Day sorted by Date

$sql2 = "SELECT hashNumber, date_format(time,'%Y-%m-%d') theDate, count(1) Occurance
FROM shortenerrorlog
WHERE shortenerrorlog.time >= '$searchFromDate' and shortenerrorlog.time <= '$searchToDate'
GROUP BY hashNumber, theDate
ORDER BY theDate;";

$result2 = $conn->query($sql2); 

$dateOrderedResult = array();

if ($result2->num_rows > 0) {
    // output data of each row
    while ($row = $result2->fetch_assoc()) {
        
        $dateOrderedResult[$row["hashNumber"]][$row["theDate"]] = $row["Occurance"];
        
    }
    
} else {
    echo "<br> A2 - 0 results <br>";
}

# A2 END #

# A3 # List all the ERROR's in a table

for ($x = 0; $x < $numberOfUniqueHashErrors; $x++)
{
    
    $temp_uniqueHash = $hashListOrdered[$x];
    $temp_uniqueHashCount = $hashListOrderedCount[$x];
    
    $temp_uniqueHashLink = $_SERVER['PHP_SELF'] . "?fromDate=" . $fromDate . "&toDate=" . $toDate . "&showError=" . $temp_uniqueHash;
    
    echo "<tr>";
    echo "<td> <a href=$temp_uniqueHashLink> " . $temp_uniqueHash . " </a></td>";
    echo "<td align=\"center\"> " . $temp_uniqueHashCount . "</td>";
    
    for ($y = 0; $y <= $number_of_days; $y++)
    {
        
        $temp_date = $resultFromMovingDate[$y];
        
        if (empty($dateOrderedResult[$temp_uniqueHash][$temp_date]))
        {
            echo "<td bgcolor=\"#D8D8D8\"> 0 </td>";
        }else{
            echo "<td> " . $dateOrderedResult[$temp_uniqueHash][$temp_date] . " </td>";
        }
        
    }
    
    echo "</tr>";
    
}

?>

</table>