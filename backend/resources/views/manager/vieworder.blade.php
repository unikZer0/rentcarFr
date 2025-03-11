@extends('adminlte::page')

@section('title', 'Order List')

@section('content_header')
    <h1>Order List</h1>
@stop

@section('content')
<div class=" mt-3">
    <h2 class="mb-4">Your Order List</h2>
    <table class="table table-bordered text-center align-middle shadow-lg">
        <thead class="table-dark">
            <tr>
                <th>Book ID</th>
                <th>Customer Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Car Name</th>
                <th>Location</th>
                <th>Pickup</th>
                <th>Dropoff</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total day</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderdata as $order)
                <tr>
                    <td>{{ $order->booking->book_id }}</td>
                    <td>{{ $order->booking->customer->first_name }} {{ $order->booking->customer->last_name }}</td>
                    <td>{{ $order->booking->customer->phone_number }}</td>
                    <td>{{ $order->booking->customer->email }}</td>
                    <td>{{ $order->booking->car->car_name }}</td>
                    <td>{{ $order->booking->Location }}</td>
                    <td>{{ $order->booking->Pickup }}</td>
                    <td>{{ $order->booking->dropoof }}</td>
                    <td>{{ $order->booking->start }}</td>
                    <td>{{ $order->booking->end }}</td>
                    <td>{{ $order->days }}</td>
                    <td>{{ number_format($order->total, 3) }} KIP</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!!$orderdata->links('pagination::bootstrap-5')!!}
</div>

@stop

@section('css')
    {{-- Add your custom CSS here --}}
    <style>
        h1,h2 {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-top: 30px;
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

@section('js')
    <script>
        console.log("Sales data and order list loaded.");
    </script>
@stop
