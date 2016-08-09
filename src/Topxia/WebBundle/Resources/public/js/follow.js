$(function(){
    $("#topic-tables #follow-btn").click(function(){
        var $btn = $(this);
        $.post($btn.data('url'),function(){
            $btn.hide();
            $btn.next().show();
        })
    });

    $("#topic-tables #unfollow-btn").click(function(){
        var $btn = $(this);
        $.post($btn.data('url'),function(data){
            $btn.hide();
            $btn.prev().show();
        })
    });
})