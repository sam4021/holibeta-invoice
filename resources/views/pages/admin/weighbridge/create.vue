<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, Link} from "@inertiajs/vue3";
import {watch, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import VueSelect from "@/views/components/general-components/vue-select.vue";
import CreateSupplier from "@/views/components/supplier/create.vue";

let props = defineProps({
    deliveries: Object,
    suppliers: Object
})
console.log(props)
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

<template>
    <Head title="Weighbridge" />
<admin>
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold capitalize">Add Weighbridge</h1>
        </div>
        <div class="flex gap-2">
           <div>
               
           </div>
            <div>
                
            </div>
        </div>
    </div>

    <div class="my-5">
        <form @submit.prevent="submit" id="saveFacilities">
            <div class="mx-6 grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="sumo-label" for="delivery">Delivery:</label>
                    <vue-select
                            :searchable="true"
                            v-model:selected="form.delivery"
                            :options="deliveries.data"
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
                <div class="col-span-2">
                    <label class="sumo-label" for="delivery">Suppliers:</label>
                    <div class="my-2 md:flex gap-2">
                        <vue-select
                            :searchable="true"
                            v-model:selected="form.supplier"
                            :options="suppliers.data"
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
            </div>
            <div class="my-5 flex justify-end">
                <button :disabled="form.processing" type="submit" class="btn-primary flex gap-2 items-center">
                    <span>Save Weighbridge</span>
                    <svg v-if="form.processing" class="fill-white w-5 animate-ping" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" >
                        <path d="M400 256c0 26.5 21.5 48 48 48s48-21.5 48-48S474.5 208 448 208S400 229.5 400 256zM112 256c0-26.5-21.5-48-48-48S16 229.5 16 256S37.5 304 64 304S112 282.5 112 256zM304 256c0-26.5-21.5-48-48-48S208 229.5 208 256S229.5 304 256 304S304 282.5 304 256z"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</admin>
</template>

<style scoped>

</style>
