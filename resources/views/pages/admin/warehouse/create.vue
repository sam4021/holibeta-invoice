<script setup lang="ts">
import Admin from "@/views/layouts/admin.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { computed,watch, onMounted, ref } from "vue";
import {useStorage} from "@vueuse/core";
import VueSelect from "@/views/components/general-components/vue-select.vue";

let props = defineProps({
    qcs: Object,
});
console.log(props)
let form = useForm({
    quality_control:null, 
    no_of_bags:"", 
    bags:"",
});

let itemForm = useForm({
    'weight':'',
    'id':'',
})

watch(()=>form.no_of_bags,()=>{
    if(form.no_of_bags){
        removeAllItems()
        for (let i = 0; i < form.no_of_bags; i++) {
            addRow();
        }
    }
})

const addRow=()=> {
    var weight = '';
    var id = Math.floor(Math.random() * 400);
    transactionItem.value.push({id:id,weight:weight})
}
const removeItem=(item:string)=>{
    transactionItem.value=transactionItem.value.filter(element =>element.id!==item)
}
const removeAllItems=()=>{
    transactionItem.value.forEach(el => {
        removeItem(el.id)
    });
}

const transactionItem=useStorage('transactionItem',[])

const submit = () => {
    form.bags = transactionItem.value
    form.post(route('warehouse.store'),{
        preserveScroll:true,
        onSuccess:()=>{
            show.value=false
            form.reset()

        }
    })
}

onMounted(() => {
    removeAllItems()
})
</script>

<template>
    <Head title="Add Warehouse" />
    <admin>
        <div class="my-3">
            <div>
                <h1 class="text-2xl font-bold">Add Warehouse</h1>
            </div>
            <div class="my-5">
                <form @submit.prevent="submit" id="saveFacilities">
                    <div class="mx-0 md:mx-6 grid grid-cols-1 md:grid-cols-4 gap-3">
                        <div>
                            <label class="sumo-label" for="quality_control">Quality Control:</label>
                            <vue-select
                            :searchable="true"
                            v-model:selected="form.quality_control"
                            :options="qcs"
                            placeholder="Select Delivery"
                            class="my-2"
                        ></vue-select>
                            <div class="sumo-error" v-if="form.errors.quality_control">
                                {{ form.errors.quality_control }}
                            </div>
                        </div>
                        <div>
                            <label for="no_of_bags" class="text-sm font-medium text-gray-700">No of Bags</label>
                            <input v-model="form.no_of_bags" type="text" id="name" name="no_of_bags" class="sumo-input my-2">
                            <div class="sumo-error" v-if="form.errors.no_of_bags">
                                {{ form.errors.no_of_bags }}
                            </div>
                        </div>
                        <div class="col-span-3">
                            <div>
                                <div class="sumo-error" v-if="form.errors.bags">
                                    {{ form.errors.bags }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-1 my-5">
                            <div class="grid grid-cols-2 gap-2">
                                <h3 class="text-x2 font-bold">Items</h3>
                                <div class="text-right px-4">
                                    <!-- <button  @click="addRow" type="button" class="font-bold text-sumo-700">
                                        <svg class="h-4 fill-sumo-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                          <path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"/>
                                        </svg>
                                       <span>Add Bag</span>
                                    </button> -->
                                </div>
                            </div>
                            <div class="mt-3 text-red-800 text-sm">
                                <span class="text-xs">{{form.errors.bags }}</span>
                            </div>
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg py-3">
                                <div class="grid grid-cols-2 md:grid-cols-3">
                                     <div v-for="(item, index) in transactionItem" :key="index" class="p-2">
                                        <div class="grid grid-cols-4">
                                            <div class="col-span-3">
                                                <label for="no_of_bags" class="text-sm font-medium text-gray-700">Weight</label>
                                                <input type="number" class="sumo-input my-3" v-model="item.weight" required>
                                            </div>
                                            <div>
                                                <button type="button" @click="removeItem(item.id)" class="text-red-600 flex gap-2 items-center pt-12 pl-4">
                                                    <svg class="h-4 fill-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                    <path d="M432 80h-82.38l-34-56.75C306.1 8.827 291.4 0 274.6 0H173.4C156.6 0 141 8.827 132.4 23.25L98.38 80H16C7.125 80 0 87.13 0 96v16C0 120.9 7.125 128 16 128H32v320c0 35.35 28.65 64 64 64h256c35.35 0 64-28.65 64-64V128h16C440.9 128 448 120.9 448 112V96C448 87.13 440.9 80 432 80zM171.9 50.88C172.9 49.13 174.9 48 177 48h94c2.125 0 4.125 1.125 5.125 2.875L293.6 80H154.4L171.9 50.88zM352 464H96c-8.837 0-16-7.163-16-16V128h288v320C368 456.8 360.8 464 352 464zM224 416c8.844 0 16-7.156 16-16V192c0-8.844-7.156-16-16-16S208 183.2 208 192v208C208 408.8 215.2 416 224 416zM144 416C152.8 416 160 408.8 160 400V192c0-8.844-7.156-16-16-16S128 183.2 128 192v208C128 408.8 135.2 416 144 416zM304 416c8.844 0 16-7.156 16-16V192c0-8.844-7.156-16-16-16S288 183.2 288 192v208C288 408.8 295.2 416 304 416z"/>
                                                    </svg>
                                                    <span class="hidden">Remove</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="my-5 flex justify-end">
                        <button :disabled="form.processing" type="submit" class="btn-primary flex gap-2 items-center">
                            <span>Save Warehouse</span>
                            <svg v-if="form.processing" class="fill-white w-5 animate-ping" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" >
                                <path d="M400 256c0 26.5 21.5 48 48 48s48-21.5 48-48S474.5 208 448 208S400 229.5 400 256zM112 256c0-26.5-21.5-48-48-48S16 229.5 16 256S37.5 304 64 304S112 282.5 112 256zM304 256c0-26.5-21.5-48-48-48S208 229.5 208 256S229.5 304 256 304S304 282.5 304 256z"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </admin>
</template>

<style scoped></style>
