<div>
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

  <!-- Modal DELETE DATA -->
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
  {{-- END --}}


  <div class="row">
    <div class="col-sm-6">
      <!-- Button trigger modal -->
      <i class="far fa-plus-square btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#InsertDataTransaction">
        Insert Data</i>
      <select wire:model="index" class="custom-select col-3 mt-5 ml-5">
        <option>20</option>
        <option>30</option>
        <option>50</option>
      </select>
    </div>
    <div class="col-sm-6">
      <div class="row">
        <form action="{{route('export')}}" method="post" id="export_all">
          @csrf
          <div class="row mb-3">
            <label for="from" class="col-sm-2 col-form-label">From</label>
            <div class="col-sm-10">
              <input type="date" id="from" class="form-control" wire:model='from' name="from">
            </div>
          </div>
          <div class="row mb-3">
            <label for="to" class="col-sm-2 col-form-label">To</label>
            <div class="col-sm-10">
              <input type="date" id="to" class="form-control" wire:model='to' name="to">
            </div>
          </div>
          <div class="row mb-3">
            <span>
              <a style="float:right" class="btn btn-success btn-md" href="{{ route('export') }}" onclick="event.preventDefault();
            document.getElementById('export_all').submit();">
                <i class="fas fa-file-download"></i> PDF
              </a>
              <a style="float:right" class="btn btn-secondary btn-md mr-2" wire:click="resetInput">
                <i class="fas fa-sync"></i> Reset
              </a>
            </span>
          </div>
        </form>
      </div>
    </div>
  </div>


  @if (session()->has('message'))
  <div class="alert alert-success">
    {{ session('message') }}
  </div>
  @endif

  <div>
    <table class="table table-striped">
      <thead>
        <th>No</th>
        <th>Date</th>
        <th>Customer Name</th>
        <th>Berat Total</th>
        <th>Total Harga</th>
        <th>Bayar</th>
        <th>Saldo</th>
        <th>Driver</th>
        <th>Action</th>
      </thead>
      @if($transaction->count())
      <tbody>
        <?php $no = 0 ?>
        @foreach ($transaction as $item)
        <?php $no++ ?>
        <tr>
          <td>{{$no}}</td>
          <td>{{$item->date->format('d-M-y')}}</td>
          <td>@if($item->customer)<a href="/customer/{{ucwords($item->customer->id)}}">{{$item->customer->name}}</a>@else <span style="font-style: italic">Null</span> @endif</td>
          <td>{{$item->total_berat}} Kg</td>
          <td>@currency($item->total_harga)</td>
          <td>@currency($item->bayar)</td>
          <td @if ($item->hutang <= 0) style="color:green" @else style="color: red" @endif>@currency(abs($item->hutang))
          </td>
          <td>@if($item->driver){{$item->driver->name}}@else <span style="font-style: italic">Null</span> @endif</td>
          <td>
            <i class="far fa-edit btn btn-success" wire:click="selectItem({{$item->id}}, 'edit')"></i>
            <i class="fas fa-trash-alt btn btn-danger" wire:click="selectItem({{$item->id}}, 'delete')"></i>
            <a wire:click="$emit('openModalDetail', {{$item->id}})" href="#" class="btn btn-warning"><i
                class="fas fa-info-circle"></i></a>
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
  {{$transaction->links()}}
  <hr>

  <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body modal-lg">
          @livewire('detail-modal')
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</div>