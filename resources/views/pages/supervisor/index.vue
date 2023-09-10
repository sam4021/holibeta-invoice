<script setup lang="ts">
import {onMounted} from "vue";
import { initFlowbite } from 'flowbite'
import {Head} from "@inertiajs/vue3";
import Supervisor from "@/views/layouts/supervisor.vue";

onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <Head>
        <title>Dashboard</title>
    </Head>
  <supervisor>

  </supervisor>

</template>

<style scoped>

</style>
