$(document).ready(function(){

	// $.get($btn.data('url'),function(data){
 //        if (data.status == 'success') {
 //            $collectNum = parseInt($collectNum)+parseInt(1);
 //            $btn.hide();
 //            $btn.parent().find(".uncollect-btn").show();
 //            $btn.parent().find(".uncollect-btn").find(".uncollect-num").html($collectNum);
 //        } 
 //    })

    $("#like").click(function(){
        $.ajax({
            url:$(this).data('url'),
            data:{type:$(this).data('type')},
            type:"POST",
        })
    });
});