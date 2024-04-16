<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, Link} from "@inertiajs/vue3";
import PromptAlert from "@/views/components/general-components/prompt-alert.vue";
import moment from "moment";
let props = defineProps({
    transaction:Object,
    customers: Object
})
console.log(props)
const deleteTransaction=(id:number)=>{
    router.delete(route('transaction.destroy',id))
};
</script>

<template>
    <Head :title="transaction.data.transaction_no" />
<admin>
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold capitalize">Transaction :: {{transaction.data.transaction_no}}</h1>
        </div>
        <div class="flex gap-2">
           <div>
            
               
           </div>
            <div>
                <prompt-alert
                    title="Are you sure you want to delete this transaction?"
                    description="All related data will be deleted"
                    @proceed="deleteTransaction(transaction.data.id)"
                >
                    <template #trigger>
                        <button class="btn-danger btn-medium">Delete</button>
                    </template>
                </prompt-alert>
            </div>
        </div>
    </div>
    <div class="my-5">
        <div class="shadow p-4 bg-white rounded-md">
            <div class="grid gap-3 grid-cols-2">
                <div class="my-3">
                    <table class="text-sm font-medium">
                        <tr>
                            <th class="text-start">Code:</th>
                            <td class="px-3">{{ transaction.data.transaction_no }}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Type:</th>
                            <td class="px-3">{{ transaction.data.transaction_type }}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Customer:</th>
                            <td class="px-3">{{ transaction.data.customer.name }}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Created by:</th>
                            <td class="px-3">{{ transaction.data.created_by.name }}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Date:</th>
                            <td class="px-3">{{ transaction.data.created_at }}</td>
                        </tr>
                        <tr>
                            <th class="text-start">Status:</th>
                            <td class="px-3">{{ transaction.data.current_status.status }}</td>
                        </tr>
                    </table>
                </div>
                
                <div class="my-3">
                    <table class="text-sm font-medium">
                        <tr>
                            <th class="text-start">Amount:</th>
                            <td class="px-3">{{transaction.data.amount}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="my-5">
        <div class="grid gap-3 grid-cols-1 sm:grid-cols-2">
            <div class="shadow p-4 bg-white rounded-md">
                <div class="my-3">
                    <h2 class="font-bold text-sm border-b pb-2 mb-4">Order</h2>
                    <table class="w-full text-sm text-left text-gray-700 font-medium">
                        <thead class="text-xs text-sky-700 uppercase bg-sky-50">
                        <tr>
                            <th scope="col" class="px-2 py-3">
                                Code
                            </th>
                            <th scope="col" class="px-2 py-3">
                                Ship Code
                            </th>
                            <th scope="col" class="px-2 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-2 py-3">
                                Date
                            </th>
                        </tr>
                        </thead>
                        <tbody class="[&>*:nth-child(even)]:bg-gray-100">
                        <tr class="border-b">
                            <th scope="row" class="px-2 py-3 font-semibold whitespace-nowrap text-xs">
                                {{transaction.data.order.code}}
                            </th>
                            <th scope="row" class="px-2 py-3 font-semibold whitespace-nowrap text-xs">
                                {{transaction.data.order.ship_code}}
                            </th>
                            <th scope="row" class="px-2 py-3 font-semibold whitespace-nowrap text-xs">
                                {{transaction.data.order.current_status.status}}
                            </th>
                            <th scope="row" class="px-2 py-3 font-semibold whitespace-nowrap text-xs">
                                {{transaction.data.order.created_at}}
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="shadow p-4 bg-white rounded-md">
                <div class="my-3">
                    <h2 class="font-bold text-sm border-b pb-2 mb-4">Order Status</h2>
                    <table class="w-full text-sm text-left text-gray-700 font-medium">
                        <thead class="text-xs text-sky-700 uppercase bg-sky-50">
                        <tr>
                            <th scope="col" class="px-2 py-3">
                                Status
                            </th>
                            <th>
                            Date
                            </th>
                        </tr>
                        </thead>
                        <tbody class="[&>*:nth-child(even)]:bg-gray-100">
                        <tr class="border-b" v-for="status in transaction.data.status" :key="status.id" >
                            <th scope="row" class="px-2 py-3 font-semibold whitespace-nowrap text-xs">
                                {{status.status}}
                            </th>
                            <th scope="row" class="px-2 py-3 font-semibold whitespace-nowrap text-xs">
                                {{ moment(status.created_at).format("DD MMM, YYYY") }}
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</admin>
</template>

<style scoped>

</style>
