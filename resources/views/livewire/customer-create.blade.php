<div>
  <form wire:submit.prevent="post">
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" id="name" wire:model="name">
      @error('name') <p class="error" style="color: red">{{ $message }}</p> @enderror
    </div>
    <div class="mb-3">
      <label for="phone" class="form-label">Phone</label>
      <input type="text" class="form-control" id="phone" wire:model="phone">
      @error('phone') <p class="error" style="color: red">{{ $message }}</p> @enderror
    </div>
    <div class="mb-3">
      <label for="address" class="form-label">Address</label>
      <textarea class="form-control" id="address" rows="3" wire:model="address"></textarea>
      @error('address') <p class="error" style="color: red">{{ $message }}</p> @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>