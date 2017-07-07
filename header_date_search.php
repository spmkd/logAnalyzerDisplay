<?php

$fromDate=$_GET["fromDate"];

if(empty($fromDate)){
    $fromDate = date('Y-m-d H:i', strtotime('-1 Day',time()));
    $fromDate = str_replace(" ", "T", $fromDate);
}

$toDate=$_GET["toDate"];

if(empty($toDate)){
    $toDate = date('Y-m-d H:i',time());
    $toDate = str_replace(" ", "T", $toDate);
}

?>

<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> >
  From Date (date and time):
  <input type="datetime-local" name="fromDate" value="<?php echo $fromDate; ?>">
  To Date (date and time):
  <input type="datetime-local" name="toDate" value="<?php echo $toDate; ?>">
  <input type="submit" value="Display">
</form>