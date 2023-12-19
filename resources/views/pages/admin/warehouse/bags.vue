<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import {PropType, ref, watch, watchEffect} from "vue";
import PromptAlert from "@/views/components/general-components/prompt-alert.vue";
import debounce from 'lodash'
import moment from 'moment';
import DataPagination from "@/views/components/general-components/data-pagination.vue";
let props=defineProps({
    bags: Object,
    filters: Object as PropType<Filters>,
    grains: Object
})
console.log(props);


const search = ref<String>(props.filters.search);
const showing = ref<Number>(props.filters.showing??10);
const grain = ref<String>(props.filters.grain??null);
const clearFilter=()=>{
    search.value="";
}


watch([search,showing,grain],()=>{
    router.get(route('warehouse.bags', {
        search: search.value,
        showing: showing.value,
        grain: grain.value,
    },{preserveScroll:true,preserveState:true}))
},)

</script>

<template>
    <Head title="Warehouse Bags" />
<admin>
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold">Warehouse Bags</h1>
    </div>
    <div>
        

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
                    <h6 class="self-center">Grain:</h6>
                    <select v-model="grain" class="font-medium text-xs  rounded-xl border bg-gray-50 border border-gray-300 text-gray-900 focus:ring-sky-600 focus:border-sky-600 block h-9 p-2  self-center">
                        <option :value="null">All</option>
                        <option v-for="grain in grains" :key="grain.id" :value="grain.id">{{ grain.name }}</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <h6 class="self-center">Search:</h6>
                    <input  placeholder="Search by Code" type="search" class="small-input" v-model="search">
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
                           Bag Code
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Warehouse
                        </th>
                        <th scope="col" class="px-2 py-3">
                           Grain
                        </th>
                        <th>
                            Weight
                        </th>
                        <th>
                            Date
                        </th>
                        <th scope="col" class="px-2 py-3" colspan="2">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody class="[&>*:nth-child(even)]:bg-gray-100">
                    <tr class="border-b" v-for="bag in bags.data" :key="bag.id" >
                        <th scope="row" class="px-2 py-3 font-semibold whitespace-nowrap text-xs">
                            {{bag.bag_code}}
                        </th>
                        <th scope="row" class="px-2 py-3 font-semibold whitespace-nowrap text-xs">
                            <Link :href="route('warehouse.show',bag.warehouse_id)"
                                              class="flex items-center gap-1">
                                            {{bag.warehouse_code}}
                                            <svg class="h-3 fill-blue-700" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <!--! Font Awesome Pro 6.0.0-alpha3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                                <path
                                                    d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                            </svg>
                                        </Link>
                            
                        </th>
                        <td class="px-2 py-3 capitalize text-xs">
                            {{ bag.grain_name }}
                        </td>
                        <td class="text-xs">
                            {{ bag.weight }}
                        </td>
                        <td class="text-xs">
                            {{ moment(bag.bag_date).format("DD MMM, YYYY") }}
                        </td>
                        <td class="px-2 py-3 text-xs">
                            <Link :href="route('warehouse.bag',bag.bag_id)">
                                <button class="p-2">Details</button>
                            </Link>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--pagination-->
                <data-pagination :data="bags"></data-pagination>
            </div>
        </div>
    </div>
</admin>
</template>

<style scoped>

</style>
