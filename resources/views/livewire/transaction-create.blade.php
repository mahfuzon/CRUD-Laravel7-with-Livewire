<div>
    <form wire:submit.prevent="post">
        <div class="mb-3">
            <label for="cutomer_id" class="form-label">Customer Name</label>
            <select name="customer_id" id="customer_id" wire:model='customer_id' class="form-control">
                <option value="">== Select Customer ==</option>
                @foreach ($customer as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            @error('customer_id') <p class="error" style="color: red">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="date" wire:model="date">
            @error('date') <p class="error" style="color: red">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label for="berat_ikan" class="form-label">Berat Ikan (Kg)</label>
            <input type="number" class="form-control" id="berat_ikan" wire:model="berat_ikan">
            @error('berat_ikan') <p class="error" style="color: red">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label for="jlh_kantong" class="form-label">Jumlah Kantong</label>
            <input type="number" class="form-control" id="jlh_kantong" wire:model='jlh_kantong'>
            @error('jlh_kantong') <p class="error" style="color: red">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label for="harga_ikan" class="form-label">Harga ikan</label>
            <input type="number" class="form-control" id="harga_ikan" wire:model='harga_ikan'>
            @error('harga_ikan') <p class="error" style="color: red">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label for="bayar" class="form-label">Bayar</label>
            <input type="number" class="form-control" id="bayar" wire:model='bayar'>
            @error('bayar') <p class="error" style="color: red">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label for="driver_id" class="form-label">Driver</label>
            <select name="driver_id" id="driver_id" class="form-control" wire:model='driver_id'>
                <option value="">== Select Driver ==</option>
                @foreach ($driver as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            @error('driver_id') <p class="error" style="color: red">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>