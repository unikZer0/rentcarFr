@extends('adminlte::page')

@section('title', 'Car Management')

@section('content_header')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Car Management</h1>
        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-300 flex items-center" data-bs-toggle="modal" data-bs-target="#addCarModal">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add New Car
        </button>
    </div>
@stop


@section('content')
<div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Car ID</th>
                    <th class="py-3 px-4 text-left">Car Name</th>
                    <th class="py-3 px-4 text-left">Car Type</th>
                    <th class="py-3 px-4 text-left">Description</th>
                    <th class="py-3 px-4 text-left">Price (Daily)</th>
                    <th class="py-3 px-4 text-left">Image</th>
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($cardata as $data)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-3 px-4">{{ $data->car_id }}</td>
                        <td class="py-3 px-4">{{ $data->car_name }}</td>
                        <td class="py-3 px-4">{{ $data->carType->car_type_name }}</td>
                        <td class="py-3 px-4 max-w-xs truncate">{{ $data->descriptions }}</td>
                        <td class="py-3 px-4 font-medium text-green-600">{{ number_format($data->price_daily, 2) }} KIP</td>
                        <td class="py-3 px-4">
                            <img src="{{ asset($data->image) }}" class="myImg rounded-lg object-cover h-16 w-24 cursor-pointer hover:opacity-80 transition-opacity" alt="{{ $data->car_name }}">
                        </td>
                        <td class="py-3 px-4">
                            @php
                                $statusClass = 'bg-gray-100 text-gray-800';
                                if($data->car_status == 'Available') {
                                    $statusClass = 'bg-green-100 text-green-800';
                                } elseif($data->car_status == 'Maintenance') {
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                } elseif($data->car_status == 'Rented') {
                                    $statusClass = 'bg-blue-100 text-blue-800';
                                } elseif($data->car_status == 'Out of Service') {
                                    $statusClass = 'bg-red-100 text-red-800';
                                }
                            @endphp
                            <span class="{{ $statusClass }} text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $data->car_status }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex space-x-2">
                                <button class="edit bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg transition-colors duration-300 flex items-center text-sm" data-id="{{ $data->car_id }}" data-bs-toggle="modal" data-bs-target="#addCarModalEdit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </button>
                                <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg transition-colors duration-300 flex items-center text-sm" onclick="confirmDelete('{{ route('manager.deletecar', ['id' => $data->car_id]) }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
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

@include('manager.create')
@stop
@include('manager.editcar')
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        // Sweet alert for delete confirmation
        function confirmDelete(deleteUrl) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        }

        // Edit car functionality
        $(document).on("click", ".edit", function(e) {
            e.preventDefault();
            var carID = $(this).data("id");
            console.log(carID);

            $.ajax({
                url: "{{ route('manager.editcar') }}",
                type: "GET",
                data: {
                    car_id: carID
                },
                success: function(data) {
                    console.log(data.carData);
                    $('#car_nameEdit').val(data.carData.car_name);
                    $('#descriptionsEdit').val(data.carData.descriptions);
                    $('#price_dailyEdit').val(data.carData.price_daily);
                    $('#car_type_idEdit').val(data.carData.car_type_id).selectpicker('refresh');
                    $('#car_statusEdit').val(data.carData.car_status).selectpicker('refresh');
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
                url: "{{ route('manager.updatecar') }}",
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
    {{-- Add Bootstrap Select CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <style>
            .page-header {
                font-size: 32px;
                font-weight: bold;
                text-align: center;
                color: #3f454a;
                padding-bottom: 10px;
                border-bottom: 2px solid #262b31;
                margin-bottom: 20px;
            }
    
            .container {
                padding-top: 30px;
            }
    
            .car-list-heading {
                font-size: 28px;
                color: #333;
                font-weight: 600;
                text-transform: uppercase;
                border-bottom: 2px solid #007bff;
                padding-bottom: 10px;
            }
            .btn-info {
                background-color: #007bff;
                border-color: #007bff;
                color: white;
                border-radius: 6px;
            }
    
            .btn-info:hover {
                background-color: #0056b3;
            }
/* tb */
            .table {
            width: 100%;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table-dark {
            background-color: #343a40;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }

        .table th {
            padding: 12px 20px;
        }

        .table tbody tr {
            background-color: #f9f9f9;
            transition: background-color 0.3s ease;
        }

        .table td {
            padding: 12px 20px;
            vertical-align: middle;
            font-size: 14px;
        }
        .table td:last-child {
            font-weight: bold;
            color: #28a745;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .pagination {
            justify-content: center;
        }

        .pagination .page-item .page-link {
            border-radius: 6px;
            transition: 0.2s;
        }

        .pagination .page-item .page-link:hover {
            background-color: #007bff;
            color: white;
        }
        </style>
@stop
