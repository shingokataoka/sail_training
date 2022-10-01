@php
    if ($name === 'image1') { $no = 1; $modal = 'modal-1'; }
    elseif ($name === 'image2') { $no = 2; $modal = 'modal-2'; }
    elseif ($name === 'image3') { $no = 3; $modal = 'modal-3'; }
    elseif ($name === 'image4') { $no = 4; $modal = 'modal-4'; }

    $imageSrc = (empty($filename))? '' :url("storage/products/{$filename}");
    $imageValue = $value ?? '';
@endphp



<div class="modal micromodal-slide" id="{{ $modal }}" aria-hidden="true">
    <div class="z-50 modal__overlay" tabindex="-1" data-micromodal-close>
      <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="{{ $modal }}-title">
        <header class="modal__header">
          <h2 class="modal__title" id="{{ $modal }}-title">
            画像{{ $no }}を選択
          </h2>
          <button type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
        </header>
        <main class="modal__content" id="{{ $modal }}-content">
            <div class="flex flex-wrap">
            @foreach ($images as $image)
                <div class="px-2 py-4 w-1/3 md:w-1/4">
                    <div class="block border rounded-md p-4">
                        <img
                            src="{{ (empty($image->filename))? '' : url("storage/products/{$image->filename}") }}"
                            class="select-image"
                            data-name="{{ $name }}"
                            data-id="{{ $image->id }}"
                            />
                        <div class="mt-4">{{ $image->title }}</div>
                    </div>
                </div>
            @endforeach
            </div>
        </main>
        <footer class="modal__footer">
          <button id="{{ $name }}_close" type="button" class="modal__btn" data-micromodal-close aria-label="Close this dialog window">閉じる</button>
        </footer>
      </div>
    </div>
  </div>

  <div class="flex justify-between items-center bg-gray-200 p-6 rounded-md">
        <x-form.button type="button" no="3" px="px-8" data-micromodal-trigger="{{ $modal }}">画像{{ $no }}を選択</x-form.button>
        <img id="{{ $name }}_thumbnail" src="{{ $imageSrc }}" class="w-24" />
        <input id="{{ $name }}_hidden" type="hidden" name="{{ $name }}" value="{{ $imageValue }}">
  </div>
