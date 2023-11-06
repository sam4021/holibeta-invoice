<template>
    <div class=" overflow-y-auto custom-scrolling p-3">
        <form id="step-one-form" @submit.prevent="submit">
            <!--General information-->
            <div class="my-5">
                <div>
                    <div class="my-5">
                        <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-3">
                            <div>
                                <label class="sumo-label" for="supplier"
                                    >Supplier:</label
                                >
                                <select v-model="stepOne.supplier"
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
                                <select v-model="stepOne.vehicle"
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
                                    v-model="stepOne.vehicle_reg_no"
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
                                <label class="text-sm font-medium text-gray-700" id="timeslot">Timeslot:</label>
                                <div class="my-2 ">
                                    <select v-model="stepOne.timeslot" id="timeslot" class="sumo-input my-2">
                                        <option :value="null">Select Timeslot</option>
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

defineProps({
    vehicles:Object,
    suppliers:Object
})

const stepOne=useStorage('stepOne',{
    supplier: null,
    vehicle_reg_no: "",
    vehicle: null,
    timeslot:null,
})
const step=useStorage('step',1)
const search=ref('')

let form=useForm({
    supplier: null,
    vehicle_reg_no: "",
    vehicle: null,
    timeslot:null,
})

const submit=()=>{
    form.supplier= stepOne.value.supplier;
    form.vehicle_reg_no= stepOne.value.vehicle_reg_no;
    form.vehicle= stepOne.value.vehicle;
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
