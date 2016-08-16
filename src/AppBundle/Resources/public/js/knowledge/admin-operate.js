$(document).ready(function(){
    $('span').on('click','.admin-delete-btn',function() {
        var url = $(this).data('url');
        if (confirm('确定要删除吗？')) {    
            $.post(url,function(data){  
                if(data.status == 'success') {
                  location.href = '/';  
                } else {
                    alert('删除失败');
                }                  
            });
            location.reload();
        }
    });
})