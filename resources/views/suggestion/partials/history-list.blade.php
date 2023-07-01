@if ($histories->count())
<div class="relative overflow-x-auto mt-4">
    <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
                <th scope="col" class="px-6 py-3">
                    {{ __('Key') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('Actions') }}
                </th>
            </tr>
        </thead>
        <tbody x-data="{ items: [] }">
            @foreach($histories as $history)
            <tr class="bg-white border-b">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $history->key }}</td>
                <td class="px-6 py-4">
                    <button wire:click="export({{$history->id}})" type="button" class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 rounded text-xs px-2 py-2.5 text-center inline-flex items-center mr-2 mb-2">
                        <svg class="w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 6V2a.97.97 0 0 0-.933-1H5.828a2 2 0 0 0-1.414.586L1.586 4.414A2 2 0 0 0 1 5.828V18a.969.969 0 0 0 .933 1H14a1 1 0 0 0 1-1M6 1v4a1 1 0 0 1-1 1H1m6 6h9m-1.939-2.768L16.828 12l-2.767 2.768"/>
                        </svg>
                    </button>
                    <button data-modal-target="show-history-modal-{{ $history->id }}" data-modal-toggle="show-history-modal-{{ $history->id }}" type="button" class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 rounded text-xs px-2 py-2.5 text-center inline-flex items-center mr-2 mb-2">
                        <svg class="w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 14">
                            <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            <path d="M10 13c4.97 0 9-2.686 9-6s-4.03-6-9-6-9 2.686-9 6 4.03 6 9 6Z"/>
                            </g>
                        </svg>
                    </button>
                </td>
            </tr>
            <!-- Main modal -->
            <div id="show-history-modal-{{ $history->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="show-history-modal-{{ $history->id }}">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <!-- Modal body -->
                        <div class="p-6 space-y-6">
                            @if (count($history->items) > 0)
                                <ul>
                                    @foreach ($history->items as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $histories->links() }}</div>
</div>
@else
    <p class="text-2xl text-center py-10">{{ __('Your history is empty!') }}</p>
@endif