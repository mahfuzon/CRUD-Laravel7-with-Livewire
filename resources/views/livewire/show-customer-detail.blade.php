<div>
    <div>
        <div class="row">
          <label class="col-sm-4 col-form-label">Tanggal transaksi</label>
          <div class="col-sm-8">
            <p class="form-control-plaintext">: {{$date}}</p>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-4 col-form-label">Nama Customer</label>
          <div class="col-sm-8">
            <p class="form-control-plaintext">: {{$customer}}</p>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-4 col-form-label">Berat ikan</label>
          <div class="col-sm-8">
            <p class="form-control-plaintext">: {{$berat_ikan}} Kg</p>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-4 col-form-label">Jumlah Kantong</label>
          <div class="col-sm-8">
            <p class="form-control-plaintext">: {{$jlh_kantong}} Kantong</p>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-4 col-form-label">Harga ikan</label>
          <div class="col-sm-8">
            <p class="form-control-plaintext">: @currency($harga_ikan)</p>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-4 col-form-label">Total berat</label>
          <div class="col-sm-8">
            <p class="form-control-plaintext">: {{$total_berat}} Kg</p>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-4 col-form-label">Total harga</label>
          <div class="col-sm-8">
            <p class="form-control-plaintext">: @currency($total_harga)</p>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-4 col-form-label">Bayar</label>
          <div class="col-sm-8">
            <p class="form-control-plaintext">: @currency($bayar)</p>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-4 col-form-label">Keterangan</label>
          <div class="col-sm-8">
            <p class="form-control-plaintext">: {{$keterangan}}</p>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-4 col-form-label">Hutang</label>
          <div class="col-sm-8">
            <p class="form-control-plaintext" @if ($hutang < 0) style="color:green"@else style="color: red"  @endif>: @currency(abs($hutang))</p>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-4 col-form-label">Driver</label>
          <div class="col-sm-8">
            <p class="form-control-plaintext">: {{$driver}}</p>
          </div>
        </div>
      </div>
</div>
