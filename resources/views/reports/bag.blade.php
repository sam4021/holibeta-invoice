<!DOCTYPE html>
<html lang="en">
<title>INVOICE</title>

<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        @page {
            margin: 0;
            margin-bottom: 90px;
            counter-increment: page;
            margin-top: 120px;
            margin-left: 30px;
            margin-right: 30px;
            width: 100%;

            @top-left {
                content: " ";
                background-repeat: no-repeat;
                background-size: contain;
                height: 100px;
                /* content: counter(page); */
            }

        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr th {
            border: 1px solid #334155;
            border-collapse: collapse;
            font-weight: bold;
            padding: 5pt;
            font-size: 11pt;


        }

        table tr td table tr td {
            padding: 5pt;
            font-size: 11pt;
            border: solid 1px #334155;
            border-collapse: collapse;

        }

        tr:nth-child(even) th,
        tr:nth-child(even) td {
            background: #e5e7eb;
        }

        table tr th {
            text-align: left;
            font-size: 13px;
        }

        table tr td {
            text-align: left;
            font-size: 13px;
            vertical-align: top;
        }

        @media print {
            @page {
                margin: 0;
                margin-bottom: 90px;
                counter-increment: page;
                margin-top: 120px;
                margin-left: 30px;
                margin-right: 30px;
                width: 100%;

                @top-left {
                    content: " ";
                    background-repeat: no-repeat;
                    background-size: contain;
                    height: 100px;
                    /* content: counter(page); */
                }
            }
        }
    </style>
</head>

<body style="font-family: 'Montserrat', sans-serif !important;">
    <header style="margin-top:20px;">
        <div style="display: block;position:relative;">
            <div style="width:50%;float:left;">
                <img style="width:50%;" src="http://portal.emseafarm.com/images/logo.png" alt="emsea farm" />
            </div>
            <div style="width:50%;float:left;">

            </div>
            <div style="clear: both;"></div>
        </div>
    </header>

    <div style="width:100%;display:block; margin-top:50px;">
        <table style="width: 100%;">
            <tr>
                <td style="width:50%">
                    <div style="width: 90%;">
                        <div style="border-bottom: 1px solid #ddd;font-weight:700; font-size:20px;padding:5px 10px;background-color:#312783;color:#fff;">
                            Bag Info
                        </div>
                        <table style="text-align: left;">
                            <tr>
                                <th>Code</th>
                                <td>{{$info->bag_code}}</td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>{{$info->createdBy->name}}</td>
                            </tr>
                            <tr>
                                <th>Weight</th>
                                <td>{{$info->weight}}</td>
                            </tr>
                            <tr>
                                <th>Grain</th>
                                <td>{{$info->grain->name}}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{date_format($info->created_at, 'F j, Y')}}</td>
                            </tr>
                        </table>
                    </div>

                </td>
                <td style="width:50%">
                    <div style="width: 90%;">
                        <div style="border-bottom: 1px solid #ddd;font-weight:700; font-size:20px;padding:5px 10px;background-color:#312783;color:#fff;">
                            Warehouse
                        </div>
                        <table style="text-align: left;">
                            <tr>
                                <th>Code</th>
                                <td>{{$info->warehouse->warehouse_code}}</td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>{{$info->warehouse->createdBy->name}}</td>
                            </tr>
                            <tr>
                                <th>Bags</th>
                                <td>{{$info->warehouse->no_of_bags}}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{date_format($info->warehouse->created_at, 'F j, Y')}}</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

        </table>
        <div style="margin:20px;"></div>
        <table>
            <tr>
                @if (isset($info->qualityControl))
                    <td style="width:50%">
                        <div style="width: 90%;">
                            <div style="border-bottom: 1px solid #ddd;font-weight:700; font-size:20px;padding:5px 10px;background-color:#312783;color:#fff;">
                                Quality Control
                            </div>
                            <table style="text-align: left;">
                                <tr>
                                    <th style="text-align: left;">Code</th>
                                    <td>{{$info->qualityControl->qc_code}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left;">Created By</th>
                                    <td>{{$info->qualityControl->createdBy->name}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left;">Visual Inspection</th>
                                    <td>{{$info->warehouse->visual_inspection}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left;">Visual Inspection Comment</th>
                                    <td>{{$info->warehouse->visual_inspection_comment}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left">Moisture Content</th>
                                    <td>{{$info->warehouse->moisture_content}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left;">Aflatoxin Content</th>
                                    <td>{{$info->warehouse->aflatoxin_content}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left;">Date</th>
                                    <td>{{date_format($info->qualityControl->created_at, 'F j, Y')}}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                @endif

                <td style="width:50%">
                    <div style="width: 90%;">
                        <div style="border-bottom: 1px solid #ddd;font-weight:700; font-size:20px;padding:5px 10px;background-color:#312783;color:#fff;">
                            Weighbridge
                        </div>
                        <table style="text-align: left;">
                            <tr>
                                <th style="text-align: left;">Code</th>
                                <td>{{$info->weighbridge->weighbridge_code}}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">Created By</th>
                                <td>{{$info->weighbridge->createdBy->name}}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">Date</th>
                                <td>{{date_format($info->weighbridge->created_at, 'F j, Y')}}</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <div style="margin:20px;"></div>
        <table>
            <tr>
                <td style="width:50%">
                    <div style="width: 90%;">
                        <div style="border-bottom: 1px solid #ddd;font-weight:700; font-size:20px;padding:5px 10px;background-color:#312783;color:#fff;">
                            Delivery
                        </div>
                        <table style="text-align: left;">
                            <tr>
                                <th style="text-align: left;">Code</th>
                                <td>{{$info->delivery->security_check_code}}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">Created By</th>
                                <td>{{$info->delivery->createdBy->name}}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">Driver</th>
                                <td>{{$info->delivery->driver->firstname}} {{$info->delivery->driver->middlename}} {{$info->delivery->driver->lastname}}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">Vehicle Reg No</th>
                                <td>{{$info->delivery->vehicle_reg_no}}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">Vehicle Type</th>
                                <td>{{$info->delivery->vehicle_type}}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">Location</th>
                                <td>{{$info->delivery->village}}, {{$info->delivery->subcounty->name}}, {{$info->delivery->county->name}}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">Date</th>
                                <td>{{date_format($info->delivery->created_at, 'F j, Y')}}</td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td style="width:50%"></td>
            </tr>
        </table>


    </div>
</body>

</html>