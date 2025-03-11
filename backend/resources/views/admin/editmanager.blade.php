
    <div class="modal fade" id="addCarModalEdit" tabindex="-1" aria-labelledby="addCarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCarModalLabel">{{ __('Edit Car') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container mt-3">
                        <h2 class="text-center">Edit manager</h2>
                        <form id="updatetEditForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" id="car_idEdit" name="car_id" readonly class="form-control">
                            <div class="mb-3">
                                <label for="car_name" class="form-label">user Name</label>
                                <input type="text" id="car_nameEdit" name="name" class="form-control" required >
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Car Image</label>
                                <input type="file" id="imageEdit" name="image" accept="image/*" class="form-control">
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
