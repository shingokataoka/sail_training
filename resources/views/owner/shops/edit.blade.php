<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="block w-52">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <h2 class="py-6 text-lg">店舗 情報編集</h2>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form enctype="multipart/form-data" method="POST" action="{{ route('owner.shops.update', $shop) }}">
            @csrf
            @method('PATCH')

            <div class="mt-4">
                <label for="name">店名</label>

                <x-form.input id="name" name="name" value="{{ $shop->name }}" class=" block mt-1 w-full" type="text" />
            </div>

            <div class="mt-4">
                <label for="information">店舗情報</label>

                <x-form.textarea id="information" name="information" value="" class=" block mt-1 w-full" type="text">{{ $shop->information }}</x-form.textarea>
            </div>

            <div class="mt-4">
                <x-thumbnail folder="shops" filename="{{ $shop->filename }}" class="w-24" />
            </div>

            <div class="mt-4">
                <label for="image">画像</label>

                <x-form.input id="image" name="image" value="{{ $shop->image }}" class=" block mt-1 w-full" type="file" apcept="image/jpeg, image/jpg, image/png" />
            </div>

            <div class="mt-4 p-4 flex justify-around">
                <label>
                    <input type="radio" name="is_selling" value="1" @checked($shop->is_selling) />
                    <span>販売中</span>
                </label>
                <label>
                    <input type="radio" name="is_selling" value="0" @checked(!$shop->is_selling) />
                    停止中
                </label>

            </div>

            <div class="flex items-center justify-around mt-4">
                    <x-form.button no="3" type="button" onclick="location.href='{{ route('admin.owners.index') }}'">戻る</x-form.button>
                <x-form.button no="1">更新する</x-form.button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
