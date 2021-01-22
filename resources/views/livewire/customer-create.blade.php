<div>
  <form wire:submit.prevent="store">
    <div class="form-floating mb-3">
      <input wire:model="name" type="text" class="form-control" id="name">
      <label for="name">Name</label>
    </div>
    <div class="form-floating mb-3">
      <input wire:model="phone" type="number" class="form-control" id="phone" 3436">
      <label for="phone">Phone Number</label>
    </div>
    <div class="form-floating">
      <textarea wire:model="address" class="form-control" id="address"></textarea>
      <label for="address">Address</label>
    </div>
    <div class="modal-footer">
      <input type="submit" class="btn btn-primary" name="submit" value="submit"/>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
  </form>
</div>