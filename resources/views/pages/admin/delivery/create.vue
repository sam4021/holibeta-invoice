<script setup lang="ts">
import Admin from "@/views/layouts/admin.vue";
import { Head, useForm, usePage, router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import {useStorage} from "@vueuse/core";
import StepOne from "@/views/components/delivery/step-one.vue";
import StepTwo from "@/views/components/delivery/step-two.vue";
import StepThree from "@/views/components/delivery/step-three.vue";
import CountySelect from "@/views/components/general-components/county-select.vue";
import SubcountySelect from "@/views/components/general-components/subcounty-select.vue";
import {useLocationStore} from "@/scripts/store/locationStore";
import CreateDriver from "@/views/components/driver/create.vue";
import VueSelect from "@/views/components/general-components/vue-select.vue";

const locationStore=useLocationStore()
const search=ref('')
locationStore.getCounties(search.value)
locationStore.getDefaultCounty()

let props = defineProps({
    vehicleTypes: Object,
    suppliers: Object,
    drivers: Object
});
console.log(props);
const step=useStorage('step',1)

let form=useForm({
    front_image: "",
    back_image: "",
    top_image:"",
    vehicle_reg_no: "",
    vehicle_type: null,
    driver:null,
    county:'', 
    subcounty:'',
    village:'',
    no_of_bags:'',
})

const submit=()=>{
   form.subcounty=locationStore.subcounty.id;
    form.county=locationStore.default_county.id;
    form.post(route('delivery.store'),{
        onSuccess:()=>{
            localStorage.removeItem('step')
            router.visit(route('delivery.index'))
        }
    })
}

const stepFront=(id: number)=>{
    step.value=id
}

const stepBack=(id: number)=>{
    step.value=id
}

onMounted(()=>{
    if (locationStore.default_county){
        locationStore.getSubcounties(locationStore.default_county.id)
    }
})
</script>

<template>
    <Head title="Add Delivery" />
    <admin>
        <div class="my-3">
            <div>
                <h1 class="text-2xl font-bold">Add a Delivery</h1>
            </div>
            <div class="my-5">
                <div  class="grid grid-cols-6 gap-3">
                <div class="col-span-6 md:col-span-2 p-0 md:p-5">
                    <div class="md:space-y-5 grid grid-cols-3 md:grid-cols-1">
                        <div class="block md:flex gap-2">
                            <div class="pt-1">
                                <svg class="h-5 fill-sumo-300" :class="[(step!==1?'fill-green-400':'')]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M335 175L224 286.1L176.1 239c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94l64 64C211.7 341.7 217.8 344 224 344s12.28-2.344 16.97-7.031l128-128c9.375-9.375 9.375-24.56 0-33.94S344.4 165.7 335 175zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z"/></svg>
                            </div>
                            <div class="self-start">
                                <h3 class="font-bold text-base md:text-xl font-slab">Register Vehicle</h3>
                                <p class="text-[15px] hidden">General information about the property such as name, type & location</p>
                            </div>
                        </div>

                        <div class="block md:flex gap-2" :class="[(step >=2?'':'text-gray-400')]">
                            <div class="pt-1">
                                <svg class="h-5 fill-sumo-300" :class="[(step>2?'fill-green-400':'')]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M335 175L224 286.1L176.1 239c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94l64 64C211.7 341.7 217.8 344 224 344s12.28-2.344 16.97-7.031l128-128c9.375-9.375 9.375-24.56 0-33.94S344.4 165.7 335 175zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z"/></svg>
                            </div>
                            <div class="self-start">
                                <h3 class="font-bold text-base md:text-xl font-slab ">Driver</h3>
                                <p class="text-[15px] hidden">Add property owner and building manager if available. Add property to a
                                    portfolio</p>
                            </div>
                        </div>

                        <div class="block md:flex gap-2" :class="[(step >=3?'':'text-gray-400')]">
                            <div class="pt-1">
                                <svg class="h-5 fill-sumo-300" :class="[(step>3?'fill-green-400':'')]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M335 175L224 286.1L176.1 239c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94l64 64C211.7 341.7 217.8 344 224 344s12.28-2.344 16.97-7.031l128-128c9.375-9.375 9.375-24.56 0-33.94S344.4 165.7 335 175zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z"/></svg>
                            </div>
                            <div class="self-start">
                                <h3 class="font-bold text-base md:text-xl font-slab ">Cargo Registration</h3>
                                <p class="text-[15px] hidden">Add property owner and building manager if available. Add property to a
                                    portfolio</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-6 md:col-span-4 p-5 ">
                    <div>
                        <form id="step-three-form" @submit.prevent="submit">
                        <div v-if="step===1">
                            <h2 class="font-slab font-bold text-xl">Step 1: Register Vehicle</h2>
                            <div class="px-2">
                                <!-- <step-one :vehicleTypes="vehicleTypes"></step-one> -->
                                <div class="my-5">
                                    <div>
                                        <div class="my-5">
                                            <hr class="my-3">
                                            <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-3">
                                                <div>
                                                    <label class="sumo-label" for="vehicle">Vehicle Type:</label>
                                                    <select v-model="form.vehicle_type" id="timeslot" class="sumo-input my-2">
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
                                                    <label for="email" class="text-sm font-medium text-gray-700">Front Image</label>
                                                    <input @input="form.front_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                                    <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                                        <span class="text-xs">{{form.errors.front_image }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label for="email" class="text-sm font-medium text-gray-700">Back Image</label>
                                                    <input @input="form.back_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                                    <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                                        <span class="text-xs">{{form.errors.back_image }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label for="email" class="text-sm font-medium text-gray-700">Top Image</label>
                                                    <input @input="form.top_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                                    <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                                        <span class="text-xs">{{form.errors.top_image }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-3 flex justify-end p-2">
                                    <button form="step-one-form" type="button" @click="stepFront(2)" class="btn-primary flex">
                                        Next <span class="ml-5">
                                            <svg class="fill-white h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/></svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div v-if="step===2">
                            <h2 class="font-slab font-bold text-xl">Step 2: Driver</h2>
                            <div class=" px-2">
                                <!-- <step-two :drivers="drivers"></step-two> -->
                                <div class="my-5">
                                    <div>
                                        <div class="mb-30">
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
                                        <div v-if="form.errors.driver" class="mt-3 text-red-800 text-sm">
                                            <span class="text-xs">{{form.errors.driver}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-3 flex justify-end gap-3">
                                    <button type="button" @click="stepBack(1)" class="self-center font-medium flex">
                                        <span class="mr-3">
                                            <svg class="fill-gray-800 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                <path d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"/>
                                            </svg>
                                        </span>
                                        Previous
                                    </button>
                                    <button form="step-two-form"  type="button" @click="stepFront(3)" class="btn-primary flex">
                                        Next 
                                        <span class="ml-5">
                                            <svg class="fill-white h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div v-if="step===3">
                            <h2 class="font-slab font-bold text-xl">Step 3: Cargo Registration</h2>
                            <div class=" px-2">
                                <!-- <step-three ></step-three> -->
                                <div class="my-5">
                                    <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-3">
                                                <div>
                                                    <label for="county" class="text-sm font-medium text-gray-700">County</label>
                                                    <county-select
                                                                placeholder="Select County"
                                                                :searchable="true" class="my-2"></county-select>
                                                    <div class="sumo-error" v-if="form.errors.county"> {{ form.errors.county }} </div>
                                                </div>
                                                <div>
                                                    <label class="sumo-label flex items-center gap-2">
                                                        <span>Subcounty</span>
                                                        <svg v-if="locationStore.loading && !locationStore.subcounties" class="w-5 fill-sumo-300 animate-pulse" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400 256c0 26.5 21.5 48 48 48s48-21.5 48-48S474.5 208 448 208S400 229.5 400 256zM112 256c0-26.5-21.5-48-48-48S16 229.5 16 256S37.5 304 64 304S112 282.5 112 256zM304 256c0-26.5-21.5-48-48-48S208 229.5 208 256S229.5 304 256 304S304 282.5 304 256z"/></svg>
                                                    </label>
                                                    <label for="subcounty" class="text-sm font-medium text-gray-700"></label>
                                                    <subcounty-select
                                                                placeholder="Select Subcounty"
                                                                :searchable="true"
                                                                :disabled="!locationStore.default_county"
                                                                class="my-2"></subcounty-select>
                                                    <div class="sumo-error" v-if="form.errors.subcounty"> {{ form.errors.subcounty }} </div>
                                                </div>
                                                <div>
                                                    <label for="village" class="text-sm font-medium text-gray-700">Village</label>
                                                    <input v-model="form.village" class="sumo-input my-2" id="village" type="text">
                                                    <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                                        <span class="text-xs">{{form.errors.village }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label for="no_of_bags" class="text-sm font-medium text-gray-700">No of Bags</label>
                                                    <input v-model="form.no_of_bags" class="sumo-input my-2" id="no_of_bags" type="text">
                                                    <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                                        <span class="text-xs">{{form.errors.no_of_bags }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                                <ul v-if="form.errors" class="list-inside sumo-error list-disc">
                                    <li class="text-xs block py-2" v-for="error in form.errors">{{error}}</li>
                                </ul>
                                
                                <div class="my-3 flex justify-end gap-3">
                                    <button type="button" @click="stepBack(2)" class="self-center font-medium flex">
                                        <span class="mr-3">
                                            <svg class="fill-gray-800 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                <path d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"/>
                                            </svg>
                                        </span>
                                        Previous
                                    </button>
                                    <button form="step-three-form"  type="submit" class="btn-primary flex">
                                        Submit 
                                        <span class="ml-5">
                                            <svg class="fill-white h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- <div v-if="step===3">
                            <h2 class="font-slab font-bold text-xl">Step 3: Facilities & Amenities</h2>
                            <div class="  px-2">
                                <step-three :facilities="facilities"></step-three>
                            </div>
                        </div>
                        <div v-if="step===4">
                            <h2 class="font-slab font-bold text-xl">Step 4: Floors & Units</h2>
                            <div class="  px-2">
                                <step-four :floor_types="floor_types"></step-four>
                            </div>
                        </div>
                        <div v-if="step===5">
                            <h2 class="font-slab font-bold text-xl">Step 4: Property Images</h2>
                            <div class="px-2">
                                <step-five></step-five>
                            </div>
                        </div> -->
                        </form>
                    </div>
                </div>
            </div>
                <!--  -->
            </div>
            
        </div>
    </admin>
</template>

<style scoped></style>
