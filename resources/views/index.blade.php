@extends('layouts.app')

@section('content')
<div class="container">
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
                                    <h2 style = "font-size:1rem;">商品一覧画面</h2>
                                </div>
                                <!-- 商品検索 -->
                                <form action = "" method = "GET">
                                    <div class = "row">
                                        <div class = "col-4">
                                        <label for="product_name">{{ __('商品名') }}</label>
                                            <input type = "text" name = "keyword" value = "{{ $keyword ?? '' }}">
                                        </div>
                                        <div class = "col-3">
                                        <label for="product_name">{{ __('メーカー名') }}</label>
                                            <select name = "category">
                                            @forelse($companies as $company)
                                                <option value="{{ $company['company_name'] }}" {{ $company['company_name'] == ($category ?? '') ? 'selected' : '' }}>{{ $company['company_name'] }}</option>
                                            @empty
                                                <option value="">メーカー名</option>
                                            @endforelse
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <input type = "submit"  value = "検索">
                                        </div>
                                        <div class="col-2">
                                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary" role="button">
                                                <i class="fa fa-reply mr-1" aria-hidden="true"></i>{{ __('一覧') }}
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" >
                        <tr>
                            <th>ID</th>
                            <th>商品画像</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>在庫数</th>
                            <th>メーカー名</th>
                            <th><a href="{{ route('products.create') }}">新規登録</a></th>
                        </tr>
                        @foreach($products as $product)
                        <tr>
                            <td >{{ $product -> id}}</td>
                            <td><img src="{{ asset('storage/'. $product->img_path) }}" width="100px" height="100px"></td>
                            <td>{{ $product -> product_name}}</td>
                            <td>{{ $product -> price}}</td>
                            <td>{{ $product -> stock}}</td>
                            <td>{{ $product -> company_name}}</td>
                            <td><a class="btn btn-primary btn-sm mx-1" href="{{ route('products.show', ['product' => $product->id]) }}">詳細</a>
                                <form method="POST" action="{{ route('products.destroy', ['product' => $product->id])}}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm mx-1" type="submit" >削除</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if(count($products) == 0)
                            <p>検索条件に一致する商品はありませんでした</p>
                        @endif
                    </table>
                    {{ $products -> links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
