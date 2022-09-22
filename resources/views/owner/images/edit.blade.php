<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="block w-52">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <h2 class="py-6 text-lg">画像 - 情報編集</h2>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('owner.images.update',
        $image) }}">
            @csrf
            @method('PATCH')

            <div class="mt-4">
                <label>
                    タイトル
                    <x-form.input name="title" required class="p-2 border w-full" />
                </label>
            </div>

            <div class="mt-8">
                <x-thumbnail folder="products" filename="{{ $image->filename }}" class="w-24" />
            </div>

            <div class="flex items-center justify-around mt-8">
                    <x-form.button no="3" type="button" onclick="location.href='{{ route('owner.images.index') }}'">戻る</x-form.button>
                <x-form.button no="1">登録する</x-form.button>
            </div>
        </form>

        <form action="{{ route('owner.images.destroy', $image) }}" method="POST" class="mt-8 text-center" id="delete_{{ $image->id }}">
            @csrf
            @method('DELETE')
            <x-form.button no="caution" type="button" onclick="delete_post(this)" data-id="{{ $image->id }}">削除</x-form.button>
        </form>

    </x-auth-card>
</x-guest-layout>

<script>
    'use strict';

    function delete_post(e) {
        const id = e.dataset.id;
        const form = document.getElementById('delete_' + id);
        if (!confirm('本当に削除しますか？')) return;
        form.submit();
    }
</script>
