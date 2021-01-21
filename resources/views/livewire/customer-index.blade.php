<div>
  @livewire('customer-create', ['customers' => $customers])
  <hr>
  <table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Phone</th>
        <th scope="col">Address</th>
        <th scope="col" width="150"></th>
      </tr>
    </thead>
    <tbody>
      <?php $no=0; ?>
      @foreach ($customers as $item)
      <?php $no++ ?>
      <tr>
        <th scope="row">{{$no}}</th>
        <td>{{$item->name}}</td>
        <td>{{$item->phone}}</td>
        <td>{{$item->address}}</td>
        <td>
          <button class="btn btn-sm btn-info text-white">Edit</button>
          <button class="btn btn-sm btn-danger text-white">Edit</button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>