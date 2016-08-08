$(function(){
    $("#collect-btn").click(function(){
        var $btn = $(this);
        var $id = $btn.data('id');
        var $collectNum = $("#collect-btn").text();
        $.post($btn.data('url'),function(data){
            if (data.status == 'success') {
                $collectNum = parseInt($collectNum)+parseInt(1);
                console.log($collectNum);
                $("#collect-btn").html($collectNum)
                $btn.hide();
                $btn.next().show();
            } 
        })
    });

    $("#uncollect-btn").click(function(){
        var $btn = $(this);
        $.post($btn.data('url'),function(data){
            $btn.hide();
            $btn.prev().show();
        })
    });
});