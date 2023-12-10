<template>
    <div class=" overflow-y-auto custom-scrolling p-3">
        <form id="step-one-form" @submit.prevent="submit">
            <!--General information-->
            <div class="my-5">
                <div>
                    <div class="my-5">
                        <div>
                                <div>
                                    <label class="sumo-label font-medium">Add Driver:</label>
                                    <div class="my-2 md:flex gap-2">
                                        <vue-select
                                            :searchable="true"
                                            v-model:selected="stepOne.driver"
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
                                <div v-if="form.errors.driver" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.driver}}</span>
                                </div>
                            </div>
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
                                <label class="text-sm font-medium text-gray-700" id="timeslot">Timeslot:</label>
                                <div class="my-2 ">
                                    <select v-model="stepOne.timeslot" id="timeslot" class="sumo-input my-2">
                                        <option :value="null" selected>Select Timeslot</option>
                                        <option value="0600-0800">0600-0800</option>
                                        <option value="0800-1000">0800-1000</option>
                                        <option value="1000-1200">1000-1200</option>
                                        <option value="1200-1400">1200-1400</option>
                                        <option value="1400-1600">1400-1600</option>
                                        <option value="1600-1800">1600-1800</option>
                                        <option value="1800-2000">1800-2000</option>
                                    </select>
                                    <div class="sumo-error" v-if="form.errors.timeslot" >
                                            {{ form.errors.timeslot }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="my-3 flex justify-end p-2">
        <button form="step-one-form" type="submit" class="btn-primary">
            Next <span class="ml-5">
                <i class="fa-light fa-arrow-right-long"></i>
            </span>
        </button>
    </div>
</template>

<script setup lang="ts">
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import { useStorage } from '@vueuse/core'
import VueSelect from "@/views/components/general-components/vue-select.vue";
import CreateDriver from "@/views/components/driver/create.vue";

defineProps({
    vehicleTypes:Object,
    drivers:Object,
})

const stepOne=useStorage('stepOne',{
    driver:undefined,
    vehicle_reg_no: "",
    vehicle_type: null,
    timeslot:null
})
const step=useStorage('step',1)
const search=ref('')

let form=useForm({
    driver:null,
    vehicle_reg_no: "",
    vehicle_type: null,
    timeslot:null,
})

const submit=()=>{
    form.driver= stepOne.value.driver;
    form.vehicle_reg_no= stepOne.value.vehicle_reg_no;
    form.vehicle_type= stepOne.value.vehicle_type;
    form.timeslot= stepOne.value.timeslot;
    
    form.post(route('delivery.step-one'),{
        onSuccess:()=>{
            step.value=2
        }
    })
}

</script>

<style scoped>

</style>
