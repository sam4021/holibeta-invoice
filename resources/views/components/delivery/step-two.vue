<template>
    <div class="overflow-y-auto custom-scrolling">
        <form id="step-two-form" @submit.prevent="submit">
            <hr class="my-3">
            <div class="my-5">
                <div>
                                <label class="sumo-label" for="supplier">Supplier:</label>
                                <vue-select
                                    :searchable="true"
                                    v-model:selected="stepTwo.supplier"
                                    :options="suppliers.data"
                                    placeholder="Select Supplier"
                                    class=""
                                ></vue-select>
                                <div class="sumo-error" v-if="form.errors.supplier">
                                    {{ form.errors.supplier }}
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
                                <label for="email" class="text-sm font-medium text-gray-700">Top Image</label>
                                <input @input="stepTwo.top_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.top_image }}</span>
                                </div>
                            </div>
                            <div>
                                <label for="email" class="text-sm font-medium text-gray-700">Side Image</label>
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

let props=defineProps({
    suppliers:Object
})
console.log(props)

const step=useStorage('step',1)
const stepTwo=useStorage('stepTwo',{
    supplier: null,
    front_image: "",
    back_image: "",
    side_image: "",
    top_image:"",
})
const stepOne=useStorage('stepOne',{})

let form=useForm({
    supplier: null,
    front_image: "",
    back_image: "",
    side_image: "",
    top_image:"",
    stepOne:stepOne.value,
})
const submit=()=>{
    form.supplier= stepTwo.value.supplier;
    form.front_image= stepTwo.value.front_image;
    form.back_image= stepTwo.value.back_image;
    form.side_image= stepTwo.value.side_image;
    form.top_image= stepTwo.value.top_image;
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
