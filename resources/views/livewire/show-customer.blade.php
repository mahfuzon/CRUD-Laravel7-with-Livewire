<div>
  <div class="row">
    <div class="col-sm-6">
      <select wire:model="index" class="custom-select col-3 mt-5">
        <option>20</option>
        <option>30</option>
        <option>50</option>
      </select>
    </div>
    <div class="col-sm-6">
      <div class="row">
        <form action="{{route('export_pdf')}}" method="post" id="export_pdf">
          @csrf
          <input type="hidden" name="id" value="{{$customer_id}}">
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
              <a style="float:right" class="btn btn-success btn-md" href="{{ route('export_pdf') }}" onclick="event.preventDefault();
            document.getElementById('export_pdf').submit();">
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

  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Tanggal Transaksi</th>
        <th>Total Berat</th>
        <th>Total Harga</th>
        <th>Bayar</th>
        <th>Hutang</th>
        <th>Action</th>
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
        <td @if ($item->hutang <= 0) style="color:green" @else style="color: red" @endif>@currency(abs($item->hutang))
        </td>
        <td>
          <i class="far fa-edit btn btn-success" wire:click="selectItem({{$item->id}}, 'edit')"></i>
          <i class="fas fa-trash-alt btn btn-danger" wire:click="selectItem({{$item->id}}, 'delete')"></i>
          <a wire:click="$emit('openModalDetailShow', {{$item->id}})" href="#" class="btn btn-warning"><i
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
  {{ $customer->links() }}


  <div class="modal fade" id="detailModalShow" tabindex="-1" aria-labelledby="detailModalShowLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailModalShowLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body modal-lg">
          @livewire('show-customer-detail')
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

{{-- MODAL FORM EDIT --}}
  <div class="modal fade" id="EditDataTransactionCustomer" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="EditDataTransactionCustomerLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="EditDataTransactionCustomerLabel">Insert Data</h5>
          <button wire:click="$emit('clearForm')" type="button" class="close" data-bs-dismiss="modal"
            aria-label="Close"> <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          @livewire('edit-customer-transaction')
        </div>
      </div>
    </div>
  </div>
{{--AKHIR MODAL FORM EDIT--}}

</div>