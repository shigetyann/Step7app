$("#search").on('click',function(e){
    e.preventDefault();

    var formData = $(this).closest('form').serialize();
    var searchUrl = 'http://localhost:8888/Step7app/public/search';
    console.log(formData);
    $.ajax({
        type:"GET",
        url:searchUrl,
        data: formData,
        dataType: 'json',
    })
    .done(function(data){
        $("#table tbody").empty();
        if (data.products.data.length === 0) {
            $("#table tbody").append('<tr><td colspan="7">検索条件に一致する商品はありませんでした</td></tr>');
        } else {
            $.each(data.products.data, function(i, item) {
                if (item && item.img_path) {
                    var url = '/products/show/' + item.id;
                    var row = '<tr><td>' + item.id + '</td><td><img src="/Step7app/public/storage/' + item.img_path + '" width="100px" height="100px"></td><td>' + item.product_name + '</td><td>' + item.price + '円</td><td class="stock-display" data-product_id="' + item.id + '">' + item.stock + '個</td><td>' + item.company.company_name + '</td><td><input type="number" min="1" class="quantity-input" data-product_id="' + item.id + '" value="1"><button data-product_id="' + item.id + '" class="btn btn-success btn-sm mx-1 purchase-button">購入</button><a class="btn btn-primary btn-sm mx-1" href="' + url + '">詳細</a><button data-product_id="' + item.id + '" class="btn btn-danger btn-sm mx-1 delete-button">削除</button></td></tr>';
                    $("#table tbody").append(row);
                }
            });
        }
    })
    .fail(function(error){
        console.log(error);
    });
    $("#table").trigger("update");
});
