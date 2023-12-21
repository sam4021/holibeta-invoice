<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, Link} from "@inertiajs/vue3";
import PromptAlert from "@/views/components/general-components/prompt-alert.vue";
import moment from "moment"
let props = defineProps({
    securityCheck:Object
})
console.log('====================================');
console.log(props);
console.log('====================================');
let front_image = '/images/delivery/'+props.securityCheck.data.front_image
let side_image = '/images/delivery/'+props.securityCheck.data.side_image
let top_image = '/images/delivery/'+props.securityCheck.data.top_image
let back_image = '/images/delivery/'+props.securityCheck.data.back_image

const deleteSecurityCheck=(id:number)=>{
    router.delete(route('delivery.destroy',id))
};
</script>

<template>
    <Head :title="securityCheck.data.name" />
<admin>
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold capitalize">{{securityCheck.data.name}}</h1>
        </div>
        <div class="flex gap-2">
           <div>
               <Link :href="route('delivery.edit',securityCheck.data.id)">
                   <button class="btn-simple btn-medium flex items-center gap-2">
                       <svg class="h-4 fill-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                           <path d="M455.7 18.75C443.2 6.252 426.8 0 410.5 0c-16.38 0-32.76 6.25-45.26 18.75L45.11 338.9c-8.568 8.566-14.53 19.39-17.18 31.21l-27.61 122.8C-1.7 502.1 6.159 512 15.95 512c1.047 0 2.116-.1034 3.198-.3202c0 0 84.61-17.95 122.8-26.93c11.54-2.717 21.87-8.523 30.25-16.9l321.2-321.2c24.99-24.99 24.9-65.42-.0898-90.41L455.7 18.75zM138.2 433.9c-2.115 2.115-4.503 3.463-7.308 4.123c-18.17 4.281-47.46 10.71-72.69 16.18l16.55-73.58c.666-2.959 2.15-5.654 4.296-7.803l241.9-241.9l60.13 60.13L138.2 433.9z"/>
                       </svg>
                       <span>Edit Delivery</span>
                   </button>
               </Link>
           </div>
            <div>
                <prompt-alert
                    title="Are you sure you want to delete this Security Check?"
                    description="All related data will be deleted"
                    @proceed="deleteSecurityCheck(securityCheck.id)"
                >
                    <template #trigger>
                        <button class="btn-danger btn-medium">Delete</button>
                    </template>
                </prompt-alert>
            </div>
        </div>
    </div>
    <div class="my-5">
        <div class="shadow p-4 bg-white rounded-md">
            <div class="grid gap-3 grid-cols-2">
                <div class="my-3">
                    <table class="text-sm font-medium">
                        <tr>
                            <th class="text-start">Code:</th>
                            <td class="px-3">{{ securityCheck.data.code }}</td>
                        </tr>                       
                        <tr>
                            <th class="text-start">Date:</th>
                            <td class="px-3">{{ moment(securityCheck.created_at).format("DD MMM, YYYY h:MM a") }}</td>
                        </tr>                      
                        <tr>
                            <th class="text-start">Created By:</th>
                            <td class="px-3">{{securityCheck.data.created_by.name}}</td>
                        </tr>
                    </table>
                </div>
                
                <div class="my-3">
                    <table class="text-sm font-medium">
                        <!-- <tr>
                            <th class="text-start">Grain:</th>
                            <td class="px-3">
                                <div class="flex gap-2">
                                <span v-for="grain in securityCheck.data.grains" :key="grain.id" class="text-xs">{{ grain.name }} , </span>
                            </div>
                            </td>
                        </tr> -->
                        <!-- <tr>
                            <th class="text-start">Timeslot:</th>
                            <td class="px-3">{{securityCheck.data.timeslot}}</td>
                        </tr> -->
                        <tr>
                            <th class="text-start">Driver:</th>
                            <td class="px-3">{{securityCheck.data.driver.name}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Vehicle:</th>
                            <td class="px-3">{{ securityCheck.data.vehicle_type }}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Vehicle reg no:</th>
                            <td class="px-3">{{securityCheck.data.vehicle_reg_no}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">County:</th>
                            <td class="px-3">{{securityCheck.data.county.name}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Subcounty:</th>
                            <td class="px-3">{{securityCheck.data.subcounty.name}}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Village:</th>
                            <td class="px-3">{{securityCheck.data.village}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="shadow p-4 bg-white rounded-md mt-4">
            <div class="grid gap-3 grid-cols-4">
                <div class="items-center gap-2">
                    <span class="text-gray-600">Front image:</span>
                    <img :src="front_image" class="w-full">
                </div>
                <div class="items-center gap-2">
                    <span class="text-gray-600">Back image:</span>
                    <img :src="back_image" class="w-full">
                </div>
                <div class="items-center gap-2">
                    <span class="text-gray-600">Side image:</span>
                    <img :src="side_image" class="w-full">
                </div>
                <div class="items-center gap-2">
                    <span class="text-gray-600">Top image:</span>
                    <img :src="top_image" class="w-full">
                </div>
            </div>
        </div>
    </div>

    <div class="my-5 flex gap-3">
        
    </div>
</admin>
</template>

<style scoped>

</style>
