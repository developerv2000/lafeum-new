<table class="table" cellpadding="10" cellspacing="10">
    {{-- Head start --}}
    <thead>
        <tr>
            {{-- Empty space for checkbox --}}
            <th width="20"></th>

            <th>
                @include('dashboard.table-components.thead-link', ['orderBy' => 'name', 'title' => 'Имя'])
            </th>

            <th>
                @include('dashboard.table-components.thead-link', ['orderBy' => 'email', 'title' => 'Почта'])
            </th>

            <th>Тема</th>

            <th>Сообщение</th>

            <th>
                @include('dashboard.table-components.thead-link', ['orderBy' => 'created_at', 'title' => 'Дата отправки'])
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

                <td>{{ $item->email }}</td>

                <td>
                    <div class="limited-three-lines">{{ $item->topic }}</div>
                </td>

                <td>
                    <div class="limited-three-lines">{{ $item->message }}</div>
                </td>

                <td>{{ $item->created_at }}</td>

                <td class="table__actions">
                    @if (strpos($routeName, '.dashboard.trash'))
                        @include('dashboard.table-components.restore-button')
                        @include('dashboard.table-components.destroy-button')
                    @else
                        @include('dashboard.table-components.destroy-button')
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>

{{ $items->links('dashboard.layouts.pagination') }}
