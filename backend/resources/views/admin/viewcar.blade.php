@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="title">viewcar</h1>
@stop


@section('content')
        <p class="mb-2">Car List</p>
    <table class="table table-bordered text-center align-middle shadow-lg">
    <thead class="table-dark">
        <tr>
            <th>Car By</th>
            <th>Car ID</th>
            <th>CarName</th>
            <th>Cartype</th>
            <th>Describtions</th>
            <th>price</th>
            <th>Image</th>
            <th>Status</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cardata as $data)
            <tr><td>{{$data->user->name}}</td>
                <td>{{ $data->car_id }}</td>
                <td>{{ $data->car_name }}</td>
                <td>{{ $data->carType->car_type_name }}</td>
                <td>{{ $data->descriptions }}</td>
                <td>{{ $data->price_daily }}</td>
                <td>
                    <img src="{{ asset($data->image) }}" id="myImg" alt="" width="80" height="80">
                    {{-- <div id="myModal" class="modal">
                        <span class="close">&times;</span>
                        <img class="modal-content" id="img01">
                        <div id="caption"></div>
                      </div> --}}
                </td>
                <td>{{ $data->car_status }}</td>
                <td>
                        <form action="{{ route('admin.deletecar', ['id' => $data->car_id]) }}" method="get">
                            <button class="edit btn btn-primary" data-id="{{ $data->car_id }}" data-bs-toggle="modal" data-bs-target="#addCarModalEdit">
                                <i class="fa fa-edit"></i>
                            </button>
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-trash"></i> 
                            </button>
                        </form>
                    </td>
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>
    {!!$cardata->links('pagination::bootstrap-5')!!}
@stop
@include('admin.editcar')
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

    <script>
        //insert edit
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
    <link href="{{ asset('css/imgpopup.css') }}" rel="stylesheet">
    <style>
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
    
      /* Paginate */
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
      .title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }
        p.mb-2 {
            font-size: 1.1rem;
            color: #666;
            text-align: center;
            margin-bottom: 30px;
        }
       </style>
@stop
