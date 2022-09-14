<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="sm:p-6 bg-white border-b border-gray-200">

                    <section class="text-gray-600 body-font">

                        {{-- <x-flash-message status="info" message="テスト" />
                        <x-flash-message status="alert" :message='"あああ\nいいい\nううう\nえ"' /> --}}

                      <div class="container sm:px-5 py-6 mx-auto">
                        <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                          <table class="table-auto w-full text-left whitespace-no-wrap">
                            <thead>
                              <tr>
                                <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">名前</th>
                                <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">メールアドレス</th>
                                <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">作成日</th>
                                <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"></th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($owners as $owner)
                                <tr>
                                  <td class="md:px-4 py-3">{{ $owner->name }}</td>
                                  <td class="md:px-4 py-3">{{ $owner->email }}</td>
                                  <td class="md:px-4 py-3">
                                      {{ $owner->created_at->diffForHumans() }}<br>
                                      <sapn class="text-xs text-gray-400">{{ $owner->created_at }}</span>
                                  </td>
                                  <td class="sm:px-4 py-3">
                                    <x-form.button no="1" px="px-2 md:px-4" onclick="location.href='{{ route('admin.owners.edit', $owner) }}'">編集</x-button>
                                    <form action="{{ route('admin.owners.destroy', $owner) }}" id="delete_{{ $owner->id }}" method="post" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <x-form.button type="button" no="caution" px="px-2 md:px-4" onclick="deleteSubmit(this)" data-id="{{ $owner->id }}">削除</x-button>
                                    </form>
                                  </td>
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                        <div>{{ $owners->links() }}</div>
                      </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    'use strict';

    function deleteSubmit(e) {
        const id = e.dataset.id;
        const form = document.getElementById('delete_' + id);
        if (!confirm('削除してよろしいですか？')) return;
        form.submit();
    }

</script>
