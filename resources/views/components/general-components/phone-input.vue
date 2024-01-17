<template>

<div class="flex" >
    <div class="relative">
        <button @click="dropdownShow=!dropdownShow" class="border border-r-0 border-gray-300 w-16 py-2 h-12 font-medium rounded-l-xl text-sm px-2 gap-1 flex justify-between items-center" type="button">
            <img v-if="locationStore.default_country" class="h-4 border " :src="locationStore.default_country.flag " :alt="locationStore.default_country.name"/>
            <svg class="h-4 fill-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
        </button>
        <!-- Dropdown menu -->
        <div v-on-click-outside="dropHide" v-show="dropdownShow"  class="z-50 absolute bg-gray-50 border shadow w-72 mt-1 rounded-lg">
            <div class="p-3">
                <label for="input-group-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input v-model="search" type="text" id="input-group-search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-sumo-300 focus:border-sumo-300" placeholder="Search user">
                </div>
            </div>

            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200 h-[200px] overflow-y-auto" aria-labelledby="dropdownDefaultButton">
                <li v-for="nation in locationStore.countries" :key="nation.id">
                 <div class="my-2 p-1">
                     <label class="cursor-pointer flex  gap-2 font-bold text-xs">
                         <input  @input="dropdownShow=false" :value="nation" type="radio" v-model="locationStore.default_country" class="hidden">
                         <img class="w-5 h-auto" :src="nation.flag " :alt="nation.name"/>
                         <span>{{nation.name}} ({{nation.dial_code}})</span>
                     </label>
                 </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="w-full flex items-center px-2 h-12 border border-gray-300 rounded-r-xl focus:ring-sky-600  focus:border-sky-600">
        <span v-if="locationStore.default_country">({{locationStore.default_country.dial_code}})</span>
        <input max="25"  v-model="locationStore.phone" type="tel" class="h-full w-full border-0 focus:outline-none focus:ring-0 focus:border-0 text-sm"  placeholder="e.g 722000000">
    </div>


</div>
</template>

<script setup lang="ts">
import {ref, watch} from 'vue'
import {useLocationStore} from "@/scripts/store/locationStore";
import { vOnClickOutside } from '@vueuse/components'

defineProps({
    phone:String,
    country:String

})
const search=ref('')
const locationStore=useLocationStore()
locationStore.getCountries(search.value)
locationStore.getDefaultCountry()

const phone=ref()

const prefix=ref()
const dropdownShow=ref(false)
const dropHide=()=>{
    dropdownShow.value=false
}

//const assign value
const assignValue=()=>{
    dropdownShow.value=false;
}

watch(search,(value)=>{
    locationStore.getCountries(value)
})

watch(()=>locationStore.default_country,()=>{
    if (locationStore.default_country){
        locationStore.getCities(locationStore.default_country.name)
    }
})

//get default country

</script>

<style scoped>

</style>
