<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, Link} from "@inertiajs/vue3";
import PromptAlert from "@/views/components/general-components/prompt-alert.vue";
import moment from 'moment';
import VueQrcode from '@chenfengyuan/vue-qrcode';

let props = defineProps({
    bag:Object,
    qrcode:Object
})
console.log(props);

const deleteBag=(id:number)=>{
    router.delete(route('warehouse.bag.destroy',id))
};

const printInfo=()=>{
    // size is 62mm but use 60 mm with padding of 1 mm 
    var divContents = document.getElementById("printer").innerHTML; 
    var myWindow = window.open('', 'Receipt', 'height=400,width=600');
    myWindow.document.write('<html><head><title>Receipt</title>');
    /*optional stylesheet*/ //myWindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    myWindow.document.write('<style type="text/css"> *, html {margin:0;padding:0;} </style>');
    myWindow.document.write('</head><body>');
    myWindow.document.write(divContents);
    myWindow.document.write('</body></html>');
    myWindow.document.close(); // necessary for IE >= 10

    myWindow.onload=function(){ // necessary if the div contain images

        myWindow.focus(); // necessary for IE >= 10
        myWindow.print();
        // myWindow.close();
    };
}
</script>

<template>
    <Head title="Warehouse Bag Data" />
<admin>
    <div id="printer" style="width: 324px;background: #fff;" class="hidden">
        <div style="width: 300px;background: #fff;">
            <div style="width:250px;margin: 7px;display: flex;">
                <div style="float:left;width:120px;margin-top: 10px;">
                    <!-- <vue-qrcode value="Hello, World!" :options="{ width: 110 }"></vue-qrcode> -->
                    <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=110x110&data=Bag Code::'+bag.data.code" alt="QR Code" class="block">
                </div>
                <div style="float:left;width:270px;font-size: 12px;margin-top: 10px;margin-left: 10px;">
                    <p><b>Bag Code: </b> {{bag.data.code}} </p>
                    <p><b class="text-start">Grain:</b> {{bag.data.grain.name}}</p> 
                    <p><b class="text-start">Weight:</b>{{bag.data.weight}}</p>
                    <p><b class="text-start">Supplier:</b>{{bag.data.supplier.name}}</p>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
    </div>
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold capitalize">Warehouse Bag</h1>
        </div>
        <div class="flex gap-2">
            <div>
                <button class="btn-simple btn-medium flex items-center gap-2" @click="printInfo">               
                    <svg class="h-4 fill-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="M448 192H64C28.65 192 0 220.7 0 256v96c0 17.67 14.33 32 32 32h32v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h32c17.67 0 32-14.33 32-32V256C512 220.7 483.3 192 448 192zM384 448H128v-96h256V448zM432 296c-13.25 0-24-10.75-24-24c0-13.27 10.75-24 24-24s24 10.73 24 24C456 285.3 445.3 296 432 296zM128 64h229.5L384 90.51V160h64V77.25c0-8.484-3.375-16.62-9.375-22.62l-45.25-45.25C387.4 3.375 379.2 0 370.8 0H96C78.34 0 64 14.33 64 32v128h64V64z"/>
                    </svg>
                    <span>Print</span>
                </button>
           </div>
           <div>
            <a :href="route('warehouse.bag.pdf',bag.data.id)" class="btn-simple btn-medium flex items-center gap-2">
                <svg class="h-4 fill-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                    <path d="M374.6 150.6l-141.3-141.3C227.4 3.371 219.2 0 210.7 0H64C28.65 0 0 28.65 0 64l.0065 384c0 35.34 28.65 64 64 64H320c35.35 0 64-28.66 64-64V173.3C384 164.8 380.6 156.6 374.6 150.6zM224 22.63L361.4 160H248C234.8 160 224 149.2 224 136V22.63zM368 448c0 26.47-21.53 48-48 48H64c-26.47 0-48-21.53-48-48V64c0-26.47 21.53-48 48-48h144v120c0 22.06 17.94 40 40 40h120V448zM112 352h-32C71.16 352 64 359.2 64 368v64C64 440.8 71.16 448 80 448h32C120.8 448 128 440.8 128 432v-64C128 359.2 120.8 352 112 352zM112 432h-32v-64h32V432zM208 224h-32C167.2 224 160 231.2 160 240v192C160 440.8 167.2 448 176 448h32c8.838 0 16-7.164 16-16v-192C224 231.2 216.8 224 208 224zM208 432h-32v-192h32V432zM272 448h32c8.838 0 16-7.164 16-16v-128C320 295.2 312.8 288 304 288h-32C263.2 288 256 295.2 256 304v128C256 440.8 263.2 448 272 448zM272 304h32v128h-32V304z"/>
                </svg>
                <span>Report</span>
            </a>
           </div>
           <div>
               <!-- <Link :href="route('warehouse.edit',warehouse.data.id)"> -->
                   <button class="btn-simple btn-medium flex items-center gap-2">
                       <svg class="h-4 fill-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                           <path d="M455.7 18.75C443.2 6.252 426.8 0 410.5 0c-16.38 0-32.76 6.25-45.26 18.75L45.11 338.9c-8.568 8.566-14.53 19.39-17.18 31.21l-27.61 122.8C-1.7 502.1 6.159 512 15.95 512c1.047 0 2.116-.1034 3.198-.3202c0 0 84.61-17.95 122.8-26.93c11.54-2.717 21.87-8.523 30.25-16.9l321.2-321.2c24.99-24.99 24.9-65.42-.0898-90.41L455.7 18.75zM138.2 433.9c-2.115 2.115-4.503 3.463-7.308 4.123c-18.17 4.281-47.46 10.71-72.69 16.18l16.55-73.58c.666-2.959 2.15-5.654 4.296-7.803l241.9-241.9l60.13 60.13L138.2 433.9z"/>
                       </svg>
                       <span>Edit Bag</span>
                   </button>
               <!-- </Link> -->
           </div>
            <div>
                <prompt-alert
                    title="Are you sure you want to delete this Bag?"
                    description="All related data will be deleted"
                    @proceed="deleteBag(bag.data.id)"
                >
                    <template #trigger>
                        <button class="btn-danger btn-medium">Delete</button>
                    </template>
                </prompt-alert>
            </div>
        </div>
    </div>

    <div class="my-5">
        <div class="shadow p-4 bg-white rounded-md">
            <div class="grid gap-3 grid-cols-2">
                <div class="my-3">
                    <table class="text-sm font-medium">
                        <tr>
                            <th class="text-start">Bag Code:</th>
                            <td class="px-3">{{bag.data.code}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Warehouse:</th>
                            <td class="px-3">
                                <Link :href="route('warehouse.show', bag.data.warehouse.id)"
                                              class="flex items-center gap-1">
                                            {{  bag.data.warehouse.code }}
                                            <svg class="h-3 fill-blue-700" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <!--! Font Awesome Pro 6.0.0-alpha3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                                <path
                                                    d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                            </svg>
                                        </Link>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-start">Created By:</th>
                            <td class="px-3">{{bag.data.created_by.name}}</td>
                        </tr>                        
                        <tr>
                            <th class="text-start">Date:</th>
                            <td class="px-3">{{ moment(bag.data.created_at).format("DD MMM, YYYY") }}</td>
                        </tr>                      
                    </table>
                </div>
                
                <div class="my-3">
                    <table class="text-sm font-medium">
                        <tr>
                            <th class="text-start">Grain:</th>
                            <td class="px-3">{{bag.data.grain.name}}</td>
                        </tr> 
                        <tr>
                            <th class="text-start">Weight:</th>
                            <td class="px-3">{{bag.data.weight}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="my-5">
            <div class="grid gap-3 grid-cols-2">
                <div class="shadow p-4 bg-white rounded-md">
                    <div class="my-3">
                        <h2 class="font-bold text-sm border-b pb-2 mb-4">Bag Status</h2>
                        <table class="w-full text-sm text-left text-gray-700 font-medium">
                            <thead class="text-xs text-sky-700 uppercase bg-sky-50">
                            <tr>
                                <th scope="col" class="px-2 py-3">
                                    Status
                                </th>
                                <th>
                                Date
                                </th>
                            </tr>
                            </thead>
                            <tbody class="[&>*:nth-child(even)]:bg-gray-100">
                            <tr class="border-b" v-for="status in bag.data.status" :key="status.id" >
                                <th scope="row" class="px-2 py-3 font-semibold whitespace-nowrap text-xs">
                                    {{status.status}}
                                </th>
                                <th scope="row" class="px-2 py-3 font-semibold whitespace-nowrap text-xs">
                                    {{ moment(status.created_at).format("DD MMM, YYYY h:MM a") }}
                                </th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="shadow p-4 bg-white rounded-md">
                    <div class="my-3">
                        <h2 class="font-bold text-sm border-b pb-2 mb-4">Warehouse</h2>
                        <table class="text-sm font-medium">
                        <tr>
                            <th class="text-start">Code:</th>
                            <td class="px-3">
                                <Link :href="route('warehouse.show', bag.data.warehouse.id)"
                                              class="flex items-center gap-1">
                                                {{bag.data.warehouse.code}}
                                            <svg class="h-3 fill-blue-700" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <!--! Font Awesome Pro 6.0.0-alpha3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                                <path
                                                    d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                            </svg>
                                        </Link></td>
                        </tr> 
                        <tr>
                            <th class="text-start">No of Bags:</th>
                            <td class="px-3">{{bag.data.warehouse.no_of_bags}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Created By:</th>
                            <td class="px-3">{{bag.data.warehouse.created_by.name}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Date:</th>
                            <td class="px-3">{{ moment(bag.data.warehouse.created_at).format("DD MMM, YYYY h:MM a") }}</td>
                        </tr> 
                    </table>
                    </div>
                </div>

                <div class="shadow p-4 bg-white rounded-md">
                    <div class="my-3">
                        <h2 class="font-bold text-sm border-b pb-2 mb-4">Quality Control</h2>
                        <table class="text-sm font-medium">
                        <tr>
                            <th class="text-start">Code:</th>
                            <td class="px-3">
                                <Link :href="route('quality-control.show', bag.data.qc.id)"
                                              class="flex items-center gap-1">
                                                {{bag.data.qc.code}}
                                            <svg class="h-3 fill-blue-700" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <!--! Font Awesome Pro 6.0.0-alpha3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                                <path
                                                    d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                            </svg>
                                        </Link></td>
                        </tr> 
                        <tr>
                            <th class="text-start">Aflatoxin Content:</th>
                            <td class="px-3">{{bag.data.qc.aflatoxin_content}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Moisture Content:</th>
                            <td class="px-3">{{bag.data.qc.moisture_content}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Visual Inspection:</th>
                            <td class="px-3">{{bag.data.qc.visual_inspection}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Visual Inspection Comment:</th>
                            <td class="px-3">{{bag.data.qc.visual_inspection_comment}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Created By:</th>
                            <td class="px-3">{{bag.data.qc.created_by.name}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Date:</th>
                            <td class="px-3">{{ moment(bag.data.qc.created_at).format("DD MMM, YYYY h:MM a") }}</td>
                        </tr> 
                    </table>
                    </div>
                </div>
                
                <div class="shadow p-4 bg-white rounded-md">
                    <div class="my-3">
                        <h2 class="font-bold text-sm border-b pb-2 mb-4">Weighbridge</h2>
                        <table class="text-sm font-medium">
                        <tr>
                            <th class="text-start">Code:</th>
                            <td class="px-3">
                                <Link :href="route('weighbridge.show', bag.data.weighbridge.id)"
                                              class="flex items-center gap-1">
                                                {{bag.data.weighbridge.weighbridge_code}}
                                            <svg class="h-3 fill-blue-700" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <!--! Font Awesome Pro 6.0.0-alpha3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                                <path
                                                    d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                            </svg>
                                        </Link></td>
                        </tr> 
                        <tr>
                            <th class="text-start">Weight:</th>
                            <td class="px-3">{{bag.data.weighbridge.weight}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Date:</th>
                            <td class="px-3">{{ moment(bag.data.weighbridge.created_at).format("DD MMM, YYYY h:MM a") }}</td>
                        </tr> 
                        <tr>
                            <th class="text-start">Visual Inspection:</th>
                            <td class="px-3">{{bag.data.weighbridge.visual_inspection}}</td>
                        </tr>
                    </table>
                    </div>
                </div>

                <div class="shadow p-4 bg-white rounded-md">
                    <div class="my-3">
                        <h2 class="font-bold text-sm border-b pb-2 mb-4">Delivery</h2>
                        <table class="text-sm font-medium">
                        <tr>
                            <th class="text-start">Code:</th>
                            <td class="px-3">
                                <Link :href="route('delivery.show', bag.data.delivery.id)"
                                              class="flex items-center gap-1">
                                                {{bag.data.delivery.code}}
                                            <svg class="h-3 fill-blue-700" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <path
                                                    d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                            </svg>
                                        </Link></td>
                        </tr> 
                        
                        <tr>
                            <th class="text-start">Location:</th>
                            <td class="px-3">{{bag.data.delivery.village}}, {{bag.data.delivery.subcounty.name}}, {{bag.data.delivery.county.name}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Vehicle Reg No:</th>
                            <td class="px-3">{{bag.data.delivery.vehicle_reg_no}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Vehicle Type:</th>
                            <td class="px-3">{{bag.data.delivery.vehicle_type}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Created By:</th>
                            <td class="px-3">{{bag.data.delivery.created_by.name}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Date:</th>
                            <td class="px-3">{{ moment(bag.data.delivery.created_at).format("DD MMM, YYYY h:MM a") }}</td>
                        </tr>  
                    </table>
                    </div>
                </div>

                <div class="shadow p-4 bg-white rounded-md">
                    <div class="my-3">
                        <h2 class="font-bold text-sm border-b pb-2 mb-4">Supplier</h2>
                        <table class="text-sm font-medium">
                        <tr>
                            <th class="text-start">Code:</th>
                            <td class="px-3">
                                <Link :href="route('suppliers.show', bag.data.supplier.slug)"
                                              class="flex items-center gap-1">
                                                {{bag.data.supplier.supplier_code}}
                                            <svg class="h-3 fill-blue-700" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <path
                                                    d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                            </svg>
                                        </Link></td>
                        </tr> 
                        <tr>
                            <th class="text-start">Name:</th>
                            <td class="px-3">{{ bag.data.supplier.name }} </td>
                        </tr> 
                        <tr>
                            <th class="text-start">County:</th>
                            <td class="px-3">{{bag.data.supplier.county.name}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Subcounty:</th>
                            <td class="px-3">{{bag.data.supplier.subcounty.name}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Ward:</th>
                            <td class="px-3">{{bag.data.supplier.ward}}</td>
                        </tr>
                    </table>
                    </div>
                </div>
            </div>
        
    </div>

    
</admin>
</template>

<style scoped>

</style>
