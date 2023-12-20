<template>
<div @click="show=true">
        <slot name="trigger"></slot>
    </div>
    <teleport to="body">
        <Transition
            enter-from-class="opacity-0 scale-125"
            enter-to-class="opacity-100 scale-100"
            enter-active-class="transition duration-300"
            leave-active-class="transition duration-200"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-125"
        >
            <div @click.self="show=false" v-if="show" class="inset-0 fixed bg-black bg-opacity-40 z-[100000] grid place-items-center p-5">
                <div class="bg-white lg:w-1/2 w-full rounded-xl">
                    <header class="p-3">
                        <div class="flex justify-between">

                            <slot name="header">
                                <div class="font-bold text-sumo-300 text-lg">
                                    <h6>Create Weighbridge</h6>
                                </div>
                            </slot>
                            <div>
                                <div class="text-end">
                                    <button type="button" @click="show=false" class="rounded-full bg-sky-700 h-7 w-7 flex place-content-center">
                                        <svg class="h-5 fill-white self-center" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </header>
                    <hr>
                    <div class="p-3.5">

                        <form @submit.prevent="submit" id="saveFacilities">
                            <div class="mx-6 grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="col-span-2">
                                    <label class="sumo-label" for="delivery">Suppliers:</label>
                                    <div class="my-2 md:flex gap-2">
                                        <vue-select
                                            :searchable="true"
                                            v-model:selected="form.supplier"
                                            :options="suppliers"
                                            placeholder="Select Supplier"
                                            class="my-2 w-2/4"
                                        ></vue-select>
                                        <create-supplier>
                                            <template #trigger>
                                                <button class="btn-simple flex items-center gap-2 text-sumo-300 mt-2">
                                                    <svg class="h-4 fill-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                        <path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"/>
                                                    </svg>
                                                    <span> New Supplier</span>
                                                </button>
                                            </template>
                                        </create-supplier>
                                    </div>
                                    
                                    
                                    <div class="sumo-error" v-if="form.errors.supplier">
                                        {{ form.errors.supplier }}
                                    </div>
                                </div>
                                <div>
                                    <label class="sumo-label" for="delivery">Delivery:</label>
                                    <vue-select
                                            :searchable="true"
                                            v-model:selected="form.delivery"
                                            :options="deliveries"
                                            placeholder="Select Delivery"
                                            class="my-2"
                                        ></vue-select>
                                    
                                    <div class="sumo-error" v-if="form.errors.delivery">
                                        {{ form.errors.delivery }}
                                    </div>
                                </div>
                                <div>
                                    <label for="weight" class="text-sm font-medium text-gray-700">Weight</label>
                                    <input v-model="form.weight" type="text" id="name" name="weight" class="sumo-input my-2">
                                    <div class="sumo-error" v-if="form.errors.weight">
                                        {{ form.errors.weight }}
                                    </div>
                                </div>
                                <div>
                                    <label for="image" class="text-sm font-medium text-gray-700">Image</label>
                                    <input @input="form.image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none my-2" id="image" type="file">
                                    <div v-if="form.errors.image" class="mt-3 text-red-800 text-sm">
                                        <span class="text-xs">{{form.errors.image }}</span>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    <hr>
                    <footer class="p-3.5">
                        <div class="flex justify-end">
                            <button form="saveFacilities" type="submit" class="btn-primary btn-medium">Save Weighbridge</button>
                        </div>
                    </footer>
                </div>
            </div>
        </Transition>
    </teleport>
</template>

<script setup lang="ts">
import {watch, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import VueSelect from "@/views/components/general-components/vue-select.vue";
import CreateSupplier from "@/views/components/supplier/create.vue";

let props=defineProps({
    deliveries: Object,
    suppliers: Object
})

const show=ref(false)

watch(show,(val)=>{
    if(val){
        document.body.style.overflow='hidden'
    }else{
        document.body.style.overflow='auto'
    }
})

let form=useForm({
    delivery:null, 
    weight:"", 
    image:"",
    supplier:null
})

const submit = () => {
    form.post(route('weighbridge.store'),{
        preserveScroll:true,
        onSuccess:()=>{
            show.value=false
            form.reset()

        }
    })
}
</script>