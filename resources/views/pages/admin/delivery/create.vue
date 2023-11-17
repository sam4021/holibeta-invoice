<script setup lang="ts">
import Admin from "@/views/layouts/admin.vue";
import { Head, useForm, usePage, router } from "@inertiajs/vue3";
import { ref } from "vue";
import {useStorage} from "@vueuse/core";
import StepOne from "@/views/components/delivery/step-one.vue";
import StepTwo from "@/views/components/delivery/step-two.vue";

let props = defineProps({
    vehicles: Object,
    suppliers: Object,
    drivers: Object,
    grains: Object
});
console.log(props);
const step=useStorage('step',1)

let form = useForm({
    supplier: null,
    vehicle_reg_no: "",
    vehicle: null,
    front_image: "",
    back_image: "",
    side_image: ""
});

const submit=()=>{
   
    form.post(route('delivery.store'),{
        onSuccess:()=>{
            router.visit(route('delivery.index'))
        }
    })
}
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
                <div class="col-span-2 space-y-5 p-5">
                    <div class="flex gap-2">
                        <div class="pt-1">
                            <svg class="h-5 fill-sumo-300" :class="[(step!==1?'fill-green-400':'')]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M335 175L224 286.1L176.1 239c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94l64 64C211.7 341.7 217.8 344 224 344s12.28-2.344 16.97-7.031l128-128c9.375-9.375 9.375-24.56 0-33.94S344.4 165.7 335 175zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z"/></svg>
                        </div>
                        <div class="self-start">
                            <h3 class="font-bold text-xl font-slab">Step 1: Security Check</h3>
                            <p class="text-[15px] hidden">General information about the property such as name, type & location</p>
                        </div>
                    </div>

                    <div class="flex gap-2" :class="[(step >=2?'':'text-gray-400')]">
                        <div class="pt-1">
                            <svg class="h-5 fill-sumo-300" :class="[(step>2?'fill-green-400':'')]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M335 175L224 286.1L176.1 239c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94l64 64C211.7 341.7 217.8 344 224 344s12.28-2.344 16.97-7.031l128-128c9.375-9.375 9.375-24.56 0-33.94S344.4 165.7 335 175zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z"/></svg>
                        </div>
                        <div class="self-start">
                            <h3 class="font-bold text-xl font-slab ">Step 2: Delivery</h3>
                            <p class="text-[15px] hidden">Add property owner and building manager if available. Add property to a
                                portfolio</p>
                        </div>
                    </div>

                    <!-- <div class="flex gap-2" :class="[(step >=3?'':'text-gray-400')]">
                        <div class="pt-1" >
                            <div class="pt-1">
                                <svg class="h-5 fill-sumo-300" :class="[(step>3?'fill-green-400':'')]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M335 175L224 286.1L176.1 239c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94l64 64C211.7 341.7 217.8 344 224 344s12.28-2.344 16.97-7.031l128-128c9.375-9.375 9.375-24.56 0-33.94S344.4 165.7 335 175zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z"/></svg>
                            </div>
                        </div>
                        <div class="self-start">
                            <h3 class="font-bold text-xl font-slab">Step 3: Facilities & Amenities</h3>
                            <p class=" text-[15px]">Add facilities such swimming pools, common areas, and gym</p>
                        </div>
                    </div>

                    <div class="flex gap-2" :class="[(step >=4?'':'text-gray-400')]">
                        <div class="pt-1">
                            <svg class="h-5 fill-sumo-300" :class="[(step>4?'fill-green-400':'')]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M335 175L224 286.1L176.1 239c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94l64 64C211.7 341.7 217.8 344 224 344s12.28-2.344 16.97-7.031l128-128c9.375-9.375 9.375-24.56 0-33.94S344.4 165.7 335 175zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z"/></svg>
                        </div>
                        <div class="self-start">
                            <h3 class="font-bold text-xl font-slab">Step 4: Floors & Units</h3>
                            <p class="text-[15px]">Add units, blocks and floor details within the property</p>
                        </div>
                    </div>

                    <div class="flex gap-2" :class="[(step >=5?'':'text-gray-400')]">
                        <div class="pt-1">
                            <h3 class="text-xl  font-bold" :class="[(step >5?'text-green-400':'text-gray-400')]">
                                <span ><i class="fa-regular fa-circle-check"></i></span></h3>
                        </div>
                        <div class="self-start">
                            <h3 class="font-bold text-xl font-slab">Step 5: Property Images</h3>
                            <p class="text-[15px]">Add property images</p>
                        </div>
                    </div> -->

                </div>
                <div class="col-span-4 p-5 ">

                    <div>
                        <div v-if="step===1">
                            <h2 class="font-slab font-bold text-xl">Step 1: Security Check</h2>
                            <div class="px-2">
                                <step-one  :suppliers="suppliers" :vehicles="vehicles" :grains="grains"></step-one>
                            </div>
                        </div>

                        <div v-if="step===2">
                            <h2 class="font-slab font-bold text-xl">Step 2: Delivery</h2>
                            <div class=" px-2">
                                <step-two :drivers="drivers"></step-two>
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
                    </div>





                </div>

            </div>
                <!--  -->
            </div>
        </div>
    </admin>
</template>

<style scoped></style>
