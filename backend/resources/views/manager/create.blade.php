<div class="modal fade" id="addCarModal" tabindex="-1" aria-labelledby="addCarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addCarModalLabel">{{ __('Add Car') }}</h5>
                <button type="button" class="btn-close btn btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('manager.createcar')}}" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
                    @csrf
                    <div class="mb-3">
                        <label for="car_name" class="form-label">Car Name</label>
                        <input type="text" id="car_name" name="car_name" class="form-control form-control-lg" required>
                    </div>
                    <div class="mb-3">
                        <label for="descriptions" class="form-label">Description</label>
                        <textarea id="descriptions" name="descriptions" class="form-control form-control-lg" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price_daily" class="form-label">Price Daily (KIP)</label>
                        <input type="number" id="price_daily" name="price_daily" step="0.01" class="form-control form-control-lg" required>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Car Image</label>
                        <input type="file" id="images" name="image" accept="image/*" class="form-control form-control-lg">
                    </div>
                    <div class="mb-3">
                        <label for="car_status" class="form-label">Car Status</label>
                        <select id="car_status" name="car_status" class="custom-select form-select form-select-lg" required>
                            <option value="Available">Available</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="car_type_id" class="form-label">Car Type</label>
                        <select id="car_type_id" name="car_type_id" class="custom-select form-select form-select-lg "  required>
                            <option value="">Select Car Type</option>
                            @foreach ($cartypes as $carType)
                                <option value="{{ $carType->car_type_id }}">{{ $carType->car_type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save Car') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .custom-select {
        border-radius: 0.5rem;
        border: 2px solid #007bff;
        padding: 0.75rem;
        font-size: 1rem;
    }

    .custom-select:focus {
        border-color: #0056b3;
        box-shadow: 0 0 5px rgba(24, 136, 255, 0.5);
    }

    .form-label {
        font-weight: bold;
        color: #333;
    }

    .form-select-lg {
        height: 3.25rem; 
    }
</style>
