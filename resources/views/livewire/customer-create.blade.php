<div>
  <form wire:submit.prevent="post">
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model="name">
      @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
      <label for="phone" class="form-label">Phone</label>
      <input type="text" class="form-control  @error('phone') is-invalid @enderror" id="phone" wire:model="phone">
      @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
      <label for="address" class="form-label">Address</label>
      <textarea class="form-control  @error('address') is-invalid @enderror" id="address" rows="3" wire:model="address"></textarea>
      @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>