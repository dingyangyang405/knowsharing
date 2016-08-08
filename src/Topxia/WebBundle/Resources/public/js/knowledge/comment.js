$(document).ready(function(){
	$('#comment').click(function(){
		var data = $('[name = comment]').val();
        $.post($(this).data('utl'),data, function(){
            // window.location.href();
        });
    })
})