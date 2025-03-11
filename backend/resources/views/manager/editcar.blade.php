

@foreach ($cardata as $car)
    <div class="modal fade" id="addCarModalEdit" tabindex="-1" aria-labelledby="addCarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCarModalLabel">{{ __('Edit Car') }}</h5>
                    <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container mt-3">
                        <h2 class="text-center">Edit Car</h2>
                        <form id="updatetEditForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="car_idEdit" name="car_id" value="{{ $car->car_id }}">
                            <div class="mb-3">
                                <label for="car_name" class="form-label">Car Name</label>
                                <input type="text" id="car_nameEdit" name="car_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="descriptions" class="form-label">Description</label>
                                <textarea id="descriptionsEdit" name="descriptions" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price_daily" class="form-label">Price Daily</label>
                                <input type="number" id="price_dailyEdit" name="price_daily" step="0.01" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Car Image</label>
                                <input type="file" id="imageEdit" name="image" accept="image/*" class="form-control">
                                @if($car->image)
                                    <img src="{{ asset($car->image) }}" alt="Current Image">
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="car_status" class="form-label">Car Status</label>
                                <select id="car_statusEdit{{ $car->car_id }}" name="car_status" class="form-select form-select-lg selectpicker" required>
                                    <option value="Available" {{ $car->car_status == 'Available' ? 'selected' : '' }}>Available</option>
                                    <option value="Maintenance" {{ $car->car_status == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="car_type_id" class="form-label">Car Type</label>
                                <select id="car_type_idEdit{{ $car->car_id }}" name="car_type_id" class="form-select form-select-lg selectpicker" data-live-search="true" required>
                                    <option value="">Select Car Type</option>
                                    @foreach ($cartypes as $carType)
                                        <option value="{{ $carType->car_type_id }}" {{ $carType->car_type_id == $car->car_type_id ? 'selected' : '' }}>
                                            {{ $carType->car_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" id="update-button" class="btn btn-primary">{{ __('Save Update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<style>
    .modal-content {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background-color: #007bff;
        color: white;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .btn-close {
        background-color: transparent;
        border: none;
        font-size: 1.5rem;
    }

    .modal-body {
        padding: 2rem;
        background-color: #f9f9f9;
    }

    .container h2 {
        margin-bottom: 1.5rem;
        color: #333;
    }

    .form-label {
        font-weight: bold;
        color: #555;
    }

    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
    }

    .mb-3 img {
        max-width: 100px;
        margin-top: 10px;
    }

    .form-select {
        border-radius: 0.5rem;
        font-size: 1rem;
    }

    .form-select:focus {
        border-color: #007bff;
    }

    .form-label {
        font-weight: bold;
        color: #333;
    }

    .modal-footer {
        border-top: 1px solid #ddd;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
    }

    .btn-primary {
        background-color: #007bff;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .selectpicker {
        border-radius: 0.5rem;
        font-size: 1rem;
    }
</style>
