<div class="form-floating mb-3 me-1">
    <label for="provinceSelect">Provinsi</label>
    <select class="form-select" id="provinceSelectEdit" wire:model="selectedProvince" name="province" required>
        <option value="" selected>Choose Province</option>
        @foreach ($provinces as $province)
        <option value="{{ $province->id }}">{{ $province->province_name }}</option>
        @endforeach
    </select>
</div>
