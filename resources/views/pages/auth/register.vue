<script setup lang="ts">
import {useForm, Link, Head} from "@inertiajs/vue3";


let form=useForm({
    email:'',
    password:'',
    name:'',
    password_confirmation:''
})

const submit=()=>{
    form.post(route('create.user'),{
        onSuccess:()=>{
            form.reset()
        }
    })
}
</script>

<template>
    <Head>
        <title>Register</title>
    </Head>
    <section>
        <div class="h-screen flex place-content-center p-3">
            <div class="self-center border rounded-lg p-3 md:p-8 w-full md:w-3/5 lg:w-2/5 overflow-hidden bg-white">
                <h1 class="text-center font-bold text-xl text-sky-600">MACHINE READING</h1>
                <h2 class="my-5 font-medium text-center">Create account</h2>
                <div class="my-5">
                    <form autocomplete="off"  @submit.prevent="submit">
                        <div class="my-5 grid">
                            <label for="form-name" class="sumo-label">Name:</label>
                            <input type="text" class="sumo-input my-2" id="form-name" placeholder="Enter your name" required v-model="form.name"/>
                            <div v-if="form.errors.name" class="sumo-error">
                                <span>{{ form.errors.name }}</span>
                            </div>
                        </div>
                        <div class="my-5 grid">
                            <label for="form-input" class="sumo-label">Email:</label>
                            <input type="email" class="sumo-input my-2" id="form-input" placeholder="Enter your email" required v-model="form.email"/>
                            <div v-if="form.errors.email" class="sumo-error">
                                <span>{{ form.errors.email }}</span>
                            </div>
                        </div>

                        <div class="my-5 grid md:grid-cols-2 gap-2">
                           <div>
                               <label for="form-password" class="sumo-label">Password:</label>
                               <input type="password" class="sumo-input my-2" id="form-password" placeholder="Enter your password" required v-model="form.password"/>

                           </div>
                            <div>
                                <label for="form-password_confirm" class="sumo-label">Password confirm:</label>
                                <input type="password" class="sumo-input my-2" id="form-password_confirm" placeholder="Confirm your password" required v-model="form.password_confirmation"/>

                            </div>
                        </div>
                        <div v-if="form.errors.password" class="sumo-error my-2">
                            <span>{{ form.errors.password }}</span>
                        </div>

                        <div class="my-5 grid gap-3 md:flex justify-center md:justify-end items-center">
                            <div class="order-1 md:order-2">
                                <button type="submit" class="btn-primary w-44">Register</button>
                            </div>
                        </div>
                        <div class="pt-8 text-center">
                            <Link class="text-center hover:text-sky-700 underline" href="/">Login here</Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>


<style scoped>

</style>
