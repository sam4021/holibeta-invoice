<template>
    <div class="overflow-y-auto custom-scrolling">
        <form id="step-three-form" @submit.prevent="submit">
            <div class="my-5">
                <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-3">
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
                                <label for="village" class="text-sm font-medium text-gray-700">Village</label>
                                <input v-model="stepThree.village" class="sumo-input my-2" id="village" type="text">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.village }}</span>
                                </div>
                            </div>
                            <div>
                                <label for="no_of_bags" class="text-sm font-medium text-gray-700">No of Bags</label>
                                <input v-model="stepThree.no_of_bags" class="sumo-input my-2" id="no_of_bags" type="text">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.no_of_bags }}</span>
                                </div>
                            </div>
                        </div>
            </div>
        </form>
    </div>

    <div class="my-3 flex justify-end gap-3">
        <button type="button" @click="stepBack" class="self-center font-medium flex">
            <span class="mr-3">
                <svg class="fill-gray-800 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"/>
                </svg>
            </span>
            Previous
        </button>
        <button form="step-three-form"  type="submit" class="btn-primary flex">
            Submit 
            <span class="ml-5">
                <svg class="fill-white h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/>
                </svg>
            </span>
        </button>
    </div>
</template>

<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";
import {ref, onMounted} from "vue";
import {useStorage} from "@vueuse/core";
import CountySelect from "@/views/components/general-components/county-select.vue";
import SubcountySelect from "@/views/components/general-components/subcounty-select.vue";
import {useLocationStore} from "@/scripts/store/locationStore";

const locationStore=useLocationStore()
const search=ref('')
locationStore.getCounties(search.value)
locationStore.getDefaultCounty()

const step=useStorage('step',1)
const stepThree=useStorage('stepThree',{
    county:'', 
    subcounty:'',
    village:'',
    no_of_bags:'',
})
const stepOne=useStorage('stepOne',{})
const stepTwo=useStorage('stepTwo',{})

let form=useForm({
    county:'', 
    subcounty:'',
    village:'',
    no_of_bags:'',
    stepOne:stepOne.value,
    stepTwo:stepTwo.value,
})
const submit=()=>{
    form.no_of_bags= stepThree.value.no_of_bags;
    form.village= stepThree.value.village;
    form.subcounty=locationStore.subcounty.id;
    form.county=locationStore.default_county.id;

    form.post(route('delivery.store'),{
        onSuccess:()=>{
            localStorage.removeItem('stepOne')
            localStorage.removeItem('stepTwo')
            localStorage.removeItem('stepThree')
            localStorage.removeItem('step')
            router.visit(route('delivery.index'))
        }
    })
}

const stepBack=()=>{
    step.value=2
}
onMounted(()=>{
    if (locationStore.default_county){
        locationStore.getSubcounties(locationStore.default_county.id)
    }
})
</script>

<style scoped>

</style>
