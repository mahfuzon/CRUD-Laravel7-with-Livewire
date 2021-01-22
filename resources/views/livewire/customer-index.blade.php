<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
      Add Data
    </button>
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
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Tambahkan Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @livewire('customer-create')
        </div>
      </div>
    </div>
  </div>
</div>