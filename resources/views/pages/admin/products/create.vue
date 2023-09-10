<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, useForm, usePage} from "@inertiajs/vue3";
import {computed} from "vue";

const user=computed(()=>usePage().props.auth.id)
let form=useForm({
    name:'',
    status:'',
    description:'',
    product_type:'',
    product_weight:'',
    user_id:user,
})
</script>

<template>
    <Head title="Add product" />
<admin>
    <div class="my-3">
        <div>
            <h1 class="text-2xl font-bold">Add a product</h1>
        </div>
        <div class="my-5">
            <form>
                <div class="grid md:grid-cols-2 gap-3">
                    <div>
                        <label class="sumo-label" for="product_name">Product name:</label>
                        <input v-model="form.name" type="text" id="name" name="name" class="sumo-input my-2">
                        <div class="sumo-error" v-if="form.errors.name">
                            {{ form.errors.name }}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</admin>
</template>

<style scoped>

</style>
