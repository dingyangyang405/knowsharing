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

    $('#user #unfollow-btn').on('click',function(){
        var $btn = $(this);
        $.post($btn.data('url'),function(){
            $btn.hide();
            $('#follow-btn').show();
        });
    });
    $('#user #follow-btn').on('click',function(){
        var $btn = $(this);
        $.post($btn.data('url'),function(){
            $btn.hide();
            $('#unfollow-btn').show();
        });
    });
})
