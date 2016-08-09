$(function(){
    $("#knowledge-list #collect-btn").click(function(){
        var $btn = $(this);
        var $id = $btn.data('id');
        var $collectNum = $("#uncollect-btn #uncollect-num-"+$id).text();
        $.post($btn.data('url'),function(data){
            if (data.status == 'success') {
                $collectNum = parseInt($collectNum)+parseInt(1);
                $("#uncollect-btn #uncollect-num-"+$id).html($collectNum);
                $btn.hide();
                $btn.next().show();
            } 
        })
    });

    $("#knowledge-list #uncollect-btn").click(function(){
        var $btn = $(this);
        var $id = $btn.data('id');
        var $collectNum = $("#collect-btn #collect-num-"+$id).text();
        $.post($btn.data('url'),function(data){
            if (data.status == 'success') {
                $("#uncollect-btn #uncollect-num-"+$id).html($collectNum)
                $btn.hide();
                $btn.parent().find('#knowledge-list #collect-btn').show();
            } 
        })
    });
});