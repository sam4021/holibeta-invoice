<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import {ref, PropType, watch} from "vue";
import DataPagination from "@/views/components/general-components/data-pagination.vue";
import PromptAlert from "@/views/components/general-components/prompt-alert.vue";
import CustomDropdown from "@/views/components/general-components/custom-dropdown.vue";

let props=defineProps({
    reports: {
        type: Object as PropType<suppliers[]>,
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
    router.get(route('reports', {
        search: search.value,
        showing: showing.value,
    },{preserveScroll:true,preserveState:true}))
})
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

    <div class="border rounded-xl  shadow-sm">
        <div>
            <div class="relative">
                <table class="w-full text-sm text-left text-gray-700 font-medium">
                    <thead class="text-xs text-sky-700 uppercase bg-sky-50">
                    <tr>
                        <th scope="col" class="px-2 py-3">
                            Code
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Location
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
                            {{report}}
                        </th>
                        <td class="px-2 py-3 capitalize">
                            
                        </td>
                        <td class="px-2 py-3 capitalize">
                            
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
