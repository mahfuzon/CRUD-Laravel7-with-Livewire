<div>
  @livewire('customer-create') 
  <br>
  <p>{{$prompt}}</p>
  @if($customer->count())
  <div>
    <table class="table table-striped">
      <thead>
        <th>No</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Address</th>
      </thead>
      <tbody>
        <?php $no = 0 ?>
        @foreach ($customer as $item)
        <?php $no++ ?>
            <tr>
              <td>{{$no}}</td>
              <td>{{$item->name}}</td>
              <td>{{$item->phone}}</td>
              <td>{{$item->address}}</td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{$customer->links()}}
  @endif
</div>