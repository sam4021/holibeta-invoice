<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, Link} from "@inertiajs/vue3";
import PromptAlert from "@/views/components/general-components/prompt-alert.vue";
import moment from "moment"
let props = defineProps({
    weighbridge:Object
})
console.log(props)
const deleteWeighbridge=(id:number)=>{
    router.delete(route('weighbridge.destroy',id))
};
</script>

<template>
    <Head title="Weighbridge" />
<admin>
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold capitalize">Weighbridge Data</h1>
        </div>
        <div class="flex gap-2">
           <div>
               <Link :href="route('weighbridge.edit',weighbridge.data.id)">
                   <button class="btn-simple btn-medium flex items-center gap-2">
                       <svg class="h-4 fill-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                           <path d="M455.7 18.75C443.2 6.252 426.8 0 410.5 0c-16.38 0-32.76 6.25-45.26 18.75L45.11 338.9c-8.568 8.566-14.53 19.39-17.18 31.21l-27.61 122.8C-1.7 502.1 6.159 512 15.95 512c1.047 0 2.116-.1034 3.198-.3202c0 0 84.61-17.95 122.8-26.93c11.54-2.717 21.87-8.523 30.25-16.9l321.2-321.2c24.99-24.99 24.9-65.42-.0898-90.41L455.7 18.75zM138.2 433.9c-2.115 2.115-4.503 3.463-7.308 4.123c-18.17 4.281-47.46 10.71-72.69 16.18l16.55-73.58c.666-2.959 2.15-5.654 4.296-7.803l241.9-241.9l60.13 60.13L138.2 433.9z"/>
                       </svg>
                       <span>Edit weighbridge</span>
                   </button>
               </Link>
           </div>
            <div>
                <prompt-alert
                    title="Are you sure you want to delete this Weighbridge?"
                    description="All related data will be deleted"
                    @proceed="deleteWeighbridge(weighbridge.data.id)"
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
                            <th class="text-start">Delivery:</th>
                            <td class="px-3">
                                <Link :href="route('delivery.show', weighbridge.data.delivery.id)"
                                              class="flex items-center gap-1">
                                            {{  weighbridge.data.delivery.code }}
                                            <svg class="h-3 fill-sumo-700" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <!--! Font Awesome Pro 6.0.0-alpha3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                                <path
                                                    d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                            </svg>
                                        </Link>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-start">Supplier:</th>
                            <td class="px-3">
                                <Link :href="route('suppliers.show', weighbridge.data.supplier.slug)"
                                              class="flex items-center gap-1">
                                            {{  weighbridge.data.supplier.name }}
                                            <svg class="h-3 fill-sumo-700" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <!--! Font Awesome Pro 6.0.0-alpha3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                                <path
                                                    d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                                            </svg>
                                        </Link>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-start">Created By:</th>
                            <td class="px-3">{{weighbridge.data.created_by.name}}</td>
                        </tr>                        
                        <tr>
                            <th class="text-start">Date:</th>
                            <td class="px-3">{{ moment(weighbridge.data.created_at).format("DD MMM, YYYY h:MM a") }}</td>
                        </tr>                      
                    </table>
                </div>
                <div class="my-3">
                    <table class="text-sm font-medium">
                        <tr>
                            <th class="text-start">Weight:</th>
                            <td class="px-3">{{weighbridge.data.weight}}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <td><img :src="'/images/weighbridge/'+weighbridge.data.image"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</admin>
</template>

<style scoped>

</style>
