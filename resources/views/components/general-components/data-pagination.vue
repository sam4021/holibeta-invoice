<template>
    <div>
        <div class="flex justify-between bg-sky-50 py-3 px-2 ">
            <div class="self-center">
                <h6 class="font-semibold text-sm">Page {{ current_page }} of {{ last_page }}</h6>
            </div>
            <div class="flex gap-1">
                <Link v-if="prev_page" :href="prev_page" class="btn-secondary-outline btn-medium flex">
                    <span class="mr-2">
                        <svg class="h-4" xmlns="http://www.w3.org/2000/svg" height="16" width="10" viewBox="0 0 320 512">
                            <path d="M18.3 250.3c-3.1 3.1-3.1 8.2 0 11.3l216 216c3.1 3.1 8.2 3.1 11.3 0s3.1-8.2 0-11.3L35.3 256 245.7 45.7c3.1-3.1 3.1-8.2 0-11.3s-8.2-3.1-11.3 0l-216 216z"/>
                        </svg>
                    </span>Prev</Link>
                <Link v-if="next_page" :href="next_page" class="btn-secondary-outline btn-medium flex">Next<span class="ml-2">
                    <svg class="h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path d="M66.07 477.3c-1.376-1.531-2.048-3.438-2.048-5.344c0-2.188 .891-4.375 2.642-5.938L300.2 256L66.66 45.93c-3.283-2.906-3.58-8-.594-11.28c2.97-3.281 8.019-3.563 11.32-.5938l240.1 216c3.345 3 3.345 8.875 0 11.88L77.38 477.9C74.08 480.9 69.04 480.6 66.07 477.3z"/>
                    </svg>
                </span></Link>

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
let next_page = props.data?.links.next?props.data.links.next:props.data?.next_page_url
let prev_page = props.data?.links.prev?props.data.links.prev:props.data?.prev_page_url
</script>

<style scoped>

</style>
