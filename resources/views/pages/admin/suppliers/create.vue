<script setup lang="ts">
import Admin from "@/views/layouts/admin.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { computed,ref, onMounted } from "vue";
import CountySelect from "@/views/components/general-components/county-select.vue";
import SubcountySelect from "@/views/components/general-components/subcounty-select.vue";
import BankSelect from "@/views/components/general-components/banks-select.vue";
import {useLocationStore} from "@/scripts/store/locationStore";
import { useBankStore } from "@/scripts/store/bankStore";

defineProps({
    vehicles: Object,
});
const bankStore=useBankStore()
const locationStore=useLocationStore()
const search=ref('')
locationStore.getCounties(search.value)
locationStore.getDefaultCounty()
const user = computed(() => usePage().props.auth.id);
let form = useForm({
    firstname:'',
    middlename:'',
    lastname:'', 
    phone:'', 
    email:'', 
    id_no:'', 
    county:'', 
    subcounty:'', 
    ward:'',
    bank_name:'',
    bank_account_name:'',
    bank_account_number:''
});

onMounted(()=>{
    if (locationStore.default_county){
        locationStore.getSubcounties(locationStore.default_county.id)
    }
})

const submit=()=>{
    form.bank_name=bankStore.bank
    form.subcounty=locationStore.subcounty.id
    form.county=locationStore.default_county.id

    form.post(route('suppliers.store'),{
     onSuccess:()=>{
         form.reset()
     }
 })
}
</script>

<template>
    <Head title="Add Supplier" />
    <admin>
        <div class="my-3">
            <div>
                <h1 class="text-2xl font-bold">Add a Supplier</h1>
            </div>
            <div class="my-5">
                <form @submit.prevent="submit">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <div>
                            <label class="sumo-label" for="firstname">First name:</label>
                            <input
                                v-model="form.firstname"
                                placeholder="Enter First name"
                                type="text"
                                id="firstname"
                                class="sumo-input my-2"
                            />
                            <div class="sumo-error" v-if="form.errors.firstname">
                                {{ form.errors.firstname }}
                            </div>
                        </div>
                        <div>
                            <label class="sumo-label" for="middlename">Middle name:</label>
                            <input
                                v-model="form.middlename"
                                placeholder="Enter Middle name"
                                type="text"
                                id="middlename"
                                class="sumo-input my-2"
                            />
                            <div class="sumo-error" v-if="form.errors.middlename">
                                {{ form.errors.middlename }}
                            </div>
                        </div>
                        <div>
                            <label class="sumo-label" for="lastname">Last name:</label>
                            <input
                                v-model="form.lastname"
                                placeholder="Enter Last name"
                                type="text"
                                id="lastname"
                                class="sumo-input my-2"
                            />
                            <div class="sumo-error" v-if="form.errors.lastname">
                                {{ form.errors.lastname }}
                            </div>
                        </div>
                        <div>
                            <label for="phone" class="text-sm font-medium text-gray-700">Phone</label>
                            <input
                                v-model="form.phone"
                                placeholder="0712*****"
                                type="text"
                                id="phone"
                                class="sumo-input my-2"
                            />
                            <div class="sumo-error" v-if="form.errors.phone">
                                {{ form.errors.phone }}
                            </div>
                        </div>
                        <div>
                            <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                            <input v-model="form.email"
                                placeholder="johndoe@email.com"
                                type="email"
                                id="email"
                                class="sumo-input my-2"/>
                            <div class="sumo-error" v-if="form.errors.email">
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
                                type="number"
                                id="id_no"
                                class="sumo-input my-2"
                                minlength="5"
                                maxlength="10"
                            />
                            <div
                                class="sumo-error"
                                v-if="form.errors.id_no"
                            >
                                {{ form.errors.id_no }}
                            </div>
                        </div>
                        <div>
                            <label for="county" class="text-sm font-medium text-gray-700">County</label>
                            <county-select
                                           placeholder="Select County"
                                           :searchable="true" class="my-2"></county-select>
                            <div class="sumo-error" v-if="form.errors.county"> {{ form.errors.county }} </div>
                        </div>
                        <div>
                            <label class="sumo-label flex items-center gap-2">
                                <span>Subcounty</span>
                                <svg v-if="locationStore.loading && !locationStore.subcounties" class="w-5 fill-sumo-300 animate-pulse" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400 256c0 26.5 21.5 48 48 48s48-21.5 48-48S474.5 208 448 208S400 229.5 400 256zM112 256c0-26.5-21.5-48-48-48S16 229.5 16 256S37.5 304 64 304S112 282.5 112 256zM304 256c0-26.5-21.5-48-48-48S208 229.5 208 256S229.5 304 256 304S304 282.5 304 256z"/></svg>
                            </label>
                            <label for="subcounty" class="text-sm font-medium text-gray-700"></label>
                            <subcounty-select
                                           placeholder="Select Subcounty"
                                        :searchable="true"
                                        :disabled="!locationStore.default_county"
                                        class="my-2"></subcounty-select>
                            <div class="sumo-error" v-if="form.errors.subcounty"> {{ form.errors.subcounty }} </div>
                        </div>
                        <div>
                            <label for="ward" class="text-sm font-medium text-gray-700">Ward</label>
                            <input v-model="form.ward" placeholder="Enter Ward" type="text" id="ward" class="sumo-input my-2"/>
                            <div class="sumo-error" v-if="form.errors.ward"> {{ form.errors.ward }} </div>
                        </div>
                        
                        <div>
                            <label for="bank_name" class="text-sm font-medium text-gray-700">Bank Name</label>
                            <bank-select
                                    placeholder="Select Bank"
                                :searchable="true"
                                v-model:selected="form.bank_name"
                                class="my-2"></bank-select>
                            
                            <div class="sumo-error" v-if="form.errors.bank_name"> {{ form.errors.bank_name }} </div>
                        </div>
                        <div>
                            <label for="bank_account_name" class="text-sm font-medium text-gray-700">Bank Account Name</label>
                            <input v-model="form.bank_account_name" placeholder="John Doe" type="text" id="bank_account_name" class="sumo-input my-2"/>
                            <div class="sumo-error" v-if="form.errors.bank_account_name"> {{ form.errors.bank_account_name }} </div>
                        </div>
                        <div>
                            <label for="bank_account_number" class="text-sm font-medium text-gray-700">Bank Account Number</label>
                            <input v-model="form.bank_account_number" placeholder="12345678" type="text" id="bank_account_number" class="sumo-input my-2"/>
                            <div class="sumo-error" v-if="form.errors.bank_account_number"> {{ form.errors.bank_account_number }} </div>
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

<style scoped></style>
