@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-5">
        <div class="col-md-4 stretch-card grid-margin">
          <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
              <h4 class="font-weight-normal mb-3">total order<i class="mdi mdi-chart-line mdi-24px float-end"></i>
              </h4>
              <h2 class="mb-5">{{$orderCount}}</h2>
              <h6 class="card-text"></h6>
            </div>
          </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
          <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
              <h4 class="font-weight-normal mb-3">total manager <i class="mdi mdi-bookmark-outline mdi-24px float-end"></i>
              </h4>
                <h2>
                  @if ($managertotal==0)
                  <h2>0</h2>
                  @else
                  {{$managertotal}}
                  @endif
                </h2>
            </div>
          </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
          <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
              <h4 class="font-weight-normal mb-3">total car <i class="mdi mdi-diamond mdi-24px float-end"></i>
              </h4>
              @if ($cartotal==0)
                  <h2>0</h2>
                  @else
                  <h2 class="mb-5">{{$cartotal}}</h2>
                  @endif
            </div>
          </div>
        </div>
      </div>
@stop

@section('content')
<h2 class="title" >Newest order list</h2>
<p class="mb-2">check order menu for more</p>
<div class="container">
    <table rows=5 class=" table table-bordered text-center align-middle shadow-lg">
        <thead class="table-dark">
            <tr>
                <th>Book ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Car Name</th>
                <th>Location</th>
                <th>Pickup</th>
                <th>Dropoff</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderdata as $order)
                <tr>
                    <td>{{ $order->booking->book_id }}</td>
                    <td>{{ $order->booking->customer->first_name }} {{ $order->booking->customer->last_name }}</td>
                    <td>{{ $order->booking->customer->email }}</td>
                    <td>{{ $order->booking->car->car_name }}</td>
                    <td>{{ $order->booking->Location }}</td>
                    <td>{{ $order->booking->Pickup }}</td>
                    <td>{{ $order->booking->dropoof }}</td>
                    <td>{{ number_format($order->total, 3) }} KIP</td>
                </tr>
            @endforeach
        </tbody>
    </table>
  </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <style>
    .row {
      display: flex;
      gap: 30px;
      margin-top: 30px;
  }

  .col-md-4 {
      flex: 1;
  }
  .card {
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      position: relative;
      transition: transform 0.3s ease;
  }

  .card:hover {
      transform: translateY(-5px);
  }
  .bg-gradient-danger {
      background: linear-gradient(135deg, #f56565, #e53e3e);
  }

  .bg-gradient-info {
      background: linear-gradient(135deg, #63b3ed, #3182ce);
  }

  .bg-gradient-success {
      background: linear-gradient(135deg, #68d391, #48bb78);
  }

  .card-body {
      padding: 25px;
      text-align: left;
  }

  .font-weight-normal {
      font-weight: 500;
  }

  .mb-3 {
      margin-bottom: 1rem;
  }

  .mb-5 {
      margin-bottom: 2rem;
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
  h2, h1 {
      font-size: 2.5rem;
      margin: 0;
  }

  h6.card-text {
      font-size: 1rem;
      margin-top: 15px;
  }
  .mdi {
      font-size: 1.5rem;
      color: white;
  }

  .float-end {
      float: right;
  }

  h1,h2.mb-3 {
      font-size: 2rem;
      font-weight: bold;
      color: #333;
      margin-top: 30px;
  }

  p.mb-5 {
      font-size: 1.2rem;
      color: #666;
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
</style>
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
