$(document).ready(function(){
    $("body").css({ 'overflow-y': 'scroll'});
    $('#addLink').click(function(){
        var $url = $(this).data('url');
        var $linkUrl = $('[name = linkUrl]').val();
        var $title = $('[name = linkUrlTitle]').val();
        var $summary = $('[name = linkUrlSummary]').val();
        $.ajax({
            url:$url,
            data:{content:$linkUrl,title:$title,summary:$summary,type:'link'},
            type:"POST",
            success:function(data){
                location.href = '/';
            },
            error:function(jqXHR){
                alert("添加失败！");
            }
        });
    });

    $('#addFile').click(function(){
        var $url = $(this).data('url');
        var $file = $('[name = file]').val();
        var $title = $('[name = fileTitle]').val();
        var $summary = $('[name = fileSummary]').val();
        $.ajax({
            url:$url,
            data:{content:$file,title:$title,summary:$summary,type:'file'},
            type:"POST",
            success:function(data){
                location.href = '/';
            },
            error:function(jqXHR){
                alert("添加失败！");
            }
        });
    });

    $("#docModal").click(function(event){
        var $url = $(event.target).attr("data-url");
        $.get($url, function(data){
            console.log(data);
            $("#uploadModal").html(data).modal();
        });
    });

    $("#linkModal").click(function(event){
        var $url = $(event.target).attr("data-url");
        $.get($url, function(data){
            console.log(data);
            $("#uploadModal").html(data).modal();
        });
    });
});

