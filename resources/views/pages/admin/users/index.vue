<script setup lang="ts">
import {onMounted,ref, watch, PropType} from "vue";
import { initFlowbite } from 'flowbite'
import {Head, Link, router} from "@inertiajs/vue3";
import Admin from "@/views/layouts/admin.vue";
import {debounce} from 'lodash';

onMounted(() => {
    initFlowbite();
})

export interface Filters{
    showing: number
    search: string
    type: string
}
let props=defineProps({
    users:Object,
    filters:{
        type: Object as PropType<Filters>,
        required: true,
    },
})

const initiateDelete=(id:number)=>{
    router.delete(route('admin.users.destroy',id))
}

const showing=ref(props.filters.showing?props.filters.showing:10)
const search=ref(props.filters.search?props.filters.search:'')

const clearFilter=()=>{
    router.get(route('admin.users.index'))
}

watch(search,debounce(function () {
    router.get(route('admin.users.index'),{
        search:search.value,
        showing:showing.value,
    },{
        preserveState:true, preserveScroll:true, replace: true,
    });
}, 300))
watch(showing,debounce(function () {
    router.get(route('admin.users.index'),{
        search:search.value,
        showing:showing.value,
    },{
        preserveState:true, preserveScroll:true, replace: true,
    });
}, 300))

</script>

<template>
    <Head>
        <title>Users</title>
    </Head>
  <admin>
    <div>
        <div class="border rounded shadow mt-9">
            <div>
                <div class="relative">
                    <table class="w-full text-sm text-left text-gray-700 font-medium">
                        <thead class="text-xs text-sumo-300 uppercase bg-sumo-500/20">
                        <tr>
                            <th scope="col" class="px-2 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-2 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-2 py-3">
                               Role
                            </th>
                            <th scope="col" class="px-2 py-3">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="[&>*:nth-child(even)]:bg-gray-100">
                        <tr class="border-b" v-for="user in users.data" :key="user.id">
                            <th scope="row" class="px-2 py-3 font-semibold text-sumo-800 whitespace-nowrap">
                                {{user.name}}
                            </th>
                            <th scope="row" class="px-2 py-3 font-semibold text-sumo-800 whitespace-nowrap">
                                {{user.email}}
                            </th>
                            <th scope="row" class="px-2 py-3 font-semibold text-sumo-800 whitespace-nowrap">
                               
                            </th>
                            <td class="px-2 py-3">
                                <button :id="'dropdownDefaultButton'+user.id" :data-dropdown-toggle="'dropdown'+user.id" data-dropdown-placement="bottom-end" class="" type="button">
                                  Action<span class="ml-2"><i class="fa-solid fa-ellipsis-vertical"></i></span>
                                </button>
                                <div :id="'dropdown'+user.id" class="z-10 hidden bg-white  rounded-lg shadow w-44 ">
                                    <ul class="py-2 text-sm text-gray-700 bg-sumo-500/20 overflow-hidden divide-y" :aria-labelledby="'dropdownDefaultButton'+user.id">
                                        <li>
                                            <Link :href="route('admin.users.show',user.id)" class="block w-full h-full text-start px-4 py-2 hover:bg-sumo-500/50">Show User</Link>
                                        </li>
                                        <li>
                                            <edit :user="user">
                                                <template #trigger>
                                                    <button  class="block w-full h-full text-start px-4 py-2 hover:bg-sumo-500/50 ">Edit User</button>
                                                </template>
                                            </edit>
                                        </li>
                                        <li>
                                            <button @clock="initiateDelete(user.id)" class="block w-full h-full text-start px-4 py-2 hover:bg-sumo-500/50 ">Delete User</button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--pagination-->
                    <!-- <data-pagination :data="accounts"></data-pagination> -->
                </div>
            </div>
        </div>
    </div>
  </admin>

</template>

<style scoped>

</style>
