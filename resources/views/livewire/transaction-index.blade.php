<div>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#InsertDataTransaction">
    Insert Data
  </button>

  <!-- Modal -->
  <div class="modal fade" id="InsertDataTransaction" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="InsertDataTransactionLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="InsertDataTransactionLabel">Insert Data</h5>
          <button wire:click='clearForm' type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <span
              aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          @livewire('transaction-create')
        </div>
      </div>
    </div>
  </div>
  <br>

  <!-- Modal -->
  <div class="modal fade" id="DeleteDataTransaction" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="DeleteDataTransactionLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="DeleteDataTransactionLabel">Delete Data</h5>
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

  <span>
    <div class="py-3">
      <select wire:model="index" class="custom-select col-1">
        <option>5</option>
        <option>10</option>
        <option>20</option>
      </select>
      <input wire:model="keyword" class="form-control col-5" style="float:right" type="text" placeholder="Search">
    </div>
  </span>

  @if($transaction->count())
  <div>
    <table class="table table-striped">
      <thead>
        <th>No</th>
        <th>Date</th>
        <th>Customer Name</th>
        <th>Jumlah Kantong</th>
        <th>Berat Ikan</th>
        <th>Price</th>
        <th>Berat Total</th>
        <th>Total Price</th>
        <th>Bayar</th>
        <th>Driver</th>
      </thead>
      <tbody>
        <?php $no = 0 ?>
        @foreach ($transaction as $item)
        <?php $no++ ?>
        <tr>
          <td>{{$no}}</td>
          <td>{{$item->date}}</td>
          <td>{{$item->customer->name}}</td>
          <td>{{$item->jlh_kantong}}</td>
          <td>{{$item->berat_ikan}}</td>
          <td>{{$item->harga_ikan}}</td>
          <td>{{$item->total_berat}}</td>
          <td>{{$item->total_harga}}</td>
          <td>{{$item->bayar}}</td>
          <td>{{$item->driver->name}}</td>
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
  {{$transaction->links()}}
  @endif
</div>