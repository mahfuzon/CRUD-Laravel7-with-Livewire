<div>
  <form action="{{route('export_pdf')}}" method="post">
    @csrf
    <div class="row g-5 align-items-center">
      <div class="col-auto">
        <label for="from" class="col-form-label">From:</label>
      </div>
      <div class="col-auto">
        <input type="date" id="from" class="form-control" wire:model='from' name="from">
      </div>
      <div class="col-auto">
        <label for="to" class="col-form-label">To:</label>
      </div>
      <div class="col-auto">
        <input type="date" id="to" class="form-control" wire:model='to' name="to">
      </div>
      <div class="col-auto">
        <input type="submit" id="submit" class="form-control btn btn-success" name="submit" value="PDF">
      </div>
    </div>
  </form>
  
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