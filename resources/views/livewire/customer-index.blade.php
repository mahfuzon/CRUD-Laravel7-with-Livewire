<div>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#InsertData">
    Insert Data
  </button>

  <!-- Modal -->
  <div class="modal fade" id="InsertData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="InsertDataLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="InsertDataLabel">Insert Data</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          @livewire('customer-create')
        </div>
      </div>
    </div>
  </div>
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
        <th>Action</th>
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
          <td><button class="btn btn-danger" wire:click="delete({{$item->id}})">
              Delete
            </button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{$customer->links()}}
  @endif
</div>