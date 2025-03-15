<div class="modal fade" id="addCarModalEdit" tabindex="-1" aria-labelledby="addCarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gray-50 border-b border-gray-200">
                <h5 class="modal-title text-xl font-bold text-gray-800" id="addCarModalLabel">{{ __('Edit Staff Member') }}</h5>
                <button type="button" class="close text-gray-800 hover:text-gray-600 transition-colors" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-2xl">&times;</span>
                </button>
            </div>
            <div class="modal-body p-6">
                <form id="updatetEditForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" id="car_idEdit" name="car_id" class="hidden">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="car_nameEdit" class="block text-sm font-medium text-gray-700 mb-1">Staff Name</label>
                            <input type="text" id="car_nameEdit" name="name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="imageEdit" class="block text-sm font-medium text-gray-700 mb-1">Profile Image</label>
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img id="previewImageEdit" src="{{ asset('images/default-avatar.png') }}" alt="Profile Preview" class="h-24 w-24 object-cover rounded-full">
                                </div>
                                <div class="flex-grow">
                                    <input type="file" id="imageEdit" name="image" accept="image/*" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" onchange="previewImage(this)">
                                    <p class="text-xs text-gray-500 mt-1">Upload a new image to change the current profile picture. Leave empty to keep the current image.</p>
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
