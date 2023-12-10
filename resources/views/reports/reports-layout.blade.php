<style>
    table{
        width: 100%;
        border-collapse: collapse;
    }
    table tr{
        border: 1px solid #334155;
        border-collapse: collapse;
    }
    table tr th{
        border: 1px solid #334155;
        border-collapse: collapse;
        font-weight: bold;
        padding: 5pt;
        font-size: 11pt;


    }
    table tr td{
        padding: 5pt;
        font-size: 11pt;
        border: solid 1px #334155;
        border-collapse: collapse;

    }
    tr:nth-child(even) td {
        background: #e5e7eb;
    }
    .title{
        font-size: 18pt;
    }
    .sub_title{
        font-size: 15pt;
    }
    .colum_title{
        text-align: left;
    }
</style>
<table>
    <thead>
    <tr style="
        background-color: #182E50;
        height: 20pt;
        color: white;
        font-weight: bold;
        font-size: 28px;

        ">
       @yield('title')
    </tr>
    <tr style="
        background-color: #96C5E4;
        height: 20pt;
        color: #182E50;
        font-weight: bold;
        font-size: 28px;

        ">
        @yield('sub_title')
    </tr>
    <tr style="
        font-size: 18px;
        font-weight: bold;
        background-color:#F1F1F1;
        color: #182E50;
        "
    >
      @yield('column_name')
    </tr>
    </thead>

    <tbody>
    @yield('table_body')
    </tbody>
</table>
