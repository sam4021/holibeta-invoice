<script setup lang="ts">

import {computed, onMounted, ref} from "vue";
import {Link, usePage} from "@inertiajs/vue3";
import apexchart from "vue3-apexcharts";
import Card from "@/views/components/widgets/card.vue";
import axios from "axios";

const labels=ref()
const counts=ref()
const total=ref(0)
const unitsLoading=ref(false)
const options=computed(()=>({
    labels:labels.value,
    colors: ['#182E50', '#124B64','#4E798D','#507DAB'],
    legend:{
        position: 'bottom',
    }
}))
const series=computed(()=>{
    return counts.value
})

onMounted(()=>{
    getGrains()
})

const getGrains= async ()=>{
    unitsLoading.value=true
    await  axios.get(`/api/get/grains/count/warehouse`).then((response)=>{
        labels.value=response.data[0]
        counts.value=response.data[1]
        let sum = 0;

        // calculate sum using forEach() method
        counts.value.forEach( num => {
        sum += num;
        })
        total.value = sum

        unitsLoading.value=false
    }).catch((e)=>console.log(e))
}
</script>

<template>
    <card>
        <template #header>
            <div class="flex justify-between items-center">
                <div>
                    <h6 class="text-md font-black text-sumo-300 text-md">Grains</h6>
                </div>
                <div>
                    
                </div>
            </div>
        </template>
        <div>
            <h6 class="font-bold text-center"><span class="text-sumo-300">Total Bags: </span>{{ total }}</h6>
            <apexchart   type="donut" :options="options" :series="series"></apexchart>

        </div>
        <template #footer>
            <div class="flex justify-end p-2 items-center h-full">
                
            </div>
        </template>
    </card>

</template>

<style scoped>

</style>
