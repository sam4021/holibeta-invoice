<template>
    <div class="overflow-y-auto custom-scrolling">
        <form id="step-two-form" @submit.prevent="submit">
            <hr class="my-3">
            <div class="my-5">
                <div>
                    <div>
                        <label class="sumo-label font-medium">Add Driver:</label>
                        <div class="my-2 md:flex gap-2">
                            <vue-select
                                :searchable="true"
                                v-model:selected="stepTwo.driver"
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
                <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-3">
                            <div class="col-span-2">
                                <hr class="my-5">
                                <h3 class="text-lg text-sumo-700">Cargo Images</h3>
                            </div>
                            <div>
                                <label for="email" class="text-sm font-medium text-gray-700">Front Image</label>
                                <input @input="stepTwo.front_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.front_image }}</span>
                                </div>
                            </div>
                            <div>
                                <label for="email" class="text-sm font-medium text-gray-700">Back Image</label>
                                <input @input="stepTwo.back_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.back_image }}</span>
                                </div>
                            </div>
                            <div>
                                <label for="email" class="text-sm font-medium text-gray-700">Top/Side Image</label>
                                <input @input="stepTwo.side_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.side_image }}</span>
                                </div>
                            </div>
                        </div>
                <div class="grid grid-cols-2">
                    
                    <div v-if="form.errors.property_owner" class="mt-3 text-red-800 text-sm">
                        <span class="text-xs">{{form.errors.property_owner}}</span>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="my-3 flex justify-end gap-3">
        <button type="button" @click="stepBack" class="self-center font-medium"><span class="mr-3"><i class="fa-light fa-arrow-left-long"></i></span>Previous</button>
        <button form="step-two-form"  type="submit" class="btn-primary">Next <span class="ml-5"><i class="fa-light fa-arrow-right-long"></i></span></button>
    </div>

   
</template>

<script setup lang="ts">

import {useForm} from "@inertiajs/vue3";
import VueSelect from "@/views/components/general-components/vue-select.vue";
import {ref} from "vue";
import {useStorage} from "@vueuse/core";
import CreateDriver from "@/views/components/driver/create.vue";

let props=defineProps({
    drivers:Object,
})
console.log(props)

const step=useStorage('step',1)
const stepTwo=useStorage('stepTwo',{
    driver:undefined,
    front_image: "",
    back_image: "",
    side_image: ""
})
const stepOne=useStorage('stepOne',{})

let form=useForm({
    driver:null,
    front_image: "",
    back_image: "",
    side_image: "",
    stepOne:stepOne.value,
})
const submit=()=>{
    form.driver= stepTwo.value.driver;
    form.front_image= stepTwo.value.front_image;
    form.back_image= stepTwo.value.back_image;
    form.side_image= stepTwo.value.side_image;
    form.post(route('delivery.store'),{
        onSuccess:()=>{
            localStorage.removeItem('stepOne')
            localStorage.removeItem('stepTwo')
            localStorage.removeItem('step')
            router.visit(route('delivery.index'))
        }
    })
}

const createOwnerModal=ref(false)
const createPortfolioModal=ref(false)
const stepBack=()=>{
    step.value=1
}
</script>

<style scoped>

</style>
