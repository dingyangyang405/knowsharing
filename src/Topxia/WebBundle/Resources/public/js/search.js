$(document).ready(function(){
    $('#search-my-knowledge').click(function(){
        var keyword = $(this).val();
        var url = $(this).data('data-url');
        $.ajax({
            url:url,
            data:{ keyword:keyword },
            success:function(data) {
                consolo.log(data);
            },
            error:function(data) {

            }
        });
    });
});