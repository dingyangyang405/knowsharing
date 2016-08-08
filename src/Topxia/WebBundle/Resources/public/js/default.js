 $("#collect-link").click(function(event) {
    var url = $(event.target).attr("href");
    var id = $(event.target).attr("data-id");
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.status == 'success') {
                $("#knowledge-list-"+id).attr('class', 'fa fa-star text-yellow');
            }
        }
    });

 });