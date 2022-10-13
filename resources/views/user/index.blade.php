<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品一覧
        </h2>

        <form class="flex items-end justify-between flex-wrap">
            <div class="flex gap-2 flex-wrap">
                <select name="category">
                    <option value="0">全て</option>
                    @foreach ($categories as $primary)
                        <optgroup label="{{ $primary->name }}">
                        @foreach ($primary->secondaries as $secondary)
                            <option value="{{ $secondary->id }}" @selected($secondary->id === (int)\Request::get('category'))>{{ $secondary->name }}</option>
                        @endforeach
                        </optgroup>
                    @endforeach
                </select>
                <input type="text" name="keyword" value="{{ \Request::get('keyword') }}">
                <x-form.button class="min-w-fit">検索する</x-form.button>
            </div>
            <div class="flex gap-4 min-w-fit">
                <div>
                    <div>表示順</div>
                    <select name="sort_order">
                        @foreach (\Constant::SORT_LIST as $text => $value)
                            <option value="{{ $value }}" @selected($value === \Request::get('sort_order'))>{{ $text }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <div>表示件数</div>
                    <select name="pagination">
                        @foreach ([20, 50, 100] as $pagination)
                            <option value="{{ $pagination }}" @selected($pagination === (int)\Request::get('pagination'))>{{ $pagination}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </form>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('message'))
                        <x-flash-message :status="session('status')" :message="session('message')" />
                    @endif

                    @if ($errors->any())
                        <x-flash-message :status="alert" :message="implode("\n", $errors->all())" />
                    @endif

                    <div class="flex flex-wrap">
                        @foreach ($products as $product)
                        <div class="px-2 py-4 w-1/3 md:w-1/4">
                            <a href="{{ route('user.items.show', $product->id) }}" class="block border rounded-md p-4">
                                <x-thumbnail folder="products" filename="{{ $product->image1_filename }}" />
                                <div class=" text-xs">{{ $product->category_name }}</div>
                                <div>{{ $product->name }}</div>
                                <div>{{ number_format($product->price) }}円（税込）</div>
                                <div>おすすめ順位{{ $product->sort_order }}</div>
                                <div>在庫数：{{ $product->stock_quantity }}</div>
                                <div>カート数：{{ $product->cart_quantity }}</div>
                                <div>販売数数：{{ $product->sales_quantity }}</div>
                                <div>{{ $product->created_at }}</div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                    <div>{{
                        $products
                            ->appends([
                                'category' => \Request::get('category'),
                                'keyword' => \Request::get('keyword'),
                                'sort_order' => \Request::get('sort_order'),
                                'pagination' => \Request::get('pagination'),
                            ])
                            ->links()
                    }}</div>

                </div>
            </div>
        </div>
    </div>

    <script>
        'use strict';

        const sortOrder = document.querySelector('[name="sort_order"]');
        const pagination = document.querySelector('[name="pagination"]');
        sortOrder.addEventListener('change', function() {
            this.form.submit();
        });
        pagination.addEventListener('change', function() {
            this.form.submit();
        });
    </script>
</x-app-layout>
