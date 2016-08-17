$(document).ready(function(){
    $('div.news-list #create-todo-btn').click(function(){
        var btn = $(this);
        $.post(btn.data('url'), function(data, status) {
            if (status == true) {
                var parent = btn.parents('.news-list');
                parent.fadeTo('slow', 0.01, function(){
                    $(this).slideUp('slow', function(){
                        $(this).remove();
                    });
                });                
            } else {
                location.href="http://www.know.com/login";
            }
        })
    });

    $('div.news-list #delete-todo-btn').click(function(){
        var btn = $(this);
        $.post(btn.data('url'), function(data){
            
        })
    });
})