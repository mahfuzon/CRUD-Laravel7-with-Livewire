<div>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#InsertDataCustomer">
    Insert Data
  </button>

  <!-- Modal -->
  <div class="modal fade" id="InsertDataCustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="InsertDataCustomerLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="InsertDataCustomerLabel">Insert Data</h5>
          <button wire:click = 'clearForm' type="button" class="close" data-bs-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          @livewire('customer-create')
        </div>
      </div>
    </div>
  </div>
  <br>

<!-- Modal -->
<div class="modal fade" id="DeleteDataCustomer" tabindex="-1" aria-labelledby="DeleteDataCustomerLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="DeleteDataCustomerLabel">Delete Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3>Do you wish to continue?</h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button wire:click="delete" type="button" class="btn btn-primary">yes</button>
      </div>
    </div>
  </div>
</div>

<span> <div class="py-3">
  <select wire:model="index" class="custom-select col-1">
    <option>5</option>
    <option>10</option>
    <option>20</option>
  </select>
  <input wire:model="keyword" class="form-control col-5" style="float:right" type="text" placeholder="Search">
</div>
</span>

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
          <td>
            <button class="btn btn-success" wire:click="selectItem({{$item->id}}, 'edit')">
              Edit
            </button>
            <button class="btn btn-danger" wire:click="selectItem({{$item->id}}, 'delete')">
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