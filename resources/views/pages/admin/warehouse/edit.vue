<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, useForm} from "@inertiajs/vue3";


let props=defineProps({
    warehouse:Object
})
console.log('====================================');
console.log(props);
console.log('====================================');
let form=useForm({
    firstname:props.supplier?.firstname,
    middlename:props.supplier?.middlename,
    lastname:props.supplier?.lastname,
    phone: props.supplier?.phone,
    email: props.supplier?.email,
    id_no: props.supplier?.id_no,
    age_limits: props.supplier?.age_limits,
})
</script>

<template>
    <Head title="Edit Supplier" />
    <admin>
        <div class="my-3">
            <div>
                <h1 class="text-2xl font-bold">Edit Supplier</h1>
            </div>
            <div class="my-5">
                <form @submit.prevent="form.patch(route('suppliers.update',supplier.id))">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <div>
                            <label class="sumo-label" for="firstname"
                                >First name:</label
                            >
                            <input
                                v-model="form.firstname"
                                placeholder="Enter First Name"
                                type="text"
                                id="firstname"
                                class="sumo-input my-2"
                            />
                            <div class="sumo-error" v-if="form.errors.firstname">
                                {{ form.errors.firstname }}
                            </div>
                        </div>
                        <div>
                            <label class="sumo-label" for="middlename"
                                >Middle name:</label
                            >
                            <input
                                v-model="form.middlename"
                                placeholder="Enter Middle Name"
                                type="text"
                                id="middlename"
                                class="sumo-input my-2"
                            />
                            <div class="sumo-error" v-if="form.errors.middlename">
                                {{ form.errors.middlename }}
                            </div>
                        </div>
                        <div>
                            <label class="sumo-label" for="lastname"
                                >Last name:</label
                            >
                            <input
                                v-model="form.lastname"
                                placeholder="Enter Last Name"
                                type="text"
                                id="lastname"
                                class="sumo-input my-2"
                            />
                            <div class="sumo-error" v-if="form.errors.lastname">
                                {{ form.errors.lastname }}
                            </div>
                        </div>
                        <div>
                            <label
                                for="phone"
                                class="text-sm font-medium text-gray-700"
                                >Phone</label
                            >
                            <input
                                v-model="form.phone"
                                placeholder="Enter Phone Number"
                                type="text"
                                id="phone"
                                class="sumo-input my-2"
                            />
                            <div
                                class="sumo-error"
                                v-if="form.errors.phone"
                            >
                                {{ form.errors.phone }}
                            </div>
                        </div>
                        <div>
                            <label
                                for="email"
                                class="text-sm font-medium text-gray-700"
                                >Email</label
                            >
                            <input
                                v-model="form.email"
                                placeholder="Enter Email"
                                type="email"
                                id="email"
                                class="sumo-input my-2"
                            />
                            <div
                                class="sumo-error"
                                v-if="form.errors.email"
                            >
                                {{ form.errors.email }}
                            </div>
                        </div>
                        <div>
                            <label
                                for="id_no"
                                class="text-sm font-medium text-gray-700"
                                >ID Number</label
                            >
                            <input
                                v-model="form.id_no"
                                placeholder="Enter ID Number"
                                type="text"
                                id="id_no"
                                class="sumo-input my-2"
                            />
                            <div
                                class="sumo-error"
                                v-if="form.errors.id_no"
                            >
                                {{ form.errors.id_no }}
                            </div>
                        </div>
                        <div>
                            <label
                                for="age_limits"
                                class="text-sm font-medium text-gray-700"
                                >Age Limits</label
                            >
                            <input
                                v-model="form.age_limits"
                                placeholder="Enter Age Limits"
                                type="text"
                                id="age_limits"
                                class="sumo-input my-2"
                            />
                            <div
                                class="sumo-error"
                                v-if="form.errors.age_limits"
                            >
                                {{ form.errors.age_limits }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="my-5 flex justify-end">
                        <button
                            :disabled="form.processing"
                            type="submit"
                            class="btn-primary flex gap-2 items-center"
                        >
                            <span>Save Supplier</span>
                            <svg
                                v-if="form.processing"
                                class="fill-white w-5 animate-ping"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"
                            >
                                <path
                                    d="M400 256c0 26.5 21.5 48 48 48s48-21.5 48-48S474.5 208 448 208S400 229.5 400 256zM112 256c0-26.5-21.5-48-48-48S16 229.5 16 256S37.5 304 64 304S112 282.5 112 256zM304 256c0-26.5-21.5-48-48-48S208 229.5 208 256S229.5 304 256 304S304 282.5 304 256z"
                                />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </admin>
</template>

<style scoped>

</style>
