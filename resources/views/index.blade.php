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
                                <form action="{{ route('products.index')}}" method="GET" >
                                    <div class="row">
                                        <div class="col-3" >
                                            <label for="product_name">{{ __('商品名') }}</label>
                                            <input type="text" class="form-control" name="keyword" value="{{ $keyword ?? '' }}" id="keyword">

                                            <label for="product_name">{{ __('メーカー名') }}</label>
                                            <select name="category" id="category" class="form-control">
                                            @forelse($companies->sortBy('company_name') as $company)
                                                <option value="{{ $company->company_name }}" {{ $company->company_name == ($category ?? '') ? 'selected' : '' }}>{{ $company->company_name }}</option>
                                            @empty
                                                <option value="">メーカー名</option>
                                            @endforelse
                                            </select>
                                        </div>

                                        <div class="col-3">
                                            
                                                <label for="product_price">{{ __('価格')}}</label>
                                                
                                                <div class="priceMax">
                                                <input type="number" class="form-control" name="priceMax" id="priceMax" min="0" placeholder="上限">
                                                </div>

                                                <div class="priceMin">
                                                <input type="number" class="form-control" name="priceMin" id="priceMin" min="0" placeholder="下限">
                                                </div>
                                            
                                        </div>

                                        <div class="col-3">
                                        
                                                <label for="stock">{{ __('在庫数')}}</label>
                                                
                                                <div class="stockMax">
                                                <input type="number" class="form-control w20" name="stockMax" id="stockMax" min="0" placeholder="上限">
                                                </div>

                                                <div class="stockMin">
                                                <input type="number" class="form-control w20" name="stockMin" id="stockMin" min="0" placeholder="下限">
                                                
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <input type="submit"  value="検索" id="search">
                                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary" role="button">
                                                <i class="fa fa-reply mr-1" aria-hidden="true"></i>{{ __('一覧') }}
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @include('products.table', ['products' => $products])
                    @include('products.pagination', ['products' => $products])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

