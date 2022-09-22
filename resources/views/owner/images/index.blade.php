<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            画像管理
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('message'))
                        <x-flash-message :status="session('status')" :message="session('message')" />
                    @endif

                    <div class="text-right p-6">
                        <x-form.button no="1" px="px-8" onclick="location.href='{{ route('owner.images.create') }}'">新規登録する</x-form.button>
                    </div>

                    <div class="flex flex-wrap">
                        @foreach ($images as $image)
                        <div class="px-2 py-4 w-1/3 md:w-1/4">
                            <a href="{{ route('owner.images.edit', $image) }}" class="block border rounded-md p-4">
                                <x-thumbnail folder="products" filename="{{ $image->filename }}" />
                                <div class="mt-4">{{ $image->title }}</div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
