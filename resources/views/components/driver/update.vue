<template>
    <div @click="show=true">
        <slot name="trigger"></slot>
    </div>
    <teleport to="body">
        <Transition
            enter-from-class="opacity-0 scale-125"
            enter-to-class="opacity-100 scale-100"
            enter-active-class="transition duration-300"
            leave-active-class="transition duration-200"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-125"
        >
            <div @click.self="show=false" v-if="show" class="inset-0 fixed bg-black bg-opacity-40 z-[100000] grid place-items-center p-5">
                <div class="bg-white lg:w-1/2 w-full rounded-xl">
                    <header class="p-3">
                        <div class="flex justify-between">
                            <slot name="header">
                                <div class="font-bold text-sumo-300 text-lg">
                                    <h6>Update Driver</h6>
                                </div>
                            </slot>
                            <div>
                                <div class="text-end">
                                    <button type="button" @click="show=false" class="rounded-full bg-sky-700 h-7 w-7 flex place-content-center">
                                        <svg class="h-5 fill-white self-center" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </header>
                    <hr>
                    <div class="p-3.5">

                        <form @submit.prevent="submit" id="saveFacilities">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label for="firstname" class="text-sm font-medium text-gray-700">First name</label>
                                    <input v-model="form.firstname" type="text" id="firstname" class="sumo-input my-2">
                                    <div class="sumo-error" v-if="form.errors.firstname">
                                        {{ form.errors.firstname }}
                                    </div>
                                </div>
                                <div>
                                    <label for="middlename" class="text-sm font-medium text-gray-700">Middle name</label>
                                    <input v-model="form.middlename" type="text" id="middlename" class="sumo-input my-2">
                                    <div class="sumo-error" v-if="form.errors.middlename">
                                        {{ form.errors.middlename }}
                                    </div>
                                </div>
                                <div>
                                    <label for="lastname" class="text-sm font-medium text-gray-700">Last name</label>
                                    <input v-model="form.lastname" type="text" id="lastname" class="sumo-input my-2">
                                    <div class="sumo-error" v-if="form.errors.lastname">
                                        {{ form.errors.lastname }}
                                    </div>
                                </div>
                                <div>
                                    <label for="id_no" class="text-sm font-medium text-gray-700">ID Number</label>
                                    <input v-model="form.id_no" type="text" id="id_no" class="sumo-input my-2">
                                    <div class="sumo-error" v-if="form.errors.id_no">
                                        {{ form.errors.id_no }}
                                    </div>
                                </div>
                                <div>
                                    <label for="email" class="text-sm font-medium text-gray-700">ID Image</label>
                                    <input @input="form.new_id_no=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="id_image" type="file">
                                    <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                        <span class="text-xs">{{form.errors.new_id_no }}</span>
                                    </div>
                                    <img :src="'/images/driver/'+form.id_image">
                                </div>
                                <div>
                                    <label for="email" class="text-sm font-medium text-gray-700">Driver Image</label>
                                    <input @input="form.new_driver_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="id_image" type="file">
                                    <div v-if="form.errors" class="mt-3 text-red-800 text-sm">
                                        <span class="text-xs">{{form.errors.new_driver_image }}</span>
                                    </div>
                                    <img :src="'/images/driver/'+form.driver_image">
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <footer class="p-3.5">
                        <div class="flex justify-end">
                            <button form="saveFacilities" type="submit" class="btn-primary btn-medium">Update Driver</button>
                        </div>
                    </footer>
                </div>
            </div>
        </Transition>
    </teleport>
</template>

<script setup lang="ts">
import {watch, ref} from "vue";
import {useForm} from "@inertiajs/vue3";

let props=defineProps({
    driver:Object,
})

const show=ref(false)

watch(show,(val)=>{
    if(val){
        document.body.style.overflow='hidden'
    }else{
        document.body.style.overflow='auto'
    }
})



let form=useForm({
    firstname:props.driver?.firstname,
    middlename:props.driver?.middlename,
    lastname:props.driver?.lastname,
    id_no:props.driver?.id_no,
    id_image:props.driver?.id_image,
    new_id_image:'',
    driver_image:props.driver?.driver_image,
    new_driver_image:'',
    _method:'PATCH'

})

const submit = () => {
    form.post(route('drivers.update',props.driver?.id),{
        preserveScroll:true,
        onSuccess:()=>{
            show.value=false
            form.reset()

        }
    })
}
</script>

<style scoped>

</style>
