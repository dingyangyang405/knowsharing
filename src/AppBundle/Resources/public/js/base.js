//返回顶部按钮
$(function(){
    $(window).scroll(function(){
        if($(window).scrollTop()>100){
            $(".gotop").fadeIn();
        }
        else{
            $(".gotop").hide();
        }
    });
    $(".gotop").click(function(){
        $('html,body').animate({'scrollTop':0},500);
    });
    $("#header-xs-menu").find(".list-group-item").hide();
    i = 0;
    $(".header-xs-logo").click(function(){
        i = i+1;
        if(i%2 == 1 )
        {
            $("#header-xs-menu").show();
        }else{
            $("#header-xs-menu").hide();
        }
    });

    k = 0;
    $(".list-group-heading-first").click(function(){
        k = k + 1;
        if(k%2 == 1)
        {
            $("#header-xs-menu .list-group-item").hide();
            z = 0;
            $(this).parent().find(".list-group-item").show();
        } else {
            $("#header-xs-menu .list-group-item").hide();
        }
    });

    z = 0;
    $(".list-group-heading-second").click(function(){
        z = z + 1;
        if(z%2 == 1)
        {
            k = 0;
            $("#header-xs-menu .list-group-item").hide();
            $(this).parent().find(".list-group-item").show();
        } else {
            $("#header-xs-menu .list-group-item").hide();
        }
    });
});