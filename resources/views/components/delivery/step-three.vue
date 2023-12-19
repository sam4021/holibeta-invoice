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
                                <label for="no_of_bags" class="text-sm font-medium text-gray-700">No of Bags</label>
                                <input v-model="stepThree.no_of_bags" class="sumo-input my-2" id="no_of_bags" type="text">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.no_of_bags }}</span>
                                </div>
                            </div>
                            <div></div>
                            <div>
                                <label for="vehicle_plate_front" class="text-sm font-medium text-gray-700">Vehicle Plate Front</label>
                                <input @input="stepThree.vehicle_plate_front=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="vehicle_plate_front" type="file">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.vehicle_plate_front }}</span>
                                </div>
                            </div>
                            <div>
                                <label for="vehicle_plate_back" class="text-sm font-medium text-gray-700">Vehicle Plate Back</label>
                                <input @input="stepThree.vehicle_plate_back=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="vehicle_plate_back" type="file">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.vehicle_plate_back }}</span>
                                </div>
                            </div>
                            <div>
                                <label for="email" class="text-sm font-medium text-gray-700">Front Image</label>
                                <input @input="stepThree.front_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.front_image }}</span>
                                </div>
                            </div>
                            <div>
                                <label for="email" class="text-sm font-medium text-gray-700">Back Image</label>
                                <input @input="stepThree.back_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.back_image }}</span>
                                </div>
                            </div>
                            <div>
                                <label for="email" class="text-sm font-medium text-gray-700">Top Image</label>
                                <input @input="stepThree.top_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.top_image }}</span>
                                </div>
                            </div>
                            <div>
                                <label for="email" class="text-sm font-medium text-gray-700">Side Image</label>
                                <input @input="stepThree.side_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                                <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                    <span class="text-xs">{{form.errors.side_image }}</span>
                                </div>
                            </div>
                    
                            
                        </div>
               
            </div>
        </form>
    </div>

    <div class="my-3 flex justify-end gap-3">
        <button type="button" @click="stepBack" class="self-center font-medium"><span class="mr-3"><i class="fa-light fa-arrow-left-long"></i></span>Previous</button>
        <button form="step-three-form"  type="submit" class="btn-primary">Next <span class="ml-5"><i class="fa-light fa-arrow-right-long"></i></span></button>
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
    front_image: "",
    back_image: "",
    side_image: "",
    top_image:"",
    county:'', 
    subcounty:'',
    no_of_bags:'',
    vehicle_plate_front: "",
    vehicle_plate_back: ""
})
const stepOne=useStorage('stepOne',{})
const stepTwo=useStorage('stepTwo',{})

let form=useForm({
    front_image: "",
    back_image: "",
    side_image: "",
    top_image:"",
    county:'', 
    subcounty:'',
    no_of_bags:'',
    vehicle_plate_front: "",
    vehicle_plate_back: "",
    stepOne:stepOne.value,
    stepTwo:stepTwo.value,
})
const submit=()=>{
    form.front_image= stepThree.value.front_image;
    form.back_image= stepThree.value.back_image;
    form.side_image= stepThree.value.side_image;
    form.top_image= stepThree.value.top_image;
    form.no_of_bags= stepThree.value.no_of_bags;
    form.subcounty=locationStore.subcounty.id;
    form.county=locationStore.default_county.id;
    form.vehicle_plate_front= stepThree.value.vehicle_plate_front;
    form.vehicle_plate_back= stepThree.value.vehicle_plate_back;

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
