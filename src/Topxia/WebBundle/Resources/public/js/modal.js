$(document).ready(function(){
    $("body").css({ 'overflow-y': 'scroll'});
    $('#addlink').click(function(){
        var $formParam = $('#addlinkForm').serialize();
        var $url = $(this).data('url');
        var $linkurl = $('[name = linkurl]').val();
        var $title = $('[name = linkUrlTitle]').val();
        var $summary = $('[name = linkUrlSummary]').val();
        $.ajax({
            url:$url,
            data:{content:$linkurl,title:$title,summary:$summary,type:'link'},
            type:"POST",
            success:function(data){
                location.href = '/';
            },
            error:function(jqXHR){
                console.log("添加失败！");
            }
        })
    })

    $('#addfile').click(function(){
        var $formParam = $('#addfileForm').serialize();
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
                console.log("添加失败！");
            }
        })
    })
});

