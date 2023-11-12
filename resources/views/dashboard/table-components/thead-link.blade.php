<a class="{{ $params['orderType'] }} @if($params['orderBy'] == $orderBy) active @endif"
    href="{{ url()->current() . '?page=' . $params['currentPage'] . '&orderBy=' . $orderBy . '&orderType=' . $params['reversedOrderType'] }}">{{ $title }}
</a>
