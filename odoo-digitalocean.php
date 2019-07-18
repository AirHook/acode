<?php

$listHost = array(array('domain'	=> 'basixblacklabel.salesuser.com', 
						'db'		=> 'basix'),
				  array('domain'	=> 'rcpixel.salesuser.com', 
				  		'db'		=> 'rcpixel')
				 );

$arrHost = array();
foreach($listHost as $host) {
	
	if($_SERVER['HTTP_HOST'] == $host['domain']) {
		?>
		<!DOCTYPE html>
		<html>
		<head>
		</head>
		<body style="margin:0px;">
		<iframe style="display: block;       /* iframes are inline by default */
	    background: #fff;
	    border: none;         /* Reset default border */
	    height: 100vh;        /* Viewport-relative units */
	    width: 100vw;" id="foo" src="http://165.227.209.167:8069/web/login?db=<?php echo $host['db']; ?>" /></iframe>
		</body>
		</html>

		<?php

		exit;
	}
}

