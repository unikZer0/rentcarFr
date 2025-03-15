@foreach ($cardata as $car)
    <div class="modal fade" id="addCarModalEdit" tabindex="-1" aria-labelledby="addCarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gray-50 border-b border-gray-200">
                    <h5 class="modal-title text-xl font-bold text-gray-800" id="addCarModalLabel">{{ __('Edit Car') }}</h5>
                    <button type="button" class="close text-gray-800 hover:text-gray-600 transition-colors" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-2xl">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-6">
                    <form id="updatetEditForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" id="car_idEdit" name="car_id" value="{{ $car->car_id }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="car_nameEdit" class="block text-sm font-medium text-gray-700 mb-1">Car Name</label>
                                <input type="text" id="car_nameEdit" name="car_name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            </div>
                            
                            <div>
                                <label for="price_dailyEdit" class="block text-sm font-medium text-gray-700 mb-1">Price Daily (KIP)</label>
                                <input type="number" id="price_dailyEdit" name="price_daily" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="descriptionsEdit" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="descriptionsEdit" name="descriptions" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" rows="4" required></textarea>
                            </div>
                            
                            <div>
                                <label for="car_statusEdit{{ $car->car_id }}" class="block text-sm font-medium text-gray-700 mb-1">Car Status</label>
                                <select id="car_statusEdit{{ $car->car_id }}" name="car_status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 selectpicker" required>
                                    <option value="available" {{ $car->car_status == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="rented" {{ $car->car_status == 'rented' ? 'selected' : '' }}>Rented</option>
                                    <option value="maintenance" {{ $car->car_status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="out_of_service" {{ $car->car_status == 'out_of_service' ? 'selected' : '' }}>Out of Service</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="car_type_idEdit{{ $car->car_id }}" class="block text-sm font-medium text-gray-700 mb-1">Car Type</label>
                                <select id="car_type_idEdit{{ $car->car_id }}" name="car_type_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 selectpicker" data-live-search="true" required>
                                    <option value="">Select Car Type</option>
                                    @foreach ($cartypes as $carType)
                                        <option value="{{ $carType->car_type_id }}" {{ $carType->car_type_id == $car->car_type_id ? 'selected' : '' }}>
                                            {{ $carType->car_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="imageEdit" class="block text-sm font-medium text-gray-700 mb-1">Car Image</label>
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img id="previewImageEdit" src="{{ asset($car->image) }}" alt="Car Preview" class="h-24 w-32 object-cover rounded-lg">
                                    </div>
                                    <div class="flex-grow">
                                        <input type="file" id="imageEdit" name="image" accept="image/*" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" onchange="previewImage(this)">
                                        <p class="text-xs text-gray-500 mt-1">Upload a new image to change the current one. Leave empty to keep the current image.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" id="update-button" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">{{ __('Save Changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('previewImageEdit').src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
