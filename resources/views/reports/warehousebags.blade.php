@extends('reports.reports-layout')
@section('column_name')
<th class="colum_title">Bag Code</th>
<th class="px-2 py-3">Bag Url</th>
@endsection
@section('table_body')
@foreach($info as $index=>$report)
<tr>
    <td>{{$report->bag_code}}</td>
    <td>http://portal.emseafarm.com/admin/warehouse/bag/{{$report->id}}</td>
</tr>
@endforeach


@endsection