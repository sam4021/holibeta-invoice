<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, Link, router,useForm} from "@inertiajs/vue3";
import {ref, PropType, watch} from "vue";

import {useStorage} from "@vueuse/core";
import CountrySelect from "@/views/components/general-components/country-select.vue";
import CitiesSelect from "@/views/components/general-components/cities-select.vue";
import OrderSelect from "@/views/components/order/order-select.vue";
import VueSelect from "@/views/components/general-components/vue-select.vue";
import {useOrderGetStore} from "@/scripts/store/orderStore";

const orderStore=useOrderGetStore()
const search=ref('')
const orderItems=useStorage('orderItems',[])

let props=defineProps({
    types: Object
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
    transaction_type:null,
    order: null,
    amount: 0
})

const submit = () => {
    form.order_items = orderItems.value
    form.post(route('transactions.store'),{
        preserveScroll:true,
        onSuccess:()=>{
            form.reset()
            localStorage.removeItem('orderItems')
            router.visit(route('transactions.index'))
        }
    })
}



watch(()=>orderItems.value,()=>{    
    getTotal();
})

const getTotal=()=>{    
    let total = 0;
    orderItems.value.forEach(el => {
        if (el.weight){
            let weight = parseFloat(el.weight);
            total = weight + total;
        }
    });
    form.total_weight = total.toFixed(2)
}

watch(()=>form.transaction_type,()=>{
    if(form.transaction_type){
    console.log(form.transaction_type);
    
    }
});

watch(()=>form.order,()=>{
    if(form.order){
        orderStore.getOrder(form.order)
        watch(()=>orderStore.order,()=>{
            form.amount = orderStore.order.amount
        })
    }
})
</script>

<template>
    <Head title="New Transaction" />
<admin>
    <div class="my-3">
            <div>
                <h1 class="text-2xl font-bold">New Transaction</h1>
            </div>
            <div class="my-5">
                <form @submit.prevent="submit" id="saveFacilities">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <div>
                                    <label class="sumo-label" for="transaction_type">Transaction Type:</label>
                                    <select class="sumo-input my-3" v-model="form.transaction_type" required>
                                        <option selected :value="null">Select Type</option>
                                        <option :value="type" :key="index" v-for="(type, index) in types">{{type}}</option>
                                    </select>
                                    <div v-if="form.errors.transaction_type" class="mt-3 text-red-800 text-sm">
                                        <span class="text-xs">{{form.errors.transaction_type }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label for="name" class="text-sm font-medium text-gray-700">Order</label>
                                    <order-select :searchable="true" v-model:selected="form.order"
                                    placeholder="Select Order" class="my-2"></order-select>
                        
                                    <div class="sumo-error" v-if="form.errors.order">
                                        {{ form.errors.order }}
                                    </div>
                                </div>
                               
                                <div>
                                    <label for="amount" class="text-sm font-medium text-gray-700">Amount</label>
                                    <input v-model="form.amount" type="text" id="amount" class="sumo-input my-2">
                                    <div class="sumo-error" v-if="form.errors.amount">
                                        {{ form.errors.amount }}
                                    </div>
                                </div>
                               
                            </div>
                            <div class="my-5 rounded-lg">
                
                
                
            </div>
                            <div class="my-5 flex justify-end">
                        <button
                            :disabled="form.processing"
                            type="submit"
                            class="btn-primary flex gap-2 items-center"
                        >
                            <span>Save Transaction</span>
                            <svg
                                v-if="form.processing"
                                class="fill-white w-5 animate-ping"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"
                            >
                                <path
                                    d="M400 256c0 26.5 21.5 48 48 48s48-21.5 48-48S474.5 208 448 208S400 229.5 400 256zM112 256c0-26.5-21.5-48-48-48S16 229.5 16 256S37.5 304 64 304S112 282.5 112 256zM304 256c0-26.5-21.5-48-48-48S208 229.5 208 256S229.5 304 256 304S304 282.5 304 256z"
                                />
                            </svg>
                        </button>
                    </div>
                        </form>
                
            </div>
        </div>
</admin>
</template>

<style scoped>

</style>


