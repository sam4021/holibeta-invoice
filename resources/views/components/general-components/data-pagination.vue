<template>
    <div>
        <div class="flex justify-between bg-sky-50 py-3 px-2 ">
            <div class="self-center">
                <h6 class="font-semibold text-sm">Page {{ current_page }} of {{ last_page }}</h6>
            </div>
            <div class="flex gap-1">
                <Link v-if="data.links.prev" :href="data.links.prev" class="btn-secondary-outline btn-medium"><span class="mr-2"><i class="fa-regular fa-angle-left"></i></span>Prev</Link>
                <Link v-if="data.links.next" :href="data.links.next" class="btn-secondary-outline btn-medium">Next<span class="ml-2"><i class="fa-regular fa-angle-right"></i></span></Link>

            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
let props = defineProps({
    data:Object
})
let current_page = props.data?.current_page?props.data.current_page:props.data?.meta.current_page
let last_page = props.data?.last_page?props.data.last_page:props.data?.meta.last_page
</script>

<style scoped>

</style>
