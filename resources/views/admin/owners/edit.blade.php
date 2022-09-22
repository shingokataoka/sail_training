<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="block w-52">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <h2 class="py-6 text-lg">オーナー情報編集</h2>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('admin.owners.update', $owner) }}">
            @csrf
            @method('PATCH')
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />

                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $owner->name)" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />

                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $owner->email)" required />
            </div>

            <div class="mt-4">
                <label for="shop_name">店名</label>

                <x-form.input id="shop_name" name="shop_name" value="{{ $owner->shop->owner_id . $owner->shop->name }}" disabled class="bg-gray-600 border-0 block mt-1 w-full" type="text" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-around mt-4">
                <x-form.button no="3" type="button" onclick="location.href='{{ route('admin.owners.index') }}'">戻る</x-form.button>
                <x-form.button no="1">更新する</x-form.button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
