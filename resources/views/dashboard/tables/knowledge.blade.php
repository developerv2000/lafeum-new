<table class="table" cellpadding="10" cellspacing="10">
    {{-- Head start --}}
    <thead>
        <tr>
            {{-- Empty space for checkbox --}}
            <th width="20"></th>

            <th width="260">
                @include('dashboard.table-components.thead-link', ['orderBy' => 'name', 'title' => 'Заголовок'])
            </th>

            <th>Описание</th>

            <th width="150">
                @include('dashboard.table-components.thead-link', ['orderBy' => 'terms_count', 'title' => 'Кол-во терминов'])
            </th>

            <th width="260">
                @include('dashboard.table-components.thead-link', ['orderBy' => 'parent_id', 'title' => 'Родитель'])
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
                <td>
                    <div class="limited-three-lines">{!! $item->description !!}</div>
                </td>

                <td>{{ $item->terms_count }}</td>

                <td>{{ $item->parent?->name }}</td>

                <td class="table__actions">
                    @include('dashboard.table-components.edit-button')
                </td>
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>

{{ $items->links('dashboard.layouts.pagination') }}
