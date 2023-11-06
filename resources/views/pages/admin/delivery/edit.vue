<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, useForm} from "@inertiajs/vue3";


let props=defineProps({
    securityCheck:Object,
    vehicles: Object,
    suppliers: Object
})
console.log(props);


let form=useForm({
    supplier: props.securityCheck?.data.supplier.id,
    vehicle_reg_no: props.securityCheck?.data.vehicle_reg_no,
    vehicle: props.securityCheck?.data.vehicle.id,
    front_image: "",
    back_image: "",
    side_image: ""
})
let front_image_old = '/images/delivery/'+props.securityCheck.data.front_image
let side_image_old = '/images/delivery/'+props.securityCheck.data.side_image
let back_image_old = '/images/delivery/'+props.securityCheck.data.back_image
</script>

<template>
    <Head title="Edit Security Check" />
    <admin>
        <div class="my-3">
            <div>
                <h1 class="text-2xl font-bold">Edit Security Check</h1>
            </div>
            <div class="my-5">
                <form @submit.prevent="form.patch(route('delivery.update',securityCheck.data.id))">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <div>
                            <label class="sumo-label" for="supplier"
                                >Supplier:</label
                            >
                            <select v-model="form.supplier"
                                id="supplier"
                                class="sumo-input my-2">
                                <option :value="null">Select Supplier</option>
                                <option :value="supplier.id" :key="supplier.id" v-for="supplier in suppliers.data">{{supplier.name}}</option>
                            </select>
                            <div class="sumo-error" v-if="form.errors.supplier">
                                {{ form.errors.supplier }}
                            </div>
                        </div>
                        <div>
                            <label class="sumo-label" for="vehicle">Vehicle:</label>
                            <select v-model="form.vehicle"
                                id="vehicle"
                                class="sumo-input my-2">
                                <option :value="null">Select Vehicle</option>
                                <option :value="vehicle.id" :key="vehicle.id" v-for="vehicle in vehicles.data">{{vehicle.name}}</option>
                            </select>
                            <div class="sumo-error" v-if="form.errors.vehicle">
                                {{ form.errors.vehicle }}
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
                            <div
                                class="sumo-error"
                                v-if="form.errors.vehicle_reg_no"
                            >
                                {{ form.errors.vehicle_reg_no }}
                            </div>
                        </div>
                        <div>
                            <label for="email" class="text-sm font-medium text-gray-700">Front Image</label>
                            <input @input="form.front_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                    <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                        <span class="text-xs">{{form.errors.front_image }}</span>
                                    </div>
                                <span class="p-10"> 
                                    <img :src="front_image_old" class="w-full">
                                </span>
                            <div
                                class="sumo-error"
                                v-if="form.errors.front_image"
                            >
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
                            <div
                                class="sumo-error"
                                v-if="form.errors.back_image"
                            >
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
                            <div
                                class="sumo-error"
                                v-if="form.errors.side_image"
                            >
                                {{ form.errors.side_image }}
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    <div class="my-5 flex justify-end">
                        <button
                            :disabled="form.processing"
                            type="submit"
                            class="btn-primary flex gap-2 items-center"
                        >
                            <span>Update Security Check</span>
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
