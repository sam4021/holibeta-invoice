@extends('reports.reports-layout')
@section('title')
<th class="title" colspan="7" scope="col">Warehouse</th>
@endsection
@section('sub_title')
<!-- <th class="sub_title" colspan="8" scope="col">Leases</th> -->
@endsection
@section('column_name')
<th class="colum_title">CODE.</th>
<th class="colum_title">QC</th>
<th class="colum_title">Barcode No</th>
<th class="colum_title">No of Bags</th>
<th class="colum_title">Grains</th>
<th class="colum_title">Created By</th>
<th class="colum_title">Date</th>
@endsection
@section('table_body')
@foreach($warehouses as $index=>$warehouse)
<tr>
    <td>{{$warehouse->warehouse_code}}</td>
    <td>{{$warehouse->qualityControl->qc_code}}</td>
    <td>{{$warehouse->barcode_no}}</td>
    <td>{{$warehouse->no_of_bags}}</td>
    <td></td>
    <td>{{$warehouse->createdBy->name}}</td>
    <td>{{\Carbon\Carbon::parse($warehouse->created_at)->isoFormat('DD MMM YYYY')}}</td>
</tr>
@endforeach

@endsection