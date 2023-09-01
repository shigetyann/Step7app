@extends('layouts.app')

@section('content')
<div class="container small">
    <h2>商品新規登録画面</h2>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <fieldset>
            <div class="form-group">
                <label for="product_name">{{ __('商品名') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
                <input type="text" class="form-control" name="product_name" id="product_name" placeholder="商品名">
                @error('product_name')
                    <span style="color:red;">商品名を20文字以内で入力してください</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">{{ __('価格') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
                <input type="number" class="form-control" name="price" id="price" placeholder="価格">
                @error('price')
                    <span style="color:red;">価格を入力してください</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="company_id">{{ __('会社名') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
                <select class="form-control" name="company_name">
                    <option>メーカー名を選択してください</option>
                    @forelse($companies as $company)
                        <option value="{{ $company['company_name'] }}" {{ $company['company_name'] == ($category ?? '') ? 'selected' : '' }}>{{ $company['company_name'] }}</option>
                    @empty
                        <option value="">メーカー名</option>
                    @endforelse
                </select>
                @error('company_name')
                    <span style="color:red;">メーカー名が選択されておりません</span>
                @enderror
                <!-- メーカー名を新規登録する場合-->
                <!-- <input type="text" class="form-control" name="company_name"> -->
            </div>
            <div class="form-group">
                <label for="stock">{{ __('在庫数') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
                <input type="number" class="form-control" name="stock" id="stock" placeholder="在庫数">
                @error('stock')
                    <span style="color:red;">在庫数を入力してください</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="comment">{{ __('コメント') }}</label>
                <textarea class="form-control" name="comment" id="comment" placeholder="コメント"></textarea>
                @error('comment')
                    <span style="color:red;">コメントを200文字以内で入力してください</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="img_path">{{ __('画像') }}</label>
                <input type="file" class="form-control-file" name="img_path" id="img_path">
                <br>
                @error('img_path')
                    <span style="color:red;">画像を選択してください</span>
                @enderror
            </div>
            <div class="d-flex justify-content-between pt-3">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary" role="button">
                    <i class="fa fa-reply mr-1" aria-hidden="true"></i>{{ __('戻る') }}
                </a>
                
                <button type="submit" class="btn btn-success">
                    {{ __('登録') }}
                </button>
            </div>
        </fieldset>
    </form>
</div>
@endsection
