$(document).ready(function(){
	$('.type').change(function()
		{
			var value = $('option:selected', this).val();
			var id = $(this).data('task-id');
			$.post('handle.php',{type: value, id:id})
			.done(function() {
	    		location.reload();
	 		 })		
		});
	$('.status').change(function()
	{
		var value = $('option:selected', this).val();
		var id = $(this).data('task-id');
		$.post('handle.php',{status: value, id:id})
		.done(function() {
    		location.reload();
 		 })		
	});

	$('.autoComplete1').keyup(function(){
		var search = $('.autoComplete1').val();
		if(search != '')
		{
			$.post('handle.php',{search:search},function(data){
				$('.user-list').fadeIn();
				$('.user-list').html(data);
			})
		}
		else 
		{
			$('.user-list').fadeOut();
			$('.user-list').html('');
		}	
	});

	$(document).on('click','li',function(){
		$('.autoComplete1').val($(this).text());
		var id = $(this).data('user-id');
		$('.id').val(id);
		$('.user-list').fadeOut();
	});

	$(document).on('click','li',function(){
		$('.autoComplete2').val($(this).text());
		var id = $(this).data('user-id');
		$('.user-list').fadeOut();
		$(document).on('keypress',function(e) {
	    if(e.which == 13) {
	    	var task_id = $('#task_id').val();
	    	alert(task_id);
	        $.post('handle.php',{changeAssignee:id})
	        .done(function(){
	        	location.reload();
	        })
			}
	    })
	});
	CKEDITOR.replace('editor1');
});