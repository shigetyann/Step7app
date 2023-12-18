jQuery(document).on('click','.purchase-button',function(){
    var purchaseConfirm = confirm('購入しますか？');
    if(purchaseConfirm == true){
        var clickEle = jQuery(this);
        var product_id = clickEle.data('product_id');
        var quantity = jQuery('.quantity-input[data-product_id="' + product_id + '"]').val();
        jQuery.ajax({
            url:  'http://localhost:8888/Step7app/public/api/purchase',
            type: 'POST',
            data: {
                _token:jQuery('meta[name="csrf-token"]').attr('content'),
                product_id: product_id,
                quantity: quantity,
            }
        })
        .done(function(response) {
            alert(response.message);
            var stockElement = jQuery('.stock-display[data-product_id="' + product_id + '"]');
            stockElement.text(response.new_stock + '個');
        })
        .fail(function(response) {
            if(response.responseJSON && response.responseJSON.message) {
                alert(response.responseJSON.message);
            } else {
                alert('エラーが発生しました');
            }
        });
    }
});
