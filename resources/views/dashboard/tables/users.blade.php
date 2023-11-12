<table class="table" cellpadding="10" cellspacing="10">
    {{-- Head start --}}
    <thead>
        <tr>
            {{-- Empty space for checkbox --}}
            <th width="20"></th>

            <th width="130">Фото</th>

            <th>
                @include('dashboard.table-components.thead-link', ['orderBy' => 'name', 'title' => 'Имя'])
            </th>

            <th>
                @include('dashboard.table-components.thead-link', ['orderBy' => 'email', 'title' => 'Почта'])
            </th>

            <th>
                @include('dashboard.table-components.thead-link', ['orderBy' => 'birthday', 'title' => 'День рождения'])
            </th>

            <th>
                @include('dashboard.table-components.thead-link', ['orderBy' => 'email_verified_at', 'title' => 'Дата подтв/почты'])
            </th>

            <th>Бигорафия</th>

            <th width="140">Действие</th>
        </tr>
    </thead> {{-- Head end --}}

    {{-- Body start --}}
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>@include('dashboard.table-components.checkbox')</td>

                <td><img src="{{ asset('img/users/' . $item->photo) }}"></td>

                <td>{{ $item->name }}</td>

                <td>{{ $item->email }}</td>

                <td>{{ $item->birthday }}</td>

                <td>{{ $item->email_verified_at }}</td>

                <td>{{ $item->biography }}</td>

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
