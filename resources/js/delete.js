jQuery(".btn-danger").on('click',function(){
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
            if (data.success) {
                clickEle.parents('tr').remove();
                console.log("Ajaxリクエストが成功しました。");
                location.reload(); 
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
