<script setup lang="ts">
import Admin from "@/views/layouts/admin.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { PropType, ref, watch, watchEffect } from "vue";
import PromptAlert from "@/views/components/general-components/prompt-alert.vue";
import debounce from "lodash";
import DataPagination from "@/views/components/general-components/data-pagination.vue";
// import UpdateVehicle from "@/views/components/vehicle/update-vehicle.vue";
import CreateQc from "@/views/components/quality-control/create.vue";
import CustomDropdown from "@/views/components/general-components/custom-dropdown.vue";

let props = defineProps({
    qcs: Object,
    filters: Object as PropType<Filters>,
    weighbridges: Object,
});
console.log(props);

const search = ref<String>(props.filters.search);
const showing = ref<Number>(props.filters.showing ?? 10);
const clearFilter = () => {
    search.value = "";
};

watch([search, showing], () => {
    router.get(
        route(
            "quality-control.index",
            {
                search: search.value,
                showing: showing.value,
            },
            { preserveScroll: true, preserveState: true }
        )
    );
});

const deleteQc = (id: number) => {
    router.delete(route("quality-control.destroy", id));
};
</script>

<template>
    <Head title="Quality Controls" />
    <admin>
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Quality COntrols</h1>
            </div>
            <div>
                <create-qc :weighbridges="weighbridges.data">
                    <template #trigger>
                        <button
                            class="btn-simple btn-medium flex items-center gap-2"
                        >
                            <svg
                                class="h-4 fill-gray-600"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 448 512"
                            >
                                <path
                                    d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"
                                />
                            </svg>
                            <span> Add QC</span>
                        </button>
                    </template>
                </create-qc>
            </div>
        </div>
        <div>
            <div class="flex justify-between my-5">
                <div class="flex gap-2">
                    <h6 class="self-center">Showing Entries:</h6>
                    <select
                        v-model="showing"
                        class="font-medium text-xs rounded-xl border bg-gray-50 border border-gray-300 text-gray-900 focus:ring-sky-600 focus:border-sky-600 block h-9 p-2 self-center"
                    >
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 self-center">
                    <div class="flex gap-2">
                        <h6 class="self-center">Search:</h6>
                        <input
                            placeholder="Search by name"
                            type="search"
                            class="small-input"
                            v-model="search"
                        />
                    </div>
                    <div class="flex gap-2" v-if="search">
                        <button
                            @click="clearFilter"
                            class="btn-secondary btn-small"
                        >
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
                                <th scope="col" class="px-2 py-3">Code</th>
                                <th scope="col" class="px-2 py-3">Delivery</th> 
                                <th scope="col" class="px-2 py-3">
                                    Created By
                                </th>
                                <th>Visual Inspection</th>
                                <th scope="col" class="px-2 py-3">Aflatoxin Content</th>
                                <th scope="col" class="px-2 py-3">
                                    Moisture Content
                                </th>
                                <th scope="col" class="px-2 py-3" colspan="2">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="[&>*:nth-child(even)]:bg-gray-100">
                            <tr
                                class="border-b"
                                v-for="qc in qcs.data"
                                :key="qc.id"
                            >
                                <th scope="row" class="px-2 py-3 font-semibold whitespace-nowrap">
                                    {{ qc.code }}
                                </th>
                                <td class="px-2 py-3 capitalize">
                                    <Link :href="route('weighbridge.show', qc.weighbridge.id)"
                                              class="flex items-center gap-1">
                                            {{  qc.weighbridge.code }}
                                            <svg class="h-3 fill-sumo-700" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <!--! Font Awesome Pro 6.0.0-alpha3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                                <path
                                                    d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                            </svg>
                                        </Link>
                                </td>
                                <td class="px-2 py-3 capitalize">
                                    {{ qc.created_by.name }}
                                </td>
                                <td>{{ qc.visual_inspection }}</td>
                                <td>
                                    {{ qc.aflatoxin_content }}
                                </td>
                                <td>
                                    {{ qc.moisture_content }}
                                </td>
                                <td class="px-2 py-3">
                                    <!-- <update-weighbridge :weighbridge="weighbridge">
                                <template #trigger>
                                    <button class="text-green-600">Update</button>
                                </template>
                            </update-weighbridge> -->
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
                                            <Link :href="route('quality-control.show',qc.id)">
                                                <button class="p-2">Details</button>
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
                    <data-pagination :data="qcs"></data-pagination>
                </div>
            </div>
        </div>
    </admin>
</template>

<style scoped></style>
