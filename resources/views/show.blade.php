@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif
                    <div class = "container">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <div class = "text-left">
                                    <h2 class="mb-4">商品情報詳細</h2>
                                </div>
                                    <dl class="row mt-3" >
                                        <dt class="col-sm-3">商品情報ID</dt>
                                        <dd class="col-sm-9">{{ $product->id }}</dd>

                                        <dt class="col-sm-3">商品画像</dt>
                                        <dd class="col-sm-9"><img src="{{ asset('storage/' . $product -> img_path) }}" width="100px" height="100px"></dd>

                                        <dt class="col-sm-3">商品名</dt>
                                        <dd class="col-sm-9">{{ $product->product_name }}</dd>

                                        <dt class="col-sm-3">メーカー</dt>
                                        <dd class="col-sm-9">{{ $product->company->company_name }}</dd>

                                        <dt class="col-sm-3">価格</dt>
                                        <dd class="col-sm-9">{{ $product->price }}円</dd>

                                        <dt class="col-sm-3">在庫数</dt>
                                        <dd class="col-sm-9">{{ $product->stock }}個</dd>

                                        <dt class="col-sm-3">コメント</dt>
                                        <dd class="col-sm-9">{{ $product->comment }}</dd>
                                    </dl>
                                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-1">戻る</a>
                                    <a href="{{ route('products.edit', $product )}}" class="btn btn-primary mt-1">編集</a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


