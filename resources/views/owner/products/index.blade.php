<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品管理
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
                        <x-flash-message :status="alert" :message="implode("\n", $errors->all())" />
                    @endif

                    <div class="text-right p-6">
                        <x-form.button no="1" px="px-8" onclick="location.href='{{ route('owner.products.create') }}'">新規登録する</x-form.button>
                    </div>

                    <div class="flex flex-wrap">
                        @foreach ($products as $product)
                        <div class="px-2 py-4 w-1/3 md:w-1/4">
                            <a href="{{ route('owner.products.edit', $product) }}" class="block border rounded-md p-4">
                                <x-thumbnail folder="products" filename="{{ $product->image1->filename }}" />
                                <div class="mt-4">{{ $product->name }}</div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                    <div>{{ $products->links() }}</div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
