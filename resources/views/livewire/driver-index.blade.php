<div>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahDriver">
    Insert Data
  </button>

  <!-- Modal -->
  <div class="modal fade" id="modalTambahDriver" tabindex="-1" role="dialog" aria-labelledby="modalTambahDriverLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahDriverLabel">Tambah Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @livewire('driver-create')
        </div>
      </div>
    </div>
  </div>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Phone</th>
      </tr>
    </thead>
    <tbody>
      @php
      $i = 0
      @endphp
      @foreach ($driver as $item)
      @php
      $i++
      @endphp
      <tr>
        <td scop="row">{{$i}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->phone}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>