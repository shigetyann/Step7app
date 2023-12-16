<table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th data-sort-initial-order="desc">ID</th>
                                <th>商品画像</th>
                                <th>商品名</th>
                                <th>価格</th>
                                <th>在庫数</th>
                                <th>メーカー名</th>
                                <th><a href="{{ route('products.create') }}">新規登録</a></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td >{{ $product -> id}}</td>
                            <td><img src="{{ asset('storage/'. $product->img_path) }}" width="100px" height="100px"></td>
                            <td>{{ $product -> product_name}}</td>
                            <td>{{ $product -> price}}円</td>
                            <td class="stock-display" data-product_id="{{ $product->id }}">{{ $product -> stock}}個</td>
                            <td>{{ $product -> company -> company_name}}</td>
                            <td>
                            <input type="number" min="1" class="quantity-input" data-product_id="{{ $product->id }}" value="1">
                                <button data-product_id="{{ $product->id }}" class="btn btn-success btn-sm mx-1 purchase-button">購入</button>
                                <a class="btn btn-primary btn-sm mx-1" href="{{ route('products.show', ['product' => $product->id]) }}">詳細</a>
                                <button data-product_id="{{ $product->id }}" class="btn btn-danger btn-sm mx-1 delete-button">削除</button>
                            </td>
                        </tr>
                        @endforeach
                        @if(count($products) == 0)
                            <p>検索条件に一致する商品はありませんでした</p>
                        @endif
                        </tbody>
                    </table>