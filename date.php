<!DOCTYPE html>
<html>
<body>

<?php

$fromDate = date('Y-m-d h:i', strtotime('-1 Day',time()));
$fromDate = str_replace(" ", "T", $fromDate);

$toDate = date('Y-m-d h:i',time());
$toDate = str_replace(" ", "T", $toDate);

?>

    <form action="/with_date.php" >
      From Date (date and time):
      <input type="datetime-local" name="fromDate" value="<?php echo $fromDate; ?>">
      To Date (date and time):
      <input type="datetime-local" name="toDate" value="<?php echo $toDate; ?>">
      <input type="submit" value="Display">
    </form>

</body>
</html>