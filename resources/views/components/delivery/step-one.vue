<template>
    <div class=" overflow-y-auto custom-scrolling p-3">
        <form id="step-one-form" @submit.prevent="submit">
            <!--General information-->
            <div class="my-5">
                <div>
                    <div class="my-5">
                        <hr class="my-3">
                        <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-3">
                            <div>
                                <label class="sumo-label" for="vehicle">Vehicle Type:</label>
                                <select v-model="stepOne.vehicle_type" id="timeslot" class="sumo-input my-2">
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
                                    v-model="stepOne.vehicle_reg_no"
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
                                <label for="email" class="text-sm font-medium text-gray-700">Front Image</label>
                                <input @input="stepOne.front_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.front_image }}</span>
                                </div>
                            </div>
                            <div>
                                <label for="email" class="text-sm font-medium text-gray-700">Back Image</label>
                                <input @input="stepOne.back_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.back_image }}</span>
                                </div>
                            </div>
                            <div>
                                <label for="email" class="text-sm font-medium text-gray-700">Top Image</label>
                                <input @input="stepOne.top_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.top_image }}</span>
                                </div>
                            </div>
                            <div>
                                <label for="email" class="text-sm font-medium text-gray-700">Side Image</label>
                                <input @input="stepOne.side_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.side_image }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="my-3 flex justify-end p-2">
        <button form="step-one-form" type="submit" class="btn-primary flex">
            Next <span class="ml-5">
                <svg class="fill-white h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/></svg>
            </span>
        </button>
    </div>
</template>

<script setup lang="ts">
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import { useStorage } from '@vueuse/core'


defineProps({
    vehicleTypes:Object,
})

const stepOne=useStorage('stepOne',{
    front_image: "",
    back_image: "",
    side_image: "",
    top_image:"",
    vehicle_reg_no: "",
    vehicle_type: null
})
const step=useStorage('step',1)
const search=ref('')

let form=useForm({
    front_image: "",
    back_image: "",
    side_image: "",
    top_image:"",
    vehicle_reg_no: "",
    vehicle_type: null
})

const submit=()=>{
    form.vehicle_reg_no= stepOne.value.vehicle_reg_no;
    form.vehicle_type= stepOne.value.vehicle_type;
    form.front_image= stepOne.value.front_image;
    form.back_image= stepOne.value.back_image;
    form.side_image= stepOne.value.side_image;
    form.top_image= stepOne.value.top_image;
    
    form.post(route('delivery.step-one'),{
        onSuccess:()=>{
            step.value=2
        }
    })
}

</script>

<style scoped>

</style>
