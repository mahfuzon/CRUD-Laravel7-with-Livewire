<div>
    <form wire:submit.prevent="post">
        <div class="mb-3">
            <label for="cutomer_id" class="form-label">Customer Name</label>
            <select name="customer_id" id="customer_id" wire:model='customer_id' class="form-control @error('customer_id') is-invalid @enderror">
                <option value="">== Select Customer ==</option>
                @foreach ($customer as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Tanggal</label>
            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" wire:model="date">
            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="berat_ikan" class="form-label">Berat Ikan (Kg)</label>
            <input type="number" class="form-control @error('berat_ikan') is-invalid @enderror" id="berat_ikan" wire:model="berat_ikan">
            @error('berat_ikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="jlh_kantong" class="form-label">Jumlah Kantong</label>
            <input type="number" class="form-control @error('jlh_kantong') is-invalid @enderror" id="jlh_kantong" wire:model='jlh_kantong'>
            @error('jlh_kantong') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="harga_ikan" class="form-label">Harga ikan</label>
            <input type="number" class="form-control @error('harga_ikan') is-invalid @enderror" id="harga_ikan" wire:model='harga_ikan'>
            @error('harga_ikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="bayar" class="form-label">Bayar</label>
            <input type="number" class="form-control @error('bayar') is-invalid @enderror" id="bayar" wire:model='bayar'>
            @error('bayar') <div class="invalid-feedback @error('bayar') is-invalid @enderror">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="driver_id" class="form-label">Driver</label>
            <select name="driver_id" id="driver_id" class="form-control @error('driver_id') is-invalid @enderror" wire:model='driver_id'>
                <option value="">== Select Driver ==</option>
                @foreach ($driver as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            @error('driver_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>