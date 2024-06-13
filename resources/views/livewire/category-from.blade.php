<div class="form-group mb-3">
    <label for="category" class="form-label">Category</label>
    <select class="form-select" multiple id="category" name="category[]" required>
        @foreach ($categories as $categorie)
            <option value="{{ $categorie->id }}">{{ $categorie->category_name }}</option>
        @endforeach
    </select>
</div>
