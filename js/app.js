$(document).ready(function(){

		$('.status').change(function()
		{
			var value = $('option:selected', this).val();
			var id = $(this).data('task-id');
			$.post('handle.php',{status: value, id:id})
			.done(function() {
	    		location.reload();
	 		 })		
		});

		$('#autoComplete').keyup(function(){
			var search = $('#autoComplete').val();
			if(search != '')
			{
				$.post('handle.php',{search:search},function(data){
					$('#user-list').fadeIn();
					$('#user-list').html(data);
				})
			}
			else 
			{
				$('#user-list').fadeOut();
				$('#user-list').html('');
			}	
		});

		$(document).on('click','li',function(){
			$('#autoComplete').val($(this).text());
			var id = $(this).data('user-id');
			$('#id').val(id);
			$('#user-list').fadeOut();
		});
  		CKEDITOR.replace( 'editor2' );

	});