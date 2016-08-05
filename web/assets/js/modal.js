$(document).ready(function(){
    $('#addlink').click(function(){
        var $formParam = $('#addlinkForm').serialize();
        var $url = $(this).data('url');
        var $linkurl = $('[name = linkurl]').val();
        var $title = $('[name = title]').val();
        var $summary = $('[name = summary]').val();
        $.ajax({
            url:$url,
            data:{linkurl:$linkurl,title:$title,summary:$summary},
            type:"POST",
            success:function(data){
                console.log(data);
                
            },
            error:function(jqXHR){
                console.log("sss");
            }
        })
    })
});