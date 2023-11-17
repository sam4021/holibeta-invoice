<template>
    <div class="relative" v-on-click-outside="closeDrop" ref="dropbox">
        <div  class="h-12 border rounded-xl bg-white px-3 flex
        justify-between w-full  items-center" :class="[disabled?'opacity-80':'']">
            <button @click="dropdown=!dropdown"  type="button" class="font-medium w-full h-full text-start">
                <span class="self-center" v-if="locationStore.default_county">{{locationStore.default_county.name}}</span>
                <span class="self-center" v-else >{{placeholder}}</span>
            </button>
            <svg v-if="locationStore.default_county" @click="resetSelected"  class="h-4 fill-black cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg>
            <svg v-else   class="h-4 fill-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
        </div>
        <Transition
            enter-from-class="opacity-0 "
            enter-to-class="opacity-100 scale-100"
            enter-active-class="transition duration-300"
            leave-active-class="transition duration-200"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0"
        >
            <div v-show="dropdown && !disabled" class="py-2 mt-1 absolute z-10 bg-white divide-y divide-gray-100 rounded-lg
            shadow w-full overflow-hidden ">
                <div v-if="searchable" class="p-2 shadow">
                    <div  class="flex items-center px-2 h-10 border rounded-xl overflow-hidden focus:border-sumo-700">

                        <svg class="h-4 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M504.1 471l-134-134C399.1 301.5 415.1 256.8 415.1 208c0-114.9-93.13-208-208-208S-.0002 93.13-.0002 208S93.12 416 207.1 416c48.79 0 93.55-16.91 129-45.04l134 134C475.7 509.7 481.9 512 488 512s12.28-2.344 16.97-7.031C514.3 495.6 514.3 480.4 504.1 471zM48 208c0-88.22 71.78-160 160-160s160 71.78 160 160s-71.78 160-160 160S48 296.2 48 208z"/></svg>
                        <input v-model="search" type="search" class="h-full w-full border-none focus:ring-0 focus:outline-none text-sm font-medium placeholder-sumo-700" placeholder="Search by name...">
                    </div>
                </div>
                <ul v-if="!locationStore.loading" class="text-sm text-gray-700 max-h-48 overflow-y-auto" aria-labelledby="dropdownHoverButton">
                    <li v-for="county in locationStore.counties" :key="county.id" class="grid ">
                        <button type="button" @click="selectOption(county)" class="text-start font-medium w-full h-full cursor-pointer  hover:bg-sumo-700/20 p-2">
                            <span class="capitalize">{{county.name}}</span>
                        </button>

                    </li>
                </ul>
                <ul v-else class="text-sm text-gray-700 max-h-48 overflow-y-auto" aria-labelledby="dropdownHoverButton">
                    <li  class="grid ">
                        <button type="button"  class="flex gap-2 items-center text-start font-medium w-full h-full hover:bg-sumo-700/20 p-2">
                            <span class="capitalize">Loading</span>
                            <svg class="w-3 fill-sumo-300 animate-ping" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400 256c0 26.5 21.5 48 48 48s48-21.5 48-48S474.5 208 448 208S400 229.5 400 256zM112 256c0-26.5-21.5-48-48-48S16 229.5 16 256S37.5 304 64 304S112 282.5 112 256zM304 256c0-26.5-21.5-48-48-48S208 229.5 208 256S229.5 304 256 304S304 282.5 304 256z"/></svg>
                        </button>

                    </li>
                </ul>
            </div>
        </Transition>
    </div>

</template>

<script setup lang="ts">
import {computed, onMounted, ref, watch} from "vue";
import { vOnClickOutside } from '@vueuse/components'
import {useLocationStore} from "@/scripts/store/locationStore";
import {debounce} from 'lodash';
let props=defineProps({
    placeholder:String,
    searchable:Boolean,
    disabled:Boolean,
})
const locationStore=useLocationStore()
const search=ref('')
locationStore.getCounties(search.value)

watch(search, debounce(function (){
    //if (!search) return
    locationStore.getCounties(search.value)
},300))

const dropdown=ref(false)

function selectOption(county:any){
    dropdown.value=false
    locationStore.default_county=county
    search.value=''
    locationStore.getSubcounties(county.id)
}

const resetSelected=()=>{
   locationStore.default_county={}
    dropdown.value=false
    search.value=''
}

const closeDrop=()=>{
    dropdown.value=false
}

onMounted(()=>{
    if (locationStore.default_county){
        // locationStore.getSubcounties(locationStore.default_county.id)
    }
})

</script>

<style scoped>

</style>
