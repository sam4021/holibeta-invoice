<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import {ref, PropType, watch} from "vue";
import DataPagination from "@/views/components/general-components/data-pagination.vue";
import PromptAlert from "@/views/components/general-components/prompt-alert.vue";
import CustomDropdown from "@/views/components/general-components/custom-dropdown.vue";

let props=defineProps({
    suppliers: {
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
    router.get(route('suppliers.index', {
        search: search.value,
        showing: showing.value,
    },{preserveScroll:true,preserveState:true}))
})

const deleteSupplier=(id:number)=>{
    router.delete(route('suppliers.destroy',id))
};
</script>

<template>
    <Head title="Suppliers" />
<admin>
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Suppliers</h1>
        </div>
        <div>
            <Link :href="route('suppliers.create')">
                <button class="btn-simple btn-medium flex items-center gap-2">

                    <svg class="h-4 fill-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"/>
                    </svg>
                    <span> Add Supplier</span>
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
                            Status
                        </th>
                        <th scope="col" class="px-2 py-3 text-end">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody class="[&>*:nth-child(even)]:bg-gray-100">
                    <tr class="border-b" v-for="supplier in suppliers.data" :key="supplier.id" >
                        <th scope="row" class="px-2 py-3 font-semibold whitespace-nowrap">
                            {{supplier.supplier_code}}
                        </th>
                        <td class="px-2 py-3 capitalize">
                            {{supplier.name}}
                        </td>
                        <td class="px-2 py-3 capitalize">
                            {{supplier.statusView}}
                        </td>
                        <td class="px-2 py-3">
                            <custom-dropdown>
                                <template #trigger>
                                    <button class="flex gap-2 items-center">
                                       <span> More</span>
                                        <svg class="h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512">
                                            <path d="M64 112c26.5 0 48-21.5 48-48S90.5 16 64 16S16 37.5 16 64S37.5 112 64 112zM64 400c-26.5 0-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48S90.5 400 64 400zM64 208C37.5 208 16 229.5 16 256S37.5 304 64 304s48-21.5 48-48S90.5 208 64 208z"/>
                                        </svg>
                                    </button>
                                </template>
                                <div>
                                    <ul class="divide-y">
                                        <li>
                                            <Link :href="route('suppliers.show',supplier.slug)">
                                                <button class="p-2">Details</button>
                                            </Link>
                                        </li>
                                        <li>
                                            <Link :href="route('suppliers.edit',supplier.id)">
                                                <button class="text-green-600 p-2">Update</button>
                                            </Link>
                                        </li>
                                    </ul>
                                </div>
                            </custom-dropdown>


                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--pagination-->
                <data-pagination :data="suppliers"></data-pagination>
            </div>
        </div>
    </div>
</admin>
</template>

<style scoped>

</style>
