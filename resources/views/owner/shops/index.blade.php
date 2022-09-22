<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('message'))
                        <x-flash-message :status="session('status')" :message="session('message')" />
                    @endif

                    <div class="flex">
                        @foreach ($shops as $shop)
                        <div class="p-2">
                            <a href="{{ route('owner.shops.edit', $shop) }}" class="block border rounded-md p-4">
                                <div class="mb-4">
                                    @if ($shop->is_selling)
                                        <span class="bg-blue-400 rounded-md p-2">販売中</span>
                                    @else
                                        <span class="bg-red-400 rounded-md p-2">停止中</span>
                                    @endif
                                </div>
                                <div class="text-xl">{{ $shop->name }}</div>
                                <x-thumbnail folder="shops" filename="{{ $shop->filename }}" class="w-24" />
                            </a>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
