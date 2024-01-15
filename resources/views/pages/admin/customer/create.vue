<script setup lang="ts">
import Admin from "@/views/layouts/admin.vue";
import { Head, useForm, usePage, router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import CountySelect from "@/views/components/general-components/county-select.vue";
import SubcountySelect from "@/views/components/general-components/subcounty-select.vue";
import { useLocationStore } from "@/scripts/store/locationStore";
import CreateDriver from "@/views/components/driver/create.vue";
import VueSelect from "@/views/components/general-components/vue-select.vue";

const locationStore = useLocationStore();
const search = ref("");

let props = defineProps({});
console.log(props);

let form = useForm({
    name: "",
    email: "",
    phone: "",
    billing_name: "",
    billing_address_street_1: "",
});

const submit = () => {
    form.post(route("customer.store"), {
        onSuccess: () => {},
    });
};

onMounted(() => {});
</script>

<template>
    <Head title="Add Customer" />
    <admin>
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold capitalize">Add Customer</h1>
            </div>
            <div class="flex gap-2">
                <div></div>
                <div></div>
            </div>
        </div>

        <div class="my-5">
            <form @submit.prevent="submit">
                <div class="mx-6 grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label
                            for="name"
                            class="text-sm font-medium text-gray-700"
                            >Name</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            id="name"
                            name="name"
                            class="sumo-input my-2"
                            placeholder="John Doe"
                        />
                        <div class="sumo-error" v-if="form.errors.name">
                            {{ form.errors.name }}
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
                            type="email"
                            id="email"
                            name="email"
                            class="sumo-input my-2"
                            placeholder="johndoe@email.com"
                        />
                        <div class="sumo-error" v-if="form.errors.email">
                            {{ form.errors.email }}
                        </div>
                    </div>
                    <div>
                        <label
                            for="phone"
                            class="text-sm font-medium text-gray-700"
                            >phone</label
                        >
                        <input
                            v-model="form.phone"
                            type="text"
                            id="phone"
                            name="phone"
                            class="sumo-input my-2"
                            placeholder="07xxxxxxx"
                        />
                        <div class="sumo-error" v-if="form.errors.phone">
                            {{ form.errors.phone }}
                        </div>
                    </div>
                </div>
                <div class="py-4">
                    <hr />
                </div>
                <div>
                    <h3 class="text-xl font-bold capitalize mb-4 mx-6">
                        Billing Address
                    </h3>
                </div>
                <div class="mx-6 grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label
                            for="billing_name"
                            class="text-sm font-medium text-gray-700"
                            >Name</label
                        >
                        <input
                            v-model="form.billing_name"
                            type="text"
                            id="billing_name"
                            name="name"
                            class="sumo-input my-2"
                            placeholder="John Doe"
                        />
                        <div class="sumo-error" v-if="form.errors.billing_name">
                            {{ form.errors.billing_name }}
                        </div>
                    </div>
                    <div>
                        <label
                            for="address_street_1"
                            class="text-sm font-medium text-gray-700"
                            >address_street_1</label
                        >
                        <input
                            v-model="form.billing_address_street_1"
                            type="address_street_1"
                            id="address_street_1"
                            name="text"
                            class="sumo-input my-2"
                            placeholder="johndoe@email.com"
                        />
                        <div
                            class="sumo-error"
                            v-if="form.errors.billing_address_street_1"
                        >
                            {{ form.errors.bolling_address_street_1 }}
                        </div>
                    </div>
                    <div>
                        <label
                            for="address_street_2"
                            class="text-sm font-medium text-gray-700"
                            >address_street_2</label
                        >
                        <input
                            v-model="form.billing_address_street_2"
                            type="text"
                            id="address_street_2"
                            name="address_street_2"
                            class="sumo-input my-2"
                            placeholder="07xxxxxxx"
                        />
                        <div
                            class="sumo-error"
                            v-if="form.errors.billing_address_street_2"
                        >
                            {{ form.errors.billing_address_street_2 }}
                        </div>
                    </div>
                </div>
                <div class="my-5 flex justify-end">
                    <button
                        :disabled="form.processing"
                        type="submit"
                        class="btn-primary flex gap-2 items-center"
                    >
                        <span>Save Customer</span>
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
    </admin>
</template>

<style scoped></style>
