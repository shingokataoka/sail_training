<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="block w-52">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <h2 class="py-6 text-lg">画像 - 新規登録</h2>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form enctype="multipart/form-data" method="POST" action="{{ route('owner.images.store') }}">
            @csrf

            <div class="mt-4">
                <label>
                    画像
                    <x-form.input type="file" name="image_files[]" multiple accept="image/jpeg, image/jpg, image/png" class="p-2 border" />
                </label>
            </div>

            <div class="flex items-center justify-around mt-4">
                    <x-form.button no="3" type="button" onclick="location.href='{{ route('owner.images.index') }}'">戻る</x-form.button>
                <x-form.button no="1">登録する</x-form.button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
