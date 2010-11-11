<html>
<head></head>
<body>
<?php

	error_reporting(E_ALL);

	set_time_limit(3600000);

	$chars = array('A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','T','U','V','W','X','Y');
	$nums =  array(3,4,6,7,8,9);

	$codes = array();

	for($n = 1; $n<=40000;$n++){
		$code = "";
		for($i=1;$i<=4;$i++){
				$code .= $chars[rand(0,count($chars)-1)];
		}
		for($i=1;$i<=4;$i++){
			$code .= $nums[rand(0,count($nums)-1)];
		}
		while(array_search($code,$codes) != false){
			$code ="";
			for($i=1;$i<=3;$i++){
				$code .= $chars[rand(0,count($chars)-1)];
			}
			for($i=1;$i<=3;$i++){
				$code .= $nums[rand(0,count($nums)-1)];
			}
		}
		$codes[] = $code;
	}


	echo implode('<br/>',$codes);
?>
</body>
</html>
