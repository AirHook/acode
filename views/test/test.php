<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<div class="container">
	<div class="row">
		<form action="<?php echo base_url(); ?>mailgun/test/test/sendmail" method="post">
		  <div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" id="name" name="name">
		  </div>
		  <div class="form-group">
			<label for="pwd">Message:</label>
			<textarea name="message" id="message" class="form-control"></textarea>
		  </div>
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
		  <button type="submit" class="btn btn-default">Submit</button>
		</form>
		<h4>Create Mailing list</h4>
		<form action="/mailgun/test/test/CreateMailingList" method="post">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
		  <button type="submit" class="btn btn-default" disabled="disabled">Create Mailing List</button>
		</form>

		<h4>Get Mailing list</h4>
		<form action="/mailgun/test/test/GetMailingList" method="post">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
		  <button type="submit" class="btn btn-default">Get Mailing List</button>
		</form>

		<h4>Add Multiple Members To Mailing list</h4>
		<form action="/mailgun/test/test/AddMembersToMailingList" method="post">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
		  <button type="submit" class="btn btn-default">Add Members</button>
		</form>

		<h4>Send Message To Mailing List</h4>
		<form action="/mailgun/test/test/SendMailToMailingList" method="post">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
		  <button type="submit" class="btn btn-default">Send Mail</button>
		</form>
	</div>
</div>
