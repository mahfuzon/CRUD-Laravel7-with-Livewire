<div>
    <form wire:submit.prevent="post">
        <div>
            @if (session()->has('hari_sama'))
                <div class="alert alert-danger">
                    {{ session('hari_sama') }}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="customer_id">Customer name:</label>
                <select name="customer_id" id="customer_id" wire:model='customer_id' class="form-control @error('customer_id') is-invalid @enderror">
                    <option value="">== Select Customer ==</option>
                    @foreach ($customer as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col mb-3">
                <label for="driver_id">Driver name:</label>
                <select name="driver_id" id="driver_id" class="form-control @error('driver_id') is-invalid @enderror" wire:model='driver_id'>
                    <option value="">== Select Driver ==</option>
                    @foreach ($driver as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                @error('driver_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="date">Transaction date:</label>
            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" wire:model="date">
            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="berat_ikan">Berat ikan (Kg):</label>
                <input type="number" class="form-control @error('berat_ikan') is-invalid @enderror" id="berat_ikan" wire:model="berat_ikan" placeholder="Berat Ikan (Kg)">
                @error('berat_ikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col mb-3">
                <label for="jlh_kantong">Jumlah kantong:</label>
                <input type="number" class="form-control @error('jlh_kantong') is-invalid @enderror" id="jlh_kantong" wire:model='jlh_kantong' placeholder="Jumlah Kantong">
                @error('jlh_kantong') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="row ">
            <div class="col mb-3">
                <label for="harga_ikan">Harga ikan/Kg:</label>
                <input type="number" class="form-control @error('harga_ikan') is-invalid @enderror" id="harga_ikan" wire:model='harga_ikan' placeholder="Harga Ikan">
                @error('harga_ikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col mb-3">
                <label for="bayar">Bayar:</label>
                <input type="number" class="form-control @error('bayar') is-invalid @enderror" id="bayar" wire:model='bayar' placeholder="Bayar">
                @error('bayar') <div class="invalid-feedback @error('bayar') is-invalid @enderror">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan:</label>
            <textarea name="keterangan" id="keterangan" cols="10" rows="3"  class="form-control @error('keterangan') is-invalid @enderror" wire:model="keterangan" ></textarea>
            @error('keterangan') <div class="invalid-feedback @error('keterangan') is-invalid @enderror">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>