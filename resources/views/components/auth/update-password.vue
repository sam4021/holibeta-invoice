<template>
    <div @click="launchForm">
        <slot name="trigger">
        </slot>
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
                <div class="bg-white lg:w-3/5 w-full rounded-xl overflow-hidden">
                    <header class="p-3 bg-gray-100">
                        <div class="flex justify-between">
                            <div class="font-medium text-sumo-300 text-lg">
                               Edit Password
                            </div>
                            <div>
                                <div class="text-end">
                                    <button type="button" @click="show=false" class="rounded-full bg-sumo-300 h-8 w-8">
                                    <span class="text-white text-lg">
                                        <i class="fal fa-times"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="px-10 py-8 custom-scrolling overflow-y-auto max-h-[400px] m-2">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 gap-1 my-5">
                                <div>
                                    <label class="sumo-label" for="old_password">Old Password:</label>
                                    <input type="password" class="sumo-input my-3" id="old_password" v-model="form.old_password">
                                    <div v-if="form.errors.old_password" class="mt-3 text-red-800 text-sm">
                                        <span class="text-xs">{{form.errors.old_password }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-1 my-5">
                                <div>
                                    <label class="sumo-label" for="new_password">New Password:</label>
                                    <input type="password" class="sumo-input my-3" id="new_password" v-model="form.new_password">
                                    <div v-if="form.errors.new_password" class="mt-3 text-red-800 text-sm">
                                        <span class="text-xs">{{form.errors.new_password }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="sumo-label" for="password_confirmation">Password Confirmation:</label>
                                    <input type="password" class="sumo-input my-3" id="password_confirmation" v-model="form.password_confirmation">
                                    <div v-if="form.errors.password_confirmation" class="mt-3 text-red-800 text-sm">
                                        <span class="text-xs">{{form.errors.password_confirmation }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="my-3 flex justify-end">
                                <button type="submit" class="btn-primary">Update Password <span v-show="form.processing" class="ml-2 animate-ping"><i class="fa-solid fa-ellipsis"></i></span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </Transition>
    </teleport>
</template>

<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";

let props=defineProps({
    user:Object,
    roles:Object
})

let show=ref(false)

let form=useForm({
    old_password: '',
    new_password: '',
    password_confirmation:''
})
const launchForm=()=>{
    show.value=true
}
const submit=()=>{
    form.post(route('auth.updatePassword'),{
        onSuccess:()=>{
            show.value = false
            form.reset()
        }
    })
}
</script>

<style scoped>

</style>
