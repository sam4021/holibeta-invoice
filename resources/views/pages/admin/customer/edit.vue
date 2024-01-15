<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, useForm} from "@inertiajs/vue3";
import VueSelect from "@/views/components/general-components/vue-select.vue";

let props=defineProps({
    securityCheck:Object,
    vehicleTypes: Object,
    drivers: Object,
})
console.log(props);


let form=useForm({
    vehicle_reg_no: props.securityCheck?.data.vehicle_reg_no,
    vehicle_type: props.securityCheck?.data.vehicle_type,    
    driver:props.securityCheck?.data.driver.id,
    front_image: "",
    back_image: "",
    side_image: "",
    top_image:"",
})
let front_image_old = '/images/delivery/'+props.securityCheck.data.front_image
let side_image_old = '/images/delivery/'+props.securityCheck.data.side_image
let back_image_old = '/images/delivery/'+props.securityCheck.data.back_image
let top_image_old = '/images/delivery/'+props.securityCheck.data.top_image
</script>

<template>
    <Head title="Edit Delivery" />
    <admin>
        <div class="my-3">
            <div>
                <h1 class="text-2xl font-bold">Edit Delivery</h1>
            </div>
            <div class="my-5">
                <form @submit.prevent="form.patch(route('delivery.update',securityCheck.data.id))">
                    <div class="my-5">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <div>
                                <label class="sumo-label" for="vehicle_type">Vehicle Type:</label>
                                <select v-model="form.vehicle_type" id="vehicle_type" class="sumo-input my-2">
                                        <option :value="null" selected>Select Type</option>
                                        <option v-for="vtype in vehicleTypes" :value="vtype">{{ vtype }}</option>
                                    </select>
                                <div class="sumo-error" v-if="form.errors.vehicle_type">
                                    {{ form.errors.vehicle_type }}
                                </div>
                            </div>

                            <div>
                                <label for="vehicle_reg_no" class="text-sm font-medium text-gray-700">Vehicle Reg No</label>
                                <input
                                    v-model="form.vehicle_reg_no"
                                    placeholder="Enter Vehicle Reg No"
                                    type="text"
                                    id="vehicle_reg_no"
                                    class="sumo-input my-2"
                                />
                                <div class="sumo-error" v-if="form.errors.vehicle_reg_no">
                                    {{ form.errors.vehicle_reg_no }}
                                </div>
                            </div>
                            <div>
                        <label class="sumo-label font-medium">Add Driver:</label>
                        <div class="my-2 md:flex gap-2">
                            <vue-select
                                :searchable="true"
                                v-model:selected="form.driver"
                                :options="drivers.data"
                                placeholder="Select Driver"
                                class="md:w-96"
                            ></vue-select>
                            <create-driver>
                                <template #trigger>
                                    <button class="btn-simple flex items-center gap-2 text-sumo-300">
                                        <svg class="h-4 fill-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"/>
                                        </svg>
                                        <span> New Driver</span>
                                    </button>
                                </template>
                            </create-driver>
                        </div>
                        </div>
                            
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
                        
                        <div>
                            <label for="vehicle_reg_no" class="text-sm font-medium text-gray-700">Vehicle Reg No</label>
                            <input
                                v-model="form.vehicle_reg_no"
                                placeholder="Enter Vehicle Reg No"
                                type="text"
                                id="vehicle_reg_no"
                                class="sumo-input my-2"
                            />
                            <div
                                class="sumo-error"
                                v-if="form.errors.vehicle_reg_no"
                            >
                                {{ form.errors.vehicle_reg_no }}
                            </div>
                        </div>
                        
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-3">
<div>
                            <label for="email" class="text-sm font-medium text-gray-700">Front Image</label>
                            <input @input="form.front_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                    <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                        <span class="text-xs">{{form.errors.front_image }}</span>
                                    </div>
                                <span class="p-10"> 
                                    <img :src="front_image_old" class="w-full">
                                </span>
                            <div class="sumo-error" v-if="form.errors.front_image" >
                                {{ form.errors.front_image }}
                            </div>
                        </div>
                        <div>
                            <label for="email" class="text-sm font-medium text-gray-700">Back Image</label>
                            <input @input="form.back_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                            
                                    <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                        <span class="text-xs">{{form.errors.back_image }}</span>
                                    </div>
                                    <span class="p-10"> 
                                    <img :src="back_image_old" class="w-full">
                                </span>
                            <div class="sumo-error" v-if="form.errors.back_image" >
                                {{ form.errors.back_image }}
                            </div>
                        </div>
                        <div>
                            <label for="email" class="text-sm font-medium text-gray-700">Side Image</label>
                            <input @input="form.side_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                    <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                        <span class="text-xs">{{form.errors.side_image }}</span>
                                    </div>
                                    <span class="p-10"> 
                                    <img :src="side_image_old" class="w-full">
                                </span>
                            <div class="sumo-error" v-if="form.errors.side_image">
                                {{ form.errors.side_image }}
                            </div>
                        </div>
                        <div>
                            <label for="email" class="text-sm font-medium text-gray-700">Top Image</label>
                            <input @input="form.top_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                    <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                        <span class="text-xs">{{form.errors.top_image }}</span>
                                    </div>
                                    <span class="p-10"> 
                                    <img :src="top_image_old" class="w-full">
                                </span>
                            <div class="sumo-error" v-if="form.errors.top_image">
                                {{ form.errors.top_image }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="my-5 flex justify-end">
                        <button
                            :disabled="form.processing"
                            type="submit"
                            class="btn-primary flex gap-2 items-center"
                        >
                            <span>Update Delivery</span>
                            <svg
                                v-if="form.processing"
                                class="fill-white w-5 animate-ping"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"
                            >
                                <path
                                    d="M400 256c0 26.5 21.5 48 48 48s48-21.5 48-48S474.5 208 448 208S400 229.5 400 256zM112 256c0-26.5-21.5-48-48-48S16 229.5 16 256S37.5 304 64 304S112 282.5 112 256zM304 256c0-26.5-21.5-48-48-48S208 229.5 208 256S229.5 304 256 304S304 282.5 304 256z"
                                />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </admin>
</template>

<style scoped>

</style>
