<script setup lang="ts">

</script>

<template>
<div class="border bg-white overflow-hidden rounded-lg relative table w-full">
    <header class="border-b p-2 h-11">
     <slot name="header"></slot>
    </header>
    <main class="p-2">
        <slot></slot>
    </main>
    <footer  class="border-t table-row w-full h-10 py-auto">
        <slot name="footer"></slot>
    </footer>
</div>
</template>

<style scoped>

</style>
