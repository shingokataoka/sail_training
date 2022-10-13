<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品の詳細
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

                    <div class="md:flex gap-4">
                        <div class="md:w-1/2 swiper">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                <x-thumbnail folder="products" :filename="$product->image1->filename" class="swiper-slide object-contain" />
                                <x-thumbnail folder="products" :filename="$product->image2->filename" class="swiper-slide object-contain" />
                                <x-thumbnail folder="products" :filename="$product->image3->filename" class="swiper-slide object-contain" />
                                <x-thumbnail folder="products" :filename="$product->image4->filename" class="swiper-slide object-contain" />
                            </div>
                            <!-- If we need pagination -->
                            <div class="swiper-pagination"></div>

                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>

                            <!-- If we need scrollbar -->
                            {{-- <div class="swiper-scrollbar"></div> --}}
                        </div>


                        <div class="md:w-1/2 flex flex-col gap-4">
                            <div>{{ $product->category->name }}</div>
                            <div class="text-2xl">{{ $product->name }}</div>
                            <p>{{ $product->information }}</p>
                            <div class="flex flex-wrap items-center">
                                <div class="text-2xl">{{ number_format($product->price) }}円（税込）</div>
                                <form action="{{ route('user.cart.add') }}" method="POST" class="min-w-fit">
                                    @csrf
                                    <span>数量</span>
                                    <select name="quantity">
                                    @for ($i = 1; $i <= $maxQuantity; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    </select>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <x-form.button>カートに入れる</x-form.button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
