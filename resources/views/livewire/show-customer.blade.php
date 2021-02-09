<div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal Transaksi</th>
                <th>Total Berat</th>
                <th>Total Harga</th>
                <th>Bayar</th>
                <th>Hutang</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1
            @endphp
            @foreach ($customer as $item)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$item->date}}</td>
                    <td>{{$item->total_berat}}</td>
                    <td>{{$item->total_harga}}</td>
                    <td>{{$item->bayar}}</td>
                    <td>{{$item->hutang}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $customer->links() }}
</div>
