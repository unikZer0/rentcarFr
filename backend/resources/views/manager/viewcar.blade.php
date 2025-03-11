@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="page-header">View Car</h1>
@stop


@section('content')
<div class="container mt-5 mb-3">
    <button type="button" class="btn btn-info mb-1" data-bs-toggle="modal" data-bs-target="#addCarModal">
        <i class="fa fa-plus"></i> Add Car
    </button>
</div>
    <table class="table table-bordered text-center align-middle shadow-lg">
        <thead class="table-dark">
            <tr>
                <th>Car ID</th>
                <th>Car Name</th>
                <th>Car Type</th>
                <th>Description</th>
                <th>Price (Daily)</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cardata as $data)
                <tr>
                    <td>{{ $data->car_id }}</td>
                    <td>{{ $data->car_name }}</td>
                    <td>{{ $data->carType->car_type_name }}</td>
                    <td>{{ $data->descriptions }}</td>
                    <td>{{ number_format($data->price_daily, 2) }} KIP</td>
                    <td>
                        <img src="{{ asset($data->image) }}" class="img-thumbnail" alt="Car Image" width="80" height="80">
                    </td>
                    <td>
                        <span class="badge {{ $data->car_status == 'Available' ? 'bg-success' : 'bg-danger' }}">
                            {{ $data->car_status }}
                        </span>
                    </td>
                    <td>
                        <button class="edit btn btn-primary btn-sm" data-id="{{ $data->car_id }}"
                            data-bs-toggle="modal" data-bs-target="#addCarModalEdit">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="confirmDelete('{{ route('manager.deletecar', ['id' => $data->car_id]) }}')">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    {!! $cardata->links('pagination::bootstrap-5') !!}
    </div>

    @include('manager.create')
@stop
@include('manager.editcar')
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        //sweet alert 
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



        //insert edit
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
        //update
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
        //img
        var modal = document.getElementById("myModal");
        var img = document.getElementById("myImg");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@stop
@section('css')
    {{-- Add Bootstrap Select CSS --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
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
