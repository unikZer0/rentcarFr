@extends('adminlte::page')

@section('title', 'Car Management')

@section('content_header')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Car Management</h1>

    </div>
@stop

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Car By</th>
                        <th class="py-3 px-4 text-left">Car ID</th>
                        <th class="py-3 px-4 text-left">Car Name</th>
                        <th class="py-3 px-4 text-left">Car Type</th>
                        <th class="py-3 px-4 text-left">Description</th>
                        <th class="py-3 px-4 text-left">Price</th>
                        <th class="py-3 px-4 text-left">Image</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($cardata as $data)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3 px-4">{{$data->user->name}}</td>
                            <td class="py-3 px-4">{{ $data->car_id }}</td>
                            <td class="py-3 px-4">{{ $data->car_name }}</td>
                            <td class="py-3 px-4">{{ $data->carType->car_type_name }}</td>
                            <td class="py-3 px-4 max-w-xs truncate">{{ $data->descriptions }}</td>
                            <td class="py-3 px-4 font-medium text-green-600">{{ number_format($data->price_daily, 0) }} KIP</td>
                            <td class="py-3 px-4">
                                <img src="{{ asset($data->image) }}" class="myImg rounded-lg object-cover h-16 w-24 cursor-pointer hover:opacity-80 transition-opacity" alt="{{ $data->car_name }}">
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    if($data->car_status == 'available') {
                                        $statusClass = 'bg-green-100 text-green-800';
                                    } elseif($data->car_status == 'rented') {
                                        $statusClass = 'bg-blue-100 text-blue-800';
                                    } elseif($data->car_status == 'maintenance') {
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                    } elseif($data->car_status == 'out_of_service') {
                                        $statusClass = 'bg-red-100 text-red-800';
                                    }
                                @endphp
                                <span class="{{ $statusClass }} text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $data->car_status }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                            
                                    <form action="{{ route('admin.deletecar', ['id' => $data->car_id]) }}" method="get" class="inline">
                                        @method('DELETE')
                                        <button class="edit btn btn-primary" data-id="{{ $data->car_id }}" data-bs-toggle="modal" data-bs-target="#addCarModalEdit">
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
            {!! $cardata->links('pagination::tailwind') !!}
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
            <img id="modalImage" class="max-h-[50vh] max-w-[60vw] rounded-lg" src="" alt="">
        </div>
    </div>
@stop

@include('admin.editcar')

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

        // Edit car functionality
        $(document).on("click", ".edit", function(e) {
            e.preventDefault();
            var carID = $(this).data("id");
            console.log(carID);

            $.ajax({
                url: "{{ route('admin.editcar') }}",
                type: "GET",
                data: {
                    car_id: carID
                },
                success: function(data) {
                    console.log(data.carData);
                    $('#car_nameEdit').val(data.carData.car_name);
                    $('#descriptionsEdit').val(data.carData.descriptions);
                    $('#price_dailyEdit').val(data.carData.price_daily);
                    $('#car_type_idEdit' + data.carData.car_id).val(data.carData.car_type_id).selectpicker('refresh');
                    $('#car_statusEdit' + data.carData.car_id).val(data.carData.car_status).selectpicker('refresh');
                    $('#car_idEdit').val(data.carData.car_id);
                    $('#addCarModalEdit').modal('show');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Update car functionality
        $("#updatetEditForm").on("submit", function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('admin.updatecar') }}",
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
    <style>
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
            display: inline-flex;
            align-items: center;
            margin-right: 0.5rem;
        }
        
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
            display: inline-flex;
            align-items: center;
        }
        
        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        
        .btn-danger:hover {
            background-color: #bb2d3b;
            border-color: #b02a37;
        }
    </style>
@stop
