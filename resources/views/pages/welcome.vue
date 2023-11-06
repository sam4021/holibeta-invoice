<script setup lang="ts">
import {useForm, Link, Head} from "@inertiajs/vue3";


let form=useForm({
    email:'',
    password:''
})
</script>

<template>
    <Head>
        <title>Welcome</title>
    </Head>
<section>
    <div class="flex min-h-full flex-1">
    <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
      <div class="mx-auto w-full max-w-sm lg:w-96">
        <div>
          <img class="h-10 w-auto" src="/images/logo.png" alt="emsea farm" />
          <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
          <p class="mt-2 text-sm leading-6 text-gray-500">
            Not a member?
            {{ ' ' }}
            <a  :href="route('register')" class="font-semibold text-indigo-600 hover:text-indigo-500">Sign Up</a>
          </p>
        </div>

        <div class="mt-10">
          <div>
            <form @submit.prevent="form.post(route('authenticate'))" autocomplete="off" class="space-y-6">
              <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                <div class="mt-2">
                  <input id="email" type="email" autocomplete="email" required v-model="form.email" class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                  <div v-if="form.errors.email" class="sumo-error">
                        <span>{{ form.errors.email }}</span>
                    </div>
                </div>
              </div>

              <div>
                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                <div class="mt-2">
                  <input id="password" type="password" autocomplete="current-password" required v-model="form.password" class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                  <div v-if="form.errors.password" class="sumo-error">
                            <span>{{ form.errors.password }}</span>
                        </div>
                </div>
              </div>

              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                  <label for="remember-me" class="ml-3 block text-sm leading-6 text-gray-700">Remember me</label>
                </div>

                <div class="text-sm leading-6">
                    <Link :href="route('password-reset')" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</Link>
                  
                </div>
              </div>

              <div>
                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <span>Sign in</span>
                    <svg v-if="form.processing" class="fill-white w-5 animate-pulse" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="M400 256c0 26.5 21.5 48 48 48s48-21.5 48-48S474.5 208 448 208S400 229.5 400 256zM112 256c0-26.5-21.5-48-48-48S16 229.5 16 256S37.5 304 64 304S112 282.5 112 256zM304 256c0-26.5-21.5-48-48-48S208 229.5 208 256S229.5 304 256 304S304 282.5 304 256z"/>
                    </svg>
                </button>
              </div>
            </form>
          </div>

          <div class="mt-10">
            <div class="relative">
              <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-200" />
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="relative hidden w-0 flex-1 lg:block">
      <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1496917756835-20cb06e75b4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80" alt="" />
    </div>
  </div>
</section>
</template>

<style scoped>

</style>
