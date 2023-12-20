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
    vehicle_reg_no: "",
    vehicle_type: null
})
const step=useStorage('step',1)
const search=ref('')

let form=useForm({
    vehicle_reg_no: "",
    vehicle_type: null
})

const submit=()=>{
    form.vehicle_reg_no= stepOne.value.vehicle_reg_no;
    form.vehicle_type= stepOne.value.vehicle_type;
    
    form.post(route('delivery.step-one'),{
        onSuccess:()=>{
            step.value=2
        }
    })
}

</script>

<style scoped>

</style>
