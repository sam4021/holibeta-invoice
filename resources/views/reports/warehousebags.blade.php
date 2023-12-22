@extends('reports.reports-layout')
@section('column_name')
<th class="colum_title">Code</th>
<th class="px-2 py-3">Weight</th>
<th class="px-2 py-3">Grain</th>
@endsection
@section('table_body')
@foreach($info as $index=>$report)
<tr>
    <td>{{$report->bag_code}}</td>
    <td>{{$report->weight }}</td>
    <td>{{$report->grain->name}}</td>
</tr>
@endforeach


@endsection