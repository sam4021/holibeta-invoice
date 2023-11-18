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
                                    <h6>Create Weighbridge</h6>
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
                            <div class="mx-6 grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                            <label class="sumo-label" for="supplier"
                                >Supplier:</label
                            >
                            <vue-select
                                    :searchable="true"
                                    v-model:selected="form.supplier"
                                    :options="suppliers.data"
                                    placeholder="Select Supplier"
                                    class=""
                                ></vue-select>
                            
                            <div class="sumo-error" v-if="form.errors.supplier">
                                {{ form.errors.supplier }}
                            </div>
                        </div>
                                <div>
                                    <label for="weight" class="text-sm font-medium text-gray-700">Weight</label>
                                    <input v-model="form.weight" type="text" id="name" name="weight" class="sumo-input my-2">
                                    <div class="sumo-error" v-if="form.errors.weight">
                                        {{ form.errors.weight }}
                                    </div>
                                </div>
                                <div>
                                    <label for="moisture_content" class="text-sm font-medium text-gray-700">Moisture Content (%)</label>
                                    <input v-model="form.moisture_content" type="text" id="name" name="moisture_content" class="sumo-input my-2">
                                    <div class="sumo-error" v-if="form.errors.moisture_content">
                                        {{ form.errors.moisture_content }}
                                    </div>
                                </div>
                                <div>
                                    <label for="visual_inspection" class="text-sm font-medium text-gray-700">Visual Inspection</label>
                                    <select v-model="form.visual_inspection" class="sumo-input my-2">
                                    <option :value="null">Choose Inspection Status</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Reject">Reject</option>
                                    </select>
                                    <div class="sumo-error" v-if="form.errors.visual_inspection">
                                        {{ form.errors.visual_inspection }}
                                    </div>
                                </div>
                                <div>
                                    <label for="visual_inspection_image" class="text-sm font-medium text-gray-700">Visual Inspection Image</label>
                                    <input @input="form.visual_inspection_image=$event.target.files[0]" class="block w-full text-sm  border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="visual_inspection_image" type="file">
                                    <div v-if="form.errors.visual_inspection_image" class="mt-3 text-red-800 text-sm">
                                        <span class="text-xs">{{form.errors.visual_inspection_image }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label for="visual_inspection_comment" class="text-sm font-medium text-gray-700">Visual Inspection Comment</label>
                                    <textarea v-model="form.visual_inspection_comment" type="text" id="visual_inspection_comment" class="sumo-input my-2"></textarea>
                                    <div class="sumo-error" v-if="form.errors.visual_inspection_comment">
                                        {{ form.errors.visual_inspection_comment }}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <footer class="p-3.5">
                        <div class="flex justify-end">
                            <button form="saveFacilities" type="submit" class="btn-primary btn-medium">Save Weighbridge</button>
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
import VueSelect from "@/views/components/general-components/vue-select.vue";

let props=defineProps({
   suppliers: Object
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
    supplier:null, 
    weight:"", 
    moisture_content:"",
    visual_inspection:null,
    visual_inspection_comment:"",
    visual_inspection_image:""
})

const submit = () => {
    form.post(route('weighbridge.store'),{
        preserveScroll:true,
        onSuccess:()=>{
            show.value=false
            form.reset()

        }
    })
}
</script>