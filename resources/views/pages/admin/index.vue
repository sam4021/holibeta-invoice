<script setup lang="ts">
import {onMounted} from "vue";
import { initFlowbite } from 'flowbite'
import {Head} from "@inertiajs/vue3";
import Admin from "@/views/layouts/admin.vue";

onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <Head>
        <title>Dashboard</title>
    </Head>
  <admin>

  </admin>

</template>

<style scoped>

</style>
