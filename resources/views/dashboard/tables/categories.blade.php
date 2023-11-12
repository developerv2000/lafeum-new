<table class="table" cellpadding="10" cellspacing="10">
    {{-- Head start --}}
    <thead>
        <tr>
            {{-- Empty space for checkbox --}}
            <th width="20"></th>

            <th>Заголовок</th>

            <th>Родитель</th>

            <th width="140">Действие</th>
        </tr>
    </thead> {{-- Head end --}}

    {{-- Body start --}}
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>@include('dashboard.table-components.checkbox')</td>
                <td>{{ $item->name }}</td>

                <td>{{ $item->parent?->name }}</td>

                <td class="table__actions">
                    <a class="table__button table__button--edit" href="{{ route($modelPrefixName . '.edit', $item->id) }}?model={{ request()->model }}" title="Редактировать">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>

{{ $items->links('dashboard.layouts.pagination') }}
