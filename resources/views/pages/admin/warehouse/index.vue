<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import {PropType, ref, watch, watchEffect} from "vue";
import PromptAlert from "@/views/components/general-components/prompt-alert.vue";
import debounce from 'lodash'
import DataPagination from "@/views/components/general-components/data-pagination.vue";
// import UpdateVehicle from "@/views/components/vehicle/update-vehicle.vue";
import CreateWarehouse from "@/views/components/warehouse/create.vue";
let props=defineProps({
    warehouses: {
        type: Object as PropType<Warehouse[]>,
        required: true
    },
    filters: Object as PropType<Filters>,
})
console.log(props);


const search = ref<String>(props.filters.search);
const showing = ref<Number>(props.filters.showing??10);
const clearFilter=()=>{
    search.value="";
}


watch([search,showing],()=>{
    router.get(route('warehouse.index', {
        search: search.value,
        showing: showing.value,
    },{preserveScroll:true,preserveState:true}))
},)

const deleteWarehouse=(id:number)=>{
    router.delete(route('warehouse.destroy',id))
};

</script>

<template>
    <Head title="Warehouses" />
<admin>
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold">Warehouses</h1>
    </div>
    <div>
        <Link :href="route('warehouse.create')">
                <button class="btn-simple btn-medium flex items-center gap-2">

                    <svg class="h-4 fill-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"/>
                    </svg>
                    <span> Add Warehouse</span>
                </button>
            </Link>

    </div>
</div>
    <div>
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
                <div class="flex gap-2">
                    <h6 class="self-center">Search:</h6>
                    <input  placeholder="Search by name" type="search" class="small-input" v-model="search">
                </div>
                <div class="flex gap-2" v-if="search">
                    <button @click="clearFilter" class="btn-secondary btn-small">
                        <span>Clear</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!--vehicle table-->
    <div class="border rounded-xl overflow-hidden shadow-sm">
        <div>
            <div class="relative">
                <table class="w-full text-sm text-left text-gray-700 font-medium">
                    <thead class="text-xs text-sky-700 uppercase bg-sky-50">
                    <tr>
                        <th scope="col" class="px-2 py-3">
                            Security Check
                        </th>
                        <th scope="col" class="px-2 py-3">
                           Barcode No
                        </th>
                        <th>
                            No of Bags
                        </th>
                        <th>
                            Weight/Bag (KG)
                        </th>
                        <th scope="col" class="px-2 py-3" colspan="2">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody class="[&>*:nth-child(even)]:bg-gray-100">
                    <tr class="border-b" v-for="warehouse in warehouses.data" :key="warehouse.id" >
                        <th scope="row" class="px-2 py-3 font-semibold whitespace-nowrap">
                            {{warehouse.securityCheck.code}}
                        </th>
                        <td class="px-2 py-3 capitalize">
                            {{warehouse.barcode_no}}
                        </td>
                        <td>
                            {{ warehouse.no_of_bags }}
                        </td>
                        <td>
                            {{ warehouse.weight_per_bag }}
                        </td>
                        <td class="px-2 py-3">
                            <!-- <update-vehicle :vehicle="vehicle">
                                <template #trigger>
                                    <button class="text-green-600">Update</button>
                                </template>
                            </update-vehicle> -->


                        </td>
                        <td class="px-2 py-3">
                            <prompt-alert
                                title="Are you sure you want to delete this vehicle?"
                                description="All related data will be deleted"
                                @proceed="deleteVehicle(vehicle.id)"
                            >
                                <template #trigger>
                                    <button class="text-red-500">Delete</button>
                                    </template>
                            </prompt-alert>

                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--pagination-->
                <data-pagination :data="warehouses"></data-pagination>
            </div>
        </div>
    </div>
</admin>
</template>

<style scoped>

</style>
