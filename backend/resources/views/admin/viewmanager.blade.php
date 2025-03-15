@extends('adminlte::page')

@section('content_header')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Staff Management</h1>
    </div>
@stop

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Manager ID</th>
                        <th class="py-3 px-4 text-left">Manager Name</th>
                        <th class="py-3 px-4 text-left">Email</th>
                        <th class="py-3 px-4 text-left">Profile Image</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($manager as $data)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3 px-4">{{ $data->user_id }}</td>
                            <td class="py-3 px-4">{{ $data->name }}</td>
                            <td class="py-3 px-4">{{ $data->email }}</td>
                            <td class="py-3 px-4">
                                <img src="{{ asset('storage/'.$data->image) }}" class="myImg rounded-full object-cover h-12 w-12 cursor-pointer hover:opacity-80 transition-opacity" alt="{{ $data->name }}">
                            </td>
                            <td class="py-3 px-4">
                                <div class=" space-x-2">
                                    
                                    <form action="{{ route('admin.deletemanager', ['id' => $data->user_id]) }}" method="get" class="inline">
                                        @method('DELETE')
                                        <button class="edit btn btn-primary" data-id="{{ $data->user_id }}" data-bs-toggle="modal" data-bs-target="#addCarModalEdit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            &nbsp;&nbsp;Edit&nbsp;&nbsp;
                                        </button>
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this car?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {!! $manager->links('pagination::tailwind') !!}
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="relative">
            <button onclick="closeImageModal()" class="absolute top-2 right-2 text-white bg-red-500 rounded-full p-1 hover:bg-red-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img id="modalImage" class="max-h-[80vh] max-w-[90vw] rounded-lg" src="" alt="">
        </div>
    </div>
@stop

@include('admin.editmanager')

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
    <script>
        // Image modal functionality
        const imageModal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const images = document.querySelectorAll('.myImg');
        
        images.forEach(img => {
            img.addEventListener('click', function() {
                imageModal.classList.remove('hidden');
                modalImage.src = this.src;
                modalImage.alt = this.alt;
            });
        });
        
        function closeImageModal() {
            imageModal.classList.add('hidden');
        }
        
        // Close modal when clicking outside the image
        imageModal.addEventListener('click', function(e) {
            if (e.target === imageModal) {
                closeImageModal();
            }
        });

        // Insert/edit functionality
        $(document).ready(function() {
            $(document).on("click", ".edit", function(e) {
                e.preventDefault();
                var UserID = $(this).data("id");
                console.log("id na :", UserID);

                $.ajax({
                    url: "{{ route('admin.editmanager') }}",
                    type: "GET",
                    data: {
                        user_id: UserID
                    },
                    success: function(data) {
                        console.log("data :", data.userData);
                        $('#car_idEdit').val(data.userData.user_id);
                        $('#car_nameEdit').val(data.userData.name);
                        $('#addCarModalEdit').modal('show');
                    },
                    error: function(xhr) {
                        console.error("testtt", xhr.responseText);
                    }
                });
            });
        });

        // Update functionality
        $("#updatetEditForm").on("submit", function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            console.log("Form Data:", Object.fromEntries(formData));
            $.ajax({
                url: "{{ route('admin.updatemanager') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        console.log(response.success);
                        setTimeout(function() {
                            location.reload();
                        }, 100);

                        $('#addCarModalEdit').modal('hide');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
@stop
