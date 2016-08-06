$(function(){
    $('#addlink').click(function(){
        var formParam  = $('#add').serialize();
        var url = $(this).data('url');
        $.ajax({
            url:url,
            data:formParam,
            type:"POST",
            success:function(data){
                
            }
            error:function(jqXHR){
                alter("wrong"+jqXHR.status);
            }
        })
    })
})