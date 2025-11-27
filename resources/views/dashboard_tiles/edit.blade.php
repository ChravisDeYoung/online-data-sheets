<x-layout>
    <x-form.wrapper>
        <x-slot name="title">
            Update dashboard tile: <span
                class=" text-blue-600 dark:text-blue-600">{{ $dashboardTile->title }}</span>
        </x-slot>

        <form action="{{ route('dashboard-tiles.update', $dashboardTile) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="w-full">
                    <x-form.input name="title" type="text" :value="old('title', $dashboardTile->title)" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="sort_order" type="number" :value="old('sort_order', $dashboardTile->sort_order)"
                                  required/>
                </div>

                <x-form.select name="page_id">
                    <option value="" @if(old('page_id', $dashboardTile->page_id) == '') selected @endif>None</option>

                    @foreach ($pages as $page)
                        <option value="{{ $page->id }}"
                                @if(old('page_id', $dashboardTile->page_id) == $page->id) selected @endif>
                            {{ $page->name }}
                        </option>
                    @endforeach
                </x-form.select>

                <x-form.select name="parent_dashboard_tile_id">
                    <option value=""
                            @if(old('parent_dashboard_tile_id', $dashboardTile->parent_dashboard_tile_id) == '') selected @endif>
                        None
                    </option>

                    @foreach ($dashboardTiles as $tile)
                        <option value="{{ $tile->id }}"
                                @if(old('parent_dashboard_tile_id', $dashboardTile->parent_dashboard_tile_id) == $tile->id) selected @endif>
                            {{ $tile->title }}
                        </option>
                    @endforeach
                </x-form.select>
            </div>

            <div class="mt-4 sm:mt-6 text-right">
                <x-form.button href="{{ route('dashboard-tiles.index') }}" variant="secondary">Cancel
                </x-form.button>
                <x-form.button class="ml-2 sm:ml-3">Add dashboard tile</x-form.button>
            </div>
        </form>
    </x-form.wrapper>
</x-layout>

