<template>

    <div v-on-click-outside="closeDropdown" class="relative">
        <div @click="show=!show" class="flex justify-end">
            <slot name="trigger">
            </slot>

        </div>
        <div  v-show="show"  class="z-10 bg-white mt-2 border rounded-lg shadow w-44 absolute right-0 overflow-hidden">
            <slot></slot>
        </div>
    </div>
</template>

<script setup lang="ts">
import {ref} from "vue";
import { vOnClickOutside } from '@vueuse/components'
const show=ref(false)

const closeDropdown=()=>{
    show.value=false
}
</script>

<style scoped>

</style>
