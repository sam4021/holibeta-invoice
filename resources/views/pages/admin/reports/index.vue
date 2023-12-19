<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import {ref, PropType, watch} from "vue";
import DataPagination from "@/views/components/general-components/data-pagination.vue";
import PromptAlert from "@/views/components/general-components/prompt-alert.vue";
import CustomDropdown from "@/views/components/general-components/custom-dropdown.vue";
import VueSelect from "@/views/components/general-components/vue-select.vue";

let props=defineProps({
    reports: Object,
    filters: Object as PropType<Filters>,
    suppliers: Object,
    drivers: Object,
})
console.log(props);

const search = ref<String>(props.filters.search);
const showing = ref<Number>(props.filters.showing??10);
const supplier = ref(props.filters?.supplier?props.filters.supplier:null);
const driver = ref(props.filters?.driver?props.filters.driver:null);
const clearFilter=()=>{
     router.get(route('reports'))
}

watch([search,showing,supplier,driver],()=>{
    router.get(route('reports', {
        search: search.value,
        showing: showing.value,
        supplier: supplier.value,
        driver: driver.value
    },{preserveScroll:true,preserveState:true}))
})
const checkValue=()=>{
    z = 45;
    console.log(z);
    var z;
} 
checkValue(); 
</script>

<template>
    <Head title="Reports" />
<admin>
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Reports</h1>
        </div>
        <div>

        </div>

    </div>
    <div>
        <div class="flex justify-between">
            <div>
                <h6 class="font-bold">Available: {{reports.data.length}}</h6>
            </div>
            <div class="flex justify-end gap-3 self-center">
                <h6 class="font-semibold">Export Data:</h6>
                <a :href="route('reports.report','pdf')" class="text-indigo-700 font-bold text-sm">PDF</a>
                <a :href="route('reports.report','excel')" class="text-indigo-700 font-bold text-base">Excel</a>
            </div>
        </div>
        <div class="flex justify-between my-5">
            <div class="flex gap-2">
                <h6 class="self-center">Showing Entries:</h6>
                <select v-model="showing" class="font-medium text-xs  rounded-xl border bg-gray-50 border border-gray-300 text-gray-900 focus:ring-sky-600 focus:border-sky-600 block h-9 p-2  self-center">
                    <option value="10">10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 self-center">
                <div>
                    <vue-select
                        :searchable="true"
                        v-model:selected="driver"
                        :options="drivers"
                        placeholder="Select Driver"
                        class=""
                    ></vue-select>
                </div>
                <div>
                    <vue-select
                        :searchable="true"
                        v-model:selected="supplier"
                        :options="suppliers"
                        placeholder="Select Supplier"
                        class=""
                    ></vue-select>
                </div>
                <div class="flex gap-2">
                    <h6 class="self-center">Search:</h6>
                    <input  placeholder="Search by name" type="search" class="small-input" v-model="search">
                </div>
                <div class="flex gap-2" v-if="search || supplier || driver">
                    <button @click="clearFilter" class="btn-secondary btn-small">
                        <span>Clear</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="border rounded-xl  shadow-sm">
        <div>
            <div class="relative">
                <table class="w-full text-sm text-left text-gray-700 font-medium">
                    <thead class="text-xs text-sky-700 uppercase bg-sky-50">
                    <tr>
                        <th scope="col" class="px-2 py-3">
                            Bag Code
                        </th>
                        <th scope="col" class="px-2 py-3">
                            weight
                        </th>
                        <th scope="col" class="px-2 py-3">
                            warehouse
                        </th>
                        <th scope="col" class="px-2 py-3">
                            QC
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Weighbridge
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Delivery
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Supplier
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Driver
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-2 py-3 text-end">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody class="[&>*:nth-child(even)]:bg-gray-100">
                    <tr class="border-b" v-for="report in reports.data" :key="report.id" >
                        <th scope="row" class="px-2 py-3 font-semibold whitespace-nowrap">
                            <Link :href="route('warehouse.bag', report.bag_id)" class="flex items-center gap-1">
                                {{report.bag_code}}
                                <svg class="h-3 fill-blue-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                    <!--! Font Awesome Pro 6.0.0-alpha3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                    <path
                                        d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                </svg>
                            </Link>
                        </th>
                        <td class="px-2 py-3 capitalize">
                            {{ report.weight }}
                        </td>
                        <td class="px-2 py-3 capitalize">
                            <Link :href="route('grains.show', report.warehouse_id)" class="flex items-center gap-1">
                                {{report.warehouse_code}}
                                <svg class="h-3 fill-blue-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                    <!--! Font Awesome Pro 6.0.0-alpha3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                    <path
                                        d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                </svg>
                            </Link>
                        </td>
                        <td class="px-2 py-3 capitalize">
                            <Link :href="route('quality-control.show', report.qc_id)" class="flex items-center gap-1">
                                {{report.qc_code}}
                                <svg class="h-3 fill-blue-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                    <!--! Font Awesome Pro 6.0.0-alpha3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                    <path
                                        d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                </svg>
                            </Link>
                        </td>
                        <td class="px-2 py-3 capitalize">
                            <Link :href="route('weighbridge.show', report.weighbridge_id)" class="flex items-center gap-1">
                                {{report.weighbridge_code}}
                                <svg class="h-3 fill-blue-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                    <path
                                        d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                </svg>
                            </Link>
                        </td>
                        <td class="px-2 py-3 capitalize">
                            <Link :href="route('delivery.show', report.d_id)" class="flex items-center gap-1">
                                {{report.d_code}}
                                <svg class="h-3 fill-blue-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                    <path
                                        d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                </svg>
                            </Link>
                        </td>
                        <td class="px-2 py-3 capitalize">
                            <Link :href="route('suppliers.show', report.supplier_id)" class="flex items-center gap-1">
                                {{report.fullname}}
                                <svg class="h-3 fill-blue-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                    <path
                                        d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                </svg>
                            </Link>
                        </td>
                        <td class="px-2 py-3 capitalize">
                            <Link :href="route('drivers.show', report.driver_id)" class="flex items-center gap-1">
                                {{report.driver_name}}
                                <svg class="h-3 fill-blue-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                    <path
                                        d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                </svg>
                            </Link>
                        </td>
                        <td class="px-2 py-3 capitalize">
                           
                        </td>
                        <td class="px-2 py-3">
                        
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--pagination-->
                <data-pagination :data="reports"></data-pagination>
            </div>
        </div>
    </div>
</admin>
</template>

<style scoped>

</style>
