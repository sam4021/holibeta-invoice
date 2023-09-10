<template>
    <Head>
        <title>Update you password</title>
    </Head>
    <div class="flex h-screen  place-content-center">

        <div class="bg-white shadow rounded-3xl w-2/5 self-center">
            <div class="self-center  p-5">
                <div class="px-10">
                    <h6 class="text-center mb-8 text-lg text-sumo-300">Create new Password</h6>
                    <form @submit.prevent="form.post(route('new.password'))">

                        <div class="mt-7">
                            <input type="password" class="sumo-input" id="password" placeholder="Enter your password" required v-model="form.password" autocomplete="new-password"/>
                            <div v-if="form.errors.password" class="mt-3 text-red-800 text-sm">
                                <span>{{ form.errors.password}}</span>
                            </div>
                        </div>
                        <div class="mt-7">

                            <input type="password" class="sumo-input" id="password_confirmation" placeholder="Confirm your password" required v-model="form.password_confirmation"/>

                        </div>
                        <div class="flex mt-4 place-content-end">

                            <button type="submit" class="btn-primary  m-1">Update</button>
                        </div>

                    </form>
                </div>
            </div>


        </div>
    </div>
</template>

<script setup lang="ts">
import {Head, useForm} from "@inertiajs/vue3";

const props=defineProps({
    email:String,
    code: String ,
})

let form=useForm({

    password: '',
    password_confirmation: '',

})

</script>


