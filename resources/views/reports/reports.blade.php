@extends('reports.reports-layout')
@section('title')
<th class="title" colspan="8" scope="col">Report</th>
@endsection
@section('sub_title')
<!-- <th class="sub_title" colspan="8" scope="col">Leases</th> -->
@endsection
@section('column_name')
<th class="colum_title">Bag Code</th>
<th class="px-2 py-3">Weight</th>
<th class="px-2 py-3">Warehouse</th>
<th class="px-2 py-3">QC</th>
<th class="px-2 py-3">Weighbridge</th>
<th class="px-2 py-3">Delivery</th>
<th class="px-2 py-3">Supplier</th>
<th class="px-2 py-3">Driver</th>
@endsection
@section('table_body')
@foreach($reports as $index=>$report)
<tr>
    <td>{{$report->bag_code}}</td>
    <td>{{$report->weight }}</td>
    <td>{{$report->warehouse_code}}</td>
    <td>{{$report->qc_code}}</td>
    <td>{{$report->weighbridge_code}}</td>
    <td>{{$report->d_code}}</td>
    <td>{{$report->fullname}}</td>
    <td>{{$report->driver_name}}</td>
</tr>
@endforeach


@endsection