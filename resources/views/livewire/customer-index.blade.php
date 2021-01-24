<div>
  <button type="button" class="btn btn-success text-bold" data-toggle="modal" data-target="#TambahData">
    Insert Data
  </button>
  <hr>
  <div wire:ignore.self class="modal fade" id="TambahData" tabindex="-1" role="dialog" aria-labelledby="TambahDataLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="TambahDataLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <Form wire:submit.prevent="store">
            <div class="form-group">
              <label for="name">Name</label>
              <input wire:model="name" type="text" class="form-control " id="name" placeholder="Enter Name">
              @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <label for="phone">phone</label>
              <input wire:model="phone" type="number" class="form-control " id="phone" placeholder="Enter phone number">
              @error('phone')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <textarea wire:model="address" class="form-control " id="address" rows="3"></textarea>
              @error('address')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </Form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" wire:click="store">save</button>
        </div>
      </div>
    </div>
  </div>

  @if (session()->has('message'))
      <div class="alert alert-success">{{session('message')}}</div>
  @endif

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