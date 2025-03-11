
    <div class="modal fade" id="addCarModalEdit" tabindex="-1" aria-labelledby="addCarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCarModalLabel">{{ __('Edit cus') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container mt-3">
                        <h2 class="text-center">Edit manager</h2>
                        <form id="updatetEditForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input  type="text" id="cus_id" name="cus_id"  readonly class="form-control">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" required >
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Surname</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" required >
                            </div>
                            <div class="mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="text" id="age" name="age" class="form-control" required >
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">phone number</label>
                                <input type="text" id="phone_number" name="phone_number" class="form-control" required >
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">email</label>
                                <input type="text" id="email" name="email" class="form-control" required >
                            </div>
                            <div class="mb-3">
                                <label for="zipcode" class="form-label">zipcode</label>
                                <input type="text" id="zipcode" name="zipcode" class="form-control" required >
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">address</label>
                                <input type="text" id="address" name="address" class="form-control" required >
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">city</label>
                                <input type="text" id="city" name="city" class="form-control" required >
                            </div>
                            <div class="mb-3">
                                <label for="country" class="form-label">country</label>
                                <input type="text" id="country" name="country" class="form-control" required >
                            </div>

                            <div class="mb-3">
                                <label for="images" class="form-label">Cus Image</label>
                                <input type="file" id="image" name="image" accept="image/*" class="form-control">
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

