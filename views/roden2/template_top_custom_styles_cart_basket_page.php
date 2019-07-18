<style>

	 /* The Modal (background) */
	.modal {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 10000; /* Sit on top */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content/Box */
	.modal-content {
		background-color: #fefefe;
		margin: 5% auto; /* 15% from the top and centered */
		padding: 20px;
		border: 1px solid #888;
		width: 350px; /* Could be more or less, depending on screen size (or in precentage) */
	}
	.modal-header h1 {
		margin: 0;
		padding-bottom: 10px;
		border-bottom: 1px solid #dedede;
	}
	.modal-body {
		padding: 10px 0;
	}

	/* The Close Button */
	.close {
		color: #aaa;
		float: right;
		font-size: 20px;
		font-weight: bold;
	}

	.close:hover,
	.close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
	}
	
	/* Others */
	.button.button--medium { width: 100px; }
	
</style>