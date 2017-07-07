<?php

$date1 = new DateTime($toDate); 
$date2 = new DateTime($fromDate);

$searchFromDate = $date2->format('Y-m-d');
$searchToDate = $date1->format('Y-m-d');

$movingDate = $date2;

$resultFromMovingDate = array();

$interval = $date1->diff($date2);

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
    echo "		<th nowrap> $resultFromMovingDate[$x] </th>";
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
    echo "<br> 0 results <br>";
}

# A1 END #

# A2 # Get a List Of All hashERROR Counts Per Day sorted by Date

$sql2 = "SELECT hashNumber, date_format(time,'%Y-%m-%d') theDate, count(1) Occurance
FROM shortenerrorlog
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
    echo "0 results <br>";
}

# A2 END #

# A3 # List all the ERROR's in a table

for ($x = 0; $x < $numberOfUniqueHashErrors; $x++)
{
    
    $temp_uniqueHash = $hashListOrdered[$x];
    $temp_uniqueHashCount = $hashListOrderedCount[$x];
    
    echo "<tr>";
    echo "<td> " . $temp_uniqueHash . "</td>";
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