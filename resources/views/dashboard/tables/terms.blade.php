<table class="table" cellpadding="10" cellspacing="10">
    {{-- Head start --}}
    <thead>
        <tr>
            {{-- Empty space for checkbox --}}
            <th width="20"></th>

            <th width="200">
                @include('dashboard.table-components.thead-link', ['orderBy' => 'name', 'title' => 'Заголовок'])
            </th>

            <th>
                @include('dashboard.table-components.thead-link', ['orderBy' => 'body', 'title' => 'Термин'])
            </th>

            <th width="200">
                @include('dashboard.table-components.thead-link', ['orderBy' => 'type', 'title' => 'Тип'])
            </th>

            <th width="200">Категории</th>
            <th width="200">Область знаний</th>

            <th width="140">Отобр/словаре</th>

            <th width="170">
                @include('dashboard.table-components.thead-link', ['orderBy' => 'publish_at', 'title' => 'Опубликовано'])
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
                    <div class="limited-three-lines">{!! $item->body !!}</div>
                </td>
                <td>{{ $item->type }}</td>

                <td>
                    @foreach ($item->categories as $category)
                        {{ $category->name }}<br>
                    @endforeach
                </td>

                <td>
                    @foreach ($item->knowledges as $category)
                        {{ $category->name }}<br>
                    @endforeach
                </td>

                <td>{{ $item->show_in_vocabulary ? 'Да' : 'Нет' }}</td>
                <td>{{ $item->publish_at }}</td>

                <td class="table__actions">
                    @if (strpos($routeName, '.dashboard.trash'))
                        @include('dashboard.table-components.restore-button')
                        @include('dashboard.table-components.destroy-button')
                    @else
                        @include('dashboard.table-components.view-button', ['viewButtonKey' => 'id'])
                        @include('dashboard.table-components.edit-button')
                        @include('dashboard.table-components.destroy-button')
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>

{{ $items->links('dashboard.layouts.pagination') }}
