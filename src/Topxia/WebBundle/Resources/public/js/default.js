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

    $(".like-btn").click(function(){
        var $btn = $(this);
        var $collectNum = $btn.find(".like-num").html();
        $.post($btn.data('url'),function(data){
            if (data.status == 'success') {
                $collectNum = parseInt($collectNum)+parseInt(1);
                $btn.hide();
                $btn.parent().find(".dislike-btn").show();
                $btn.parent().find(".dislike-btn").find(".dislike-num").html($collectNum);
            } 
        })
    });

    $(".dislike-btn").click(function(){
        var $btn = $(this);
        var $collectNum = $btn.find(".dislike-num").html();
        $.post($btn.data('url'),function(data){
            if (data.status == 'success') {
                $collectNum = parseInt($collectNum)-parseInt(1);
                $btn.parent().find(".like-btn").find(".like-num").html($collectNum);
                $btn.hide();
                $btn.parent().find(".like-btn").show();
            }
        })
    });

    $(".delete-favorite").click(function(){
        var $btn = $(this);
        if (confirm('确定要取消收藏吗?')) {
            $.post($btn.data('url'),function(data){
                if (data.status == 'success') {
                    location.reload();
                }
            })
        }
    });
});