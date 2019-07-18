$(document).ready(function(){
	setInterval(function(){
		$('body').find('.barcode_texts').focus();
	  },500);
	$('body').on('click','.update_stock',function(event){
		event.preventDefault();
		var href=$(this).data('action');
		var code=$('body').find('[name="code"]').val();
		if(code)
		{
			href+='?code='+code;
			window.location.href=href;
		}
		else
		{
			alert('Please scan code!');
			return false;
		}
	});
});