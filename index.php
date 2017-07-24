<?php

include 'BaseModules/data_base_connect.php';

include 'BaseModules/header_date_search.php';

if(!empty($_GET["showError"])){
	include 'SpecificModules/show_error.php';
}

include 'calculate_by_day.php';

include 'BaseModules/data_base_close.php';

?>