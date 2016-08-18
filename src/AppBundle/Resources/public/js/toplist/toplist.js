$(document).ready(function(){
    $("#like-knowledge").click(function(){
        $.ajax({
            url:$(this).data('url'),
            data:{type:$(this).data('type')},
            type:"POST",
    	});
    });

    $("#favorite-knowledge").click(function(){
        $.ajax({
            url:$(this).data('url'),
            data:{type:$(this).data('type')},
            type:"POST",
        });
    });

    $("#view-knowledge").click(function(){
        $.ajax({
            url:$(this).data('url'),
            data:{type:$(this).data('type')},
            type:"POST",
        });
    });
});
