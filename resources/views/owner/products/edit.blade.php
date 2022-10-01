<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品情報 編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('message'))
                        <x-flash-message :status="session('status')" :message="session('message')" />
                    @endif

                    @if ($errors->any())
                        <x-flash-message status="alert" :message='implode("\n", $errors->all())' />
                    @endif

                    <form action="{{ route('owner.products.update', $product) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="w-1/2 mx-auto mt-4">
                            <label>
                                商品名<span class="text-xs"> ※必須</span>
                                <x-form.input type="text" name="name" :value="old('name', $product->name)" />
                            </label>
                        </div>

                        <div class="w-1/2 mx-auto mt-4">
                            <label>
                                商品情報<span class="text-xs"> ※必須</span>
                                <x-form.textarea name="information">{{ old('information', $product->information) }}</x-form.textarea>
                            </label>
                        </div>

                        <div class="w-1/2 mx-auto mt-4">
                            <label>
                                価格<span class="text-xs"> ※必須</span>
                                <x-form.input type="number" min="0" name="price" :value="old('price', $product->price)" />
                            </label>
                        </div>

                        <div class="w-1/2 mx-auto mt-4">
                            <label>
                                表示順
                                <x-form.input type="number" name="sort_order" :value="old('sort_order', $product->sort_order)" />
                            </label>
                        </div>

                        <div class="w-1/2 mx-auto mt-4">
                            <label>
                                現在在庫数
                                <x-form.input type="number" :value="$quantity" disabled class="border-0 bg-gray-200" />
                                <input type="hidden" name="current_quantity" value="{{ $quantity }}">
                            </label>
                        </div>

                        <div class="w-1/2 mx-auto mt-4 flex justify-around">
                            <label>
                                @php
                                    $value = \Constant::PRODUCT_ADD;
                                @endphp
                                <input type="radio" name="type" value="{{ $value }}"
                                    @checked((old('type', $value) === $value))
                                    />
                                追加
                            </label>
                            <label>
                                @php
                                    $value = \Constant::PRODUCT_REDUCE;
                                @endphp
                                <input type="radio" name="type" value="{{ $value }}"
                                    @checked((old('type') === $value))
                                    />
                                削減
                            </label>
                        </div>

                        <div class="w-1/2 mx-auto mt-4">
                            <label>
                                数量<span class="text-xs"> ※必須</span>
                                <x-form.input type="number" name="quantity" :value="old('quantity', 0)" min="0" />
                            </label>
                        </div>

                        <div class="w-1/2 mx-auto mt-4">
                            <label>
                                販売する店舗
                                <select name="shop" class="w-full">
                                @foreach ($shops as $shop)
                                    <option value="{{ $shop->id }}"
                                        @selected($shop->id === (int)old('shop', $product->shop->id) )
                                        >{{ $shop->name }}</option>
                                @endforeach
                                </select>
                            </label>
                        </div>

                        <div class="w-1/2 mx-auto mt-4">
                            <label>
                                カテゴリ
                                <select name="category" class="w-full">
                                @foreach ($primaries as $primary)
                                    <optgroup label="{{ $primary->name }}">
                                    @foreach ($primary->secondaries as $secondary)
                                      <option value="{{ $secondary->id }}"
                                            @selected($secondary->id === (int)old('category', $product->secondary_category_id) )
                                            >{{ $secondary->name }}</option>
                                    @endforeach
                                    </optgroup>
                                @endforeach
                                </select>
                            </label>
                        </div>

                        <div class="w-1/2 mx-auto mt-4">
                            <x-select-image
                                :images="$images"
                                name="image1"
                                :filename="$product->image1->filename"
                                :value="$product->image1->id"
                                />
                        </div>
                        <div class="w-1/2 mx-auto mt-4">
                            <x-select-image
                                :images="$images"
                                name="image2"
                                :filename="$product->image2->filename"
                                :value="$product->image2->id"
                                />
                        </div>

                        <div class="w-1/2 mx-auto mt-4">
                            <x-select-image
                                :images="$images"
                                name="image3"
                                :filename="$product->image3->filename"
                                :value="$product->image3->id"
                                />
                        </div>

                        <div class="w-1/2 mx-auto mt-4">
                            <x-select-image
                                :images="$images"
                                name="image4"
                                :filename="$product->image4->filename"
                                :value="$product->image4->id"
                                />
                        </div>



                        <div class="w-1/2 mx-auto mt-4 flex justify-around">
                            <label>
                                <input type="radio" name="is_selling" value="1"
                                    @checked(old('is_selling', $product->is_selling))
                                    />
                                販売中
                            </label>
                            <label>
                                <input type="radio" name="is_selling" value="0"
                                    @checked(!old('is_selling', $product->is_selling))
                                    />
                                停止中
                            </label>
                        </div>


                        <div class="flex justify-around mt-8">
                            <x-form.button type="button" no="3" px="px-8" onclick="location.href='{{ route('owner.products.index') }}'">戻る</x-form.button>
                            <x-form.button no="1" px="px-8" >更新する</x-form.button>
                        </div>
                    </form>

                    <form
                        id="delete_form"
                        class="text-center my-8"
                        action="{{ route('owner.products.destroy', $product) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <x-form.button type="button" onclick="deletePost(this)" no="caution" px="px-8" >削除</x-form.button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        'use strict';

        const images = document.querySelectorAll('.select-image');
        images.forEach(image => {
            image.addEventListener('click', e => {
                const imageSrc = image.src;
                const imageId = image.dataset.id;
                const imageName = image.dataset.name;
                document.getElementById(imageName + '_thumbnail').src = imageSrc;
                document.getElementById(imageName + '_hidden').value = imageId;
                document.getElementById(imageName + '_close').click();
            });
        });

        function deletePost(e) {
            const form = document.getElementById('delete_form');
            if (!confirm('本当に削除しますか？')) return;
            form.submit();
        }
    </script>
</x-app-layout>
