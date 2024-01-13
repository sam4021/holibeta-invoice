<script setup lang="ts">
import {onMounted} from "vue";
import { initFlowbite } from 'flowbite'
import {Head, Link} from "@inertiajs/vue3";
import Admin from "@/views/layouts/admin.vue";
import GrainsWidgets from "@/views/components/widgets/grains-widget.vue";
import WeightWidget from "@/views/components/widgets/weight-widget.vue";
import BagWidget from "@/views/components/widgets/bag-widget.vue";

defineProps({
    suppliers:Number,
    drivers: Number
})
onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <Head>
        <title>Dashboard</title>
    </Head>
  <admin>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-2">
            <div class="p-3 border bg-white rounded-xl">
                <div class="flex justify-between ">
                    <h6 class="text-md font-bold">Suppliers</h6>
                    <Link href="#" title="Portfolios" class="btn-simple btn-small">View all</Link>
                </div>
                <div class="pt-5">
                    <p class="text-md font-bold text-sumo-300">{{suppliers}} Available</p>
                </div>
            </div>
            <div class="p-3 border bg-white rounded-xl">
                <div class="flex justify-between">
                    <h6 class="text-md font-bold">Drivers</h6>
                    <Link href="" title="Properties" class="btn-simple btn-small">View all</Link>
                </div>
                <div class="flex justify-between pt-5">
                    <p class="text-md font-bold text-sumo-300">{{drivers}} Available</p>
                </div>
            </div>
            
        </div>
    <div class="grid grid-cols-3 gap-3 my-5">
            <!-- <div>
                <grains-widgets></grains-widgets>
            </div>
            <div class="col-span-2 grid">
                <bag-widget></bag-widget>
            </div>
            <div class="col-span-2 grid">
                <weight-widget></weight-widget>
            </div> -->
        </div>
  </admin>

</template>

<style scoped>

</style>
