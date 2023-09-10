<template>
    <!--
    This is a custom prompt used to alert users of their actions
    alert consists of title:string
    type: Danger, Warn, Success and
    emit 'proceed' as an affirmative action
    -->
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
                <div class="bg-white md:w-3/5 lg:w-2/5 w-full rounded-3xl p-3">
                    <header class="p-3">
                        <div class="flex justify-center">
                            <div class="p-2">
                                <div class="flex justify-center">
                                    <div class="border-gray-600 rounded-full w-12 h-12 flex place-content-center
                                      items-center my-3  border">
                                        <svg class="h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512">
                                          <path d="M64 368c13.27 0 24-10.75 24-24v-288c0-13.25-10.73-23.99-24-23.99S40 42.75 40 56v288C40 357.3 50.73 368 64 368zM64 416c-17.67 0-32 14.33-32 32s14.33 32.01 32 32.01S96 465.7 96 448S81.67 416 64 416z"/>
                                        </svg>
                                    </div>
                                </div>
                                <h6 class="text-xl font-extrabold text-center ">{{title}}</h6>
                            </div>
                        </div>

                    </header>

                    <div class="p-3 text-center">
                        <p class=" font-medium text-[16px] text-gray-600">
                            {{description}}
                        </p>
                    </div>

                    <footer class="p-2 my-3">
                        <div class="flex justify-end gap-2">
                            <button class="btn-outline-primary btn-medium" @click="show=false">Cancel</button>
                            <button class="btn-danger btn-medium" @click="acceptAction">Okay</button>
                        </div>
                    </footer>
                </div>
            </div>
        </Transition>
    </teleport>
</template>

<script setup lang="ts">
import {ref} from "vue";
let emits=defineEmits(['proceed'])
defineProps({
    title:String,
    description:String
})
const show=ref(false)

//confirm the users action
const acceptAction=()=>{
    emits('proceed')
    show.value=false
}
</script>

<style scoped>

</style>
