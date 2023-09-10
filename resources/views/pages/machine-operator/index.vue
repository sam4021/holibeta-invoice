<script setup lang="ts">
import {onMounted} from "vue";
import { initFlowbite } from 'flowbite'
import {Head} from "@inertiajs/vue3";
import MachineOperator from "@/views/layouts/machine-operator.vue";

onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <Head>
        <title>Dashboard</title>
    </Head>
  <machine-operator>

  </machine-operator>

</template>

<style scoped>

</style>
