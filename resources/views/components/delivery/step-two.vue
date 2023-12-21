<template>
    <div class="overflow-y-auto custom-scrolling h-72">
        <form id="step-two-form" @submit.prevent="submit">
            <hr class="my-3">
            <div class="my-5">
                <div>
                                <div class="mb-30">
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
            </div>
        </form>
    </div>

    <div class="my-3 flex justify-end gap-3">
        <button type="button" @click="stepBack" class="self-center font-medium flex">
            <span class="mr-3">
                <svg class="fill-gray-800 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"/>
                </svg>
            </span>
            Previous
        </button>
        <button form="step-two-form"  type="submit" class="btn-primary flex">
            Next 
            <span class="ml-5">
                <svg class="fill-white h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/>
                </svg>
            </span>
        </button>
    </div>
</template>

<script setup lang="ts">

import {useForm} from "@inertiajs/vue3";
import VueSelect from "@/views/components/general-components/vue-select.vue";
import {ref, onMounted} from "vue";
import {useStorage} from "@vueuse/core";
import CreateDriver from "@/views/components/driver/create.vue";

defineProps({
    drivers:Object,
})

const search=ref('')
const step=useStorage('step',1)
const stepTwo=useStorage('stepTwo',{
    driver:undefined,
})
const stepOne=useStorage('stepOne',{})

let form=useForm({
    driver:null,
    stepOne:stepOne.value,
})
const submit=()=>{
    form.driver= stepTwo.value.driver;
    form.post(route('delivery.step-two'),{
        onSuccess:()=>{
            step.value=3
        }
    })
}

const stepBack=()=>{
    step.value=1
}

</script>

<style scoped>

</style>
