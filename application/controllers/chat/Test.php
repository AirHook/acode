<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Connecting...<br />';
		


		?>
		<script src='//cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.4/socket.io.min.js'></script>
<script>
	// Connect to server
	//var io = require('socket.io-client');
	var socket = io.connect('http://localhost:8080', {secure: true, reconnect: true, rejectUnauthorized: false, upgrade : false});
	//var socket = io.connect("/");
	//var socket = new io.Socket('localhost',{'port':8080});
	//socket.connect();
	
	socket.emit('login', 'Aguhu');
	
	socket.on('connect_error', function(error){
		console.log("connect_error", e);
		alert(error);
	});
	
	// Add a connect listener
	socket.on('connect', function(socket) {
		console.log('Connected!');
		alert('connected...')
	});
</script>
		<?php
		
		echo '<br />';
		echo 'done<br />';
	}
	
	// ----------------------------------------------------------------------
	
}
