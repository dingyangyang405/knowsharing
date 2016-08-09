$(function(){
    $("#theme-tables #follow-btn").click(function(){
        var $btn = $(this);
        $.post($btn.data('url'),function(){
            $btn.hide();
            $btn.next().show();
        })
    });

    $("#theme-tables #unfollow-btn").click(function(){
        var $btn = $(this);
        $.post($btn.data('url'),function(data){
            $btn.hide();
            $btn.prev().show();
        })
    });

    $('#unfollow-btn').on('click',function(){
        var $btn = $(this);
        $.post($btn.data('url'),function(){
            $btn.hide();
            $('#follow-btn').show();
        });
    });
    $('#follow-btn').on('click',function(){
        var $btn = $(this);
        $.post($btn.data('url'),function(){
            $btn.hide();
            $('#unfollow-btn').show();
        });
    });
})
