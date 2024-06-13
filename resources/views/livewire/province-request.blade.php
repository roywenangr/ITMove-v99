<div class="col-12">
    <div class="form-floating w-100 mb-3">
        <select class="form-select" id="provinceSelect" wire:model="selectedProvince" name="province" required>
            <option value="" selected>Choose Province</option>
            @foreach ($provinces as $province)
            <option value="{{ $province->id }}">{{ $province->province_name }}</option>
            @endforeach
        </select>
        <label for="additional">Province</label>
    </div>
    <div class="form-group mb-3" >
        <label for="editProvinceId" class="form-label">Nama Destination</label>
        <select class="form-select" id="placeSelect" multiple name="place[]">
        </select>
    </div>
</div>
