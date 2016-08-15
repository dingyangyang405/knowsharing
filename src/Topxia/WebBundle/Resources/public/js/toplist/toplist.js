$(document).ready(function(){
    $("#like-knowledge").click(function(){
        $.ajax({
            url:$(this).data('url'),
            data:{type:$(this).data('type')},
            type:"POST",
        })
    });

    $("#favorite-knowledge").click(function(){
        $.ajax({
            url:$(this).data('url'),
            data:{type:$(this).data('type')},
            type:"POST",
        })
    });

    $("#view-knowledge").click(function(){
        $.ajax({
            url:$(this).data('url'),
            data:{type:$(this).data('type')},
            type:"POST",
        })
    });

    $("#follow-topic").click(function(){
        $.ajax({
            url:$(this).data('url'),
            data:{type:$(this).data('type')},
            type:"POST",
        })
    });

    $("#knowledge-topic").click(function(){
        $.ajax({
            url:$(this).data('url'),
            data:{type:$(this).data('type')},
            type:"POST",
        })
    });

    $("#score-user").click(function(){
        $.ajax({
            url:$(this).data('url'),
            data:{type:$(this).data('type')},
            type:"POST",
        })
    });

    $("#knowledge-user").click(function(){
        $.ajax({
            url:$(this).data('url'),
            data:{type:$(this).data('type')},
            type:"POST",
        })
    });

    $("#browse-user").click(function(){
        $.ajax({
            url:$(this).data('url'),
            data:{type:$(this).data('type')},
            type:"POST",
        })
    });
});