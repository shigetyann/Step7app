jQuery(document).on('click', '.btn-danger', function() {
    var deleteConfirm = confirm('削除してよろしいでしょうか？');
    if(deleteConfirm == true){
        var clickEle = jQuery(this);
        var productId = clickEle.data('product_id');
        jQuery.ajax({
            type:"POST",
            url:"products/" + productId,
            data:{
                _method: "DELETE",
                _token:jQuery('meta[name="csrf-token"]').attr('content'),
            },
            dataType: 'json',

        })
        .done(function(data) {
            console.log(data); 
            if (data.success) {
                alert(data.message);
                console.log("Ajaxリクエストが成功しました。");
                jQuery('#table').html(data.table);
                jQuery('.pagination').html(data.pagination);
            } else {
                console.error("Ajaxリクエストは成功しましたが、レスポンスのsuccessプロパティがfalseです。");
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Ajaxリクエストが失敗しました。");
            console.log("jqXHR : " + jqXHR.status);
            console.log("textStatus : " + textStatus);
            console.log("errorThrown : " + errorThrown.message);
        });
    }
});
