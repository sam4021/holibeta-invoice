<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, Link} from "@inertiajs/vue3";
import PromptAlert from "@/views/components/general-components/prompt-alert.vue";
import moment from 'moment';

let props = defineProps({
    bag:Object
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
    <div id="printer" style="box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);padding: 2mm;margin: 0 auto;width: 44mm;background: #fff;">
        <div style="box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);padding: 2mm;margin: 0 auto;width: 44mm;background: #fff;">
            <center id="top">
                <div class="logo"></div>
                <div class="info"> 
                    <h2>SBISTechs Inc</h2>
                </div><!--End Info-->
            </center><!--End InvoiceTop-->
            <div id="mid">
                <div class="info">
                    <h2>Contact Info</h2>
                    <p> 
                        Address : street city, state 0000<br>
                        Email   : JohnDoe@gmail.com<br>
                        Phone   : 555-555-5555<br>
                    </p>
                </div>
            </div><!--End Invoice Mid-->
        </div>
    
    
    
    
    
    <div id="bot">

					<div id="table">
						<table>
							<tr class="tabletitle">
								<td class="item"><h2>Item</h2></td>
								<td class="Hours"><h2>Qty</h2></td>
								<td class="Rate"><h2>Sub Total</h2></td>
							</tr>

							<tr class="service">
								<td class="tableitem"><p class="itemtext">Communication</p></td>
								<td class="tableitem"><p class="itemtext">5</p></td>
								<td class="tableitem"><p class="itemtext">$375.00</p></td>
							</tr>

							<tr class="service">
								<td class="tableitem"><p class="itemtext">Asset Gathering</p></td>
								<td class="tableitem"><p class="itemtext">3</p></td>
								<td class="tableitem"><p class="itemtext">$225.00</p></td>
							</tr>

							<tr class="service">
								<td class="tableitem"><p class="itemtext">Design Development</p></td>
								<td class="tableitem"><p class="itemtext">5</p></td>
								<td class="tableitem"><p class="itemtext">$375.00</p></td>
							</tr>

							<tr class="service">
								<td class="tableitem"><p class="itemtext">Animation</p></td>
								<td class="tableitem"><p class="itemtext">20</p></td>
								<td class="tableitem"><p class="itemtext">$1500.00</p></td>
							</tr>

							<tr class="service">
								<td class="tableitem"><p class="itemtext">Animation Revisions</p></td>
								<td class="tableitem"><p class="itemtext">10</p></td>
								<td class="tableitem"><p class="itemtext">$750.00</p></td>
							</tr>


							<tr class="tabletitle">
								<td></td>
								<td class="Rate"><h2>tax</h2></td>
								<td class="payment"><h2>$419.25</h2></td>
							</tr>

							<tr class="tabletitle">
								<td></td>
								<td class="Rate"><h2>Total</h2></td>
								<td class="payment"><h2>$3,644.25</h2></td>
							</tr>

						</table>
					</div><!--End Table-->

					<div id="legalcopy">
						<p class="legal"><strong>Thank you for your business!</strong>  Payment is expected within 31 days; please process this invoice within that time. There will be a 5% interest charge per month on late invoices. 
						</p>
					</div>

				</div><!--End InvoiceBot-->
  </div><!--End Invoice-->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold capitalize">Warehouse Bag</h1>
        </div>
        <div class="flex gap-2">
            <div>
                   <button class="btn-simple btn-medium flex items-center gap-2" @click="printInfo">
                       <svg class="h-4 fill-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                           <path d="M455.7 18.75C443.2 6.252 426.8 0 410.5 0c-16.38 0-32.76 6.25-45.26 18.75L45.11 338.9c-8.568 8.566-14.53 19.39-17.18 31.21l-27.61 122.8C-1.7 502.1 6.159 512 15.95 512c1.047 0 2.116-.1034 3.198-.3202c0 0 84.61-17.95 122.8-26.93c11.54-2.717 21.87-8.523 30.25-16.9l321.2-321.2c24.99-24.99 24.9-65.42-.0898-90.41L455.7 18.75zM138.2 433.9c-2.115 2.115-4.503 3.463-7.308 4.123c-18.17 4.281-47.46 10.71-72.69 16.18l16.55-73.58c.666-2.959 2.15-5.654 4.296-7.803l241.9-241.9l60.13 60.13L138.2 433.9z"/>
                       </svg>
                       <span>Print</span>
                   </button>
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
                            <th class="text-start">Code:</th>
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
                            <td class="px-3">{{ moment(bag.data.created_at).format("DD MMM, YYYY h:MM a") }}</td>
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
                        <tr>
                            <th class="text-start">Barcode No:</th>
                            <td class="px-3">{{bag.data.barcode_no}}</td>
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
                                                {{bag.data.delivery.security_check_code}}
                                            <svg class="h-3 fill-blue-700" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <path
                                                    d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                            </svg>
                                        </Link></td>
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
