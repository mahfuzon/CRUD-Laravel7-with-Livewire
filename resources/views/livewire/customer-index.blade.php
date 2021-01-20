<div>
    <ul>
        @foreach ($customer as $item)
            <li>{{$item->address}}</li>
        @endforeach
    </ul>
</div>
