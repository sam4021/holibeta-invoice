<script setup lang="ts">

import CustomDropdown from "@/views/components/general-components/custom-dropdown.vue";
import {Link, usePage} from "@inertiajs/vue3";
import apexchart from "vue3-apexcharts";
import {computed, onMounted, ref} from "vue";
import Card from "@/views/components/widgets/card.vue";
import axios from "axios";


const options=computed(()=>({
    xaxis: {
        categories: weights.value.map((item: { day: any; })=>item.day)
    },
    chart: {
        id: 'Daily Weight'
    },
    colors:'#182E50'
}))
const weights=ref([])
const series=computed(()=>([
    {
        name: 'Weights',
        data: weights.value.map((item: { data: any; })=>item.weight)
    }
]))

const company = computed(() => usePage().props.auth.company.company_id)

const weightsLoading=ref(false)

const getWeight= async ()=>{
    weightsLoading.value=true
    await  axios.get(`/api/get/warehouse/weight/daily`).then((response)=>{
        weights.value=response.data
        console.log(response.data);
        
        weightsLoading.value=false
    }).catch((e)=>console.log(e))
}
onMounted(()=>{
    getWeight()
})

</script>

<template>
    <card>

        <template #header>
            <div class="flex justify-between items-center">
                <div>
                    <h6 class="text-md font-black text-sumo-300">Daily Weight for the last 5 days</h6>
                </div>
                <div>
                    <custom-dropdown>
                        <template #trigger>
                            <button>
                                <svg class="h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512">
                                    <path d="M64 112c26.5 0 48-21.5 48-48S90.5 16 64 16S16 37.5 16 64S37.5 112 64 112zM64 400c-26.5 0-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48S90.5 400 64 400zM64 208C37.5 208 16 229.5 16 256S37.5 304 64 304s48-21.5 48-48S90.5 208 64 208z"/>
                                </svg>
                            </button>
                        </template>
                        <div>
                            <ul>
                                <li>
                                    <button type="button" class="p-2 w-full h-full text-start hover:text-sumo-700">Hide</button>
                                </li>
                            </ul>
                        </div>
                    </custom-dropdown>
                </div>
            </div>
        </template>
        <div>
            <apexchart height="250"  type="bar" :options="options" :series="series"></apexchart>

        </div>
        <template #footer>
            <div class="flex justify-end p-3">
                <Link :href="route('warehouse.index')" class="btn-simple btn-small">
                    <span>See all</span>
                </Link>
            </div>
        </template>
    </card>
</template>

<style scoped>

</style>
