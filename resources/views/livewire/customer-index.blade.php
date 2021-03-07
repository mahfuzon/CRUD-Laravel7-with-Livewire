<div>
  <!-- Button trigger modal -->
  <i class="far fa-plus-square btn btn-primary" data-bs-toggle="modal" data-bs-target="#InsertDataCustomer"> Insert Data</i>

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
<div class="modal fade" id="DeleteDataCustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="DeleteDataCustomerLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="DeleteDataCustomerLabel">Delete Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4>Do you wish to continue?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button wire:click='delete' type="button" class="btn btn-primary">Yes</button>
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
@if (session()->has('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif
  <div>
    <table class="table table-striped">
      <thead>
        <th>No</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Action</th>
      </thead>
      @if($customer->count())
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
            <i class="far fa-edit btn btn-success" wire:click="selectItem({{$item->id}}, 'edit')"></i>
            <i class="fas fa-trash-alt btn btn-danger"  wire:click="selectItem({{$item->id}}, 'delete')"></i>
          </td>
        </tr>
        @endforeach
      </tbody>
      @else
      <tbody>
        <tr>
          <td colspan="10">
            <h3>
              <center>Data Not Found</center>
            </h3>
          </td>
        </tr>
      </tbody>
      @endif
    </table>
  </div>
  {{$customer->links()}}
</div>