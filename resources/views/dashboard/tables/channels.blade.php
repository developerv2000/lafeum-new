<table class="table" cellpadding="10" cellspacing="10">
    {{-- Head start --}}
    <thead>
        <tr>
            {{-- Empty space for checkbox --}}
            <th width="20"></th>

            <th width="300">
                @include('dashboard.table-components.thead-link', ['orderBy' => 'name', 'title' => 'Имя'])
            </th>

            <th>Описание</th>

            <th>
                @include('dashboard.table-components.thead-link', ['orderBy' => 'videos_count', 'title' => 'Кол-во видео'])
            </th>

            <th width="140">Действие</th>
        </tr>
    </thead> {{-- Head end --}}

    {{-- Body start --}}
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>@include('dashboard.table-components.checkbox')</td>

                <td>{{ $item->name }}</td>

                <td><div class="limited-three-lines">{!! $item->description !!}</div></td>

                <td>{{ $item->videos_count }}</td>

                <td class="table__actions">
                    @if (strpos($routeName, '.dashboard.trash'))
                        @include('dashboard.table-components.restore-button')
                        @include('dashboard.table-components.destroy-button')
                    @else
                        @include('dashboard.table-components.view-button', ['viewButtonKey' => 'slug'])
                        @include('dashboard.table-components.edit-button')
                        @include('dashboard.table-components.destroy-button')
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>

{{ $items->links('dashboard.layouts.pagination') }}
