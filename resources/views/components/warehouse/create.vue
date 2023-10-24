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
                                    <h6>Create Warehouse</h6>
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
                                <div>
                            <label class="sumo-label" for="supplier"
                                >Supplier:</label
                            >
                            <select v-model="form.supplier"
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
                                    <label for="no_of_bags" class="text-sm font-medium text-gray-700">No of Bags</label>
                                    <input v-model="form.no_of_bags" type="text" id="name" name="no_of_bags" class="sumo-input my-2">
                                    <div class="sumo-error" v-if="form.errors.no_of_bags">
                                        {{ form.errors.no_of_bags }}
                                    </div>
                                </div>
                                <div>
                                    <label for="weight_per_bag" class="text-sm font-medium text-gray-700">Weight per Bag</label>
                                    <input v-model="form.weight_per_bag" type="text" id="name" name="weight_per_bag" class="sumo-input my-2">
                                    <div class="sumo-error" v-if="form.errors.weight_per_bag">
                                        {{ form.errors.weight_per_bag }}
                                    </div>
                                </div>
                                <div>
                                    <label for="barcode_no" class="text-sm font-medium text-gray-700">Barcode No</label>
                                    <input v-model="form.barcode_no" type="text" id="name" name="barcode_no" class="sumo-input my-2">
                                    <div class="sumo-error" v-if="form.errors.barcode_no">
                                        {{ form.errors.barcode_no }}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <footer class="p-3.5">
                        <div class="flex justify-end">
                            <button form="saveFacilities" type="submit" class="btn-primary btn-medium">Save Warehouse</button>
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

let props=defineProps({
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
    supplier:null, 
    no_of_bags:"", 
    weight_per_bag:"", 
    barcode_no:""
})

const submit = () => {
    form.post(route('warehouse.store'),{
        preserveScroll:true,
        onSuccess:()=>{
            show.value=false
            form.reset()

        }
    })
}
</script>