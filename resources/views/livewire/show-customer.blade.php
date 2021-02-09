<div>
  <span>
    <div class="py-3">
      <select wire:model="index" class="custom-select col-1">
        <option>5</option>
        <option>10</option>
        <option>20</option>
      </select>
    </div>
  </span>
  <form action="{{route('export_pdf')}}" method="post">
    @csrf
    <div class="row g-5 align-items-center">
      <input type="hidden" name="id" value="{{$customer_id}}">
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
    @if($customer->count())
    <tbody>
      @php
      $i = 1
      @endphp
      @foreach ($customer as $item)
      <tr>
        <td>{{$i++}}</td>
        <td>{{$item->date->format('d-M-y')}}</td>
        <td>{{$item->total_berat}} Kg</td>
        <td>@currency($item->total_harga)</td>
        <td>@currency($item->bayar)</td>  
        <td @if ($item->hutang < 0) style="color:green"@else style="color: red"  @endif>@currency(abs($item->hutang))</td>
      </tr>
      @endforeach
    </tbody>
    @else
    <tbody>
      <tr>
        <td colspan="10">
          <h3><center>Data Not Found</center></h3>
        </td>
      </tr>
    </tbody>
    @endif
  </table>
  {{ $customer->links() }}
</div>