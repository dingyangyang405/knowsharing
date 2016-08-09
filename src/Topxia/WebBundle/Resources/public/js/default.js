$(function(){
    $(".collect-btn").click(function(){
        var $btn = $(this);
        var $collectNum = $btn.find(".collect-num").html();
        $.post($btn.data('url'),function(data){
            if (data.status == 'success') {
                $collectNum = parseInt($collectNum)+parseInt(1);
                $btn.hide();
                $btn.parent().find(".uncollect-btn").show();
                $btn.parent().find(".uncollect-btn").find(".uncollect-num").html($collectNum);
            } 
        })
    });

    $(".uncollect-btn").click(function(){
        var $btn = $(this);
        var $collectNum = $btn.find(".uncollect-num").html();
        $.post($btn.data('url'),function(data){
            if (data.status == 'success') {
                $collectNum = parseInt($collectNum)-parseInt(1);
                $btn.parent().find(".collect-btn").find(".collect-num").html($collectNum);
                $btn.hide();
                $btn.parent().find(".collect-btn").show();
            }
        })
    });
});