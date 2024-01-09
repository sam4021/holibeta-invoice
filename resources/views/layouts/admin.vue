<script setup lang="ts">
import { onMounted, computed } from "vue";
import { initFlowbite } from "flowbite";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import Toast from "@/views/components/general-components/toast.vue";
onMounted(() => {
    initFlowbite();
});
let form = useForm({});
const roles = computed(() => usePage().props.auth.role)

const logout = () => {
    form.post(route("logout"), {
        onSuccess: () => {},
    });
};
</script>

<template>
    <Teleport to="body">
        <toast :toast="$page.props.toast"></toast>
    </Teleport>
    <div class="sm:hidden flex justify-between gap-2 z-[100000] p-2 w-full bg-white shadow">
        <div>
            <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button">
                <svg class="fill-sky-700 h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path
                        d="M424 392H23.1C10.8 392 0 402.8 0 415.1C0 429.2 10.8 440 23.1 440H424c13.2 0 24-10.8 24-23.1C448 402.8 437.2 392 424 392zM424 72H23.1C10.8 72 0 82.8 0 95.1S10.8 120 23.1 120H424c13.2 0 24-10.8 24-23.1S437.2 72 424 72zM424 232H23.1C10.8 232 0 242.8 0 256c0 13.2 10.8 24 23.1 24H424C437.2 280 448 269.2 448 256S437.2 232 424 232z"
                    />
                </svg>
            </button>
        </div>

        <div>
            <button class="flex gap-2 items-center" data-dropdown-toggle="dropdownMenu">
                <span class="font-bold">{{ $page.props.auth.name }}</span>
                <img :src="'/images/lady-smiling-on-call.jpg'" alt="Profile picture" class="h-10 rounded-full"/>
            </button>

            <!-- Dropdown menu -->
            <div id="dropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 divide-y" aria-labelledby="dropdownDefaultButton">
                    <li>
                        <Link href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</Link>
                    </li>
                    <li>
                        <button @click="logout" class="block px-4 py-2 hover:bg-gray-100">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-white shadow-r-lg border-r" aria-label="Sidebar">
        <div class="h-full px-5 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
            <div class="my-3">
                <h1 class="font-bold text-lg">SMART FARM</h1>
            </div>
            <div class="my-5 bg-sky-50 rounded-xl p-2">
                <div class="flex gap-2 items-center border-b py-3 border-gray-300" >
                    <div>
                        <img alt="User profile" :src="'/images/lady-smiling-on-call.jpg'" class="h-11 rounded-full" />
                    </div>
                    <div>
                        <h6 class="font-bold text-sm">
                            {{ $page.props.auth.name }}
                        </h6>
                        <Link :href="route('auth.editProfile')" class="text-sky-700 text-sm" >Edit profile</Link>
                    </div>
                </div>
                <div class="py-3">
                    <h6 class="text-gray-600 font-medium text-sm">Role</h6>
                    <h2 class="text-xl font-black text-sky-700">
                        <span v-if="roles.length > 1" class="text-sm">
                            <span v-for="role in roles" :key="role">{{ role }} ,</span>
                        </span>
                        <span v-else>
                            {{ roles[0] }}
                        </span>
                        
                    </h2>
                </div>
            </div>
            <ul class="space-y-2 font-medium pt-3 min-h-[45vh] border-b border-gray-300 text-sm">
                <li>
                    <Link :href="route('admin.index')" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-sky-700 hover:bg-gray-100 group" :class="{'bg-gray-100 text-sky-700':$page.component === 'admin/index',}" data-drawer-hide="default-sidebar">
                        <svg class="h-5 fill-gray-900 group-hover:fill-sky-700" :class="{ 'fill-sky-700': $page.component === 'admin/index', }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M488 392H251.9C241.7 359.6 211.8 336 176 336s-65.69 23.62-75.93 56H24C10.75 392 0 402.7 0 416s10.75 24 24 24h76.07C110.3 472.4 140.2 496 176 496s65.69-23.62 75.93-56H488c13.25 0 24-10.75 24-24S501.3 392 488 392zM176 448c-17.64 0-32-14.36-32-32s14.36-32 32-32s32 14.36 32 32S193.6 448 176 448zM488 232h-76.07C401.7 199.6 371.8 176 336 176s-65.69 23.62-75.93 56H24C10.75 232 0 242.7 0 256s10.75 24 24 24h236.1C270.3 312.4 300.2 336 336 336s65.69-23.62 75.93-56H488C501.3 280 512 269.3 512 256S501.3 232 488 232zM336 288c-17.64 0-32-14.36-32-32s14.36-32 32-32s32 14.36 32 32S353.6 288 336 288zM24 120h108.1C142.3 152.4 172.2 176 208 176s65.69-23.62 75.93-56H488C501.3 120 512 109.3 512 96s-10.75-24-24-24h-204.1C273.7 39.62 243.8 16 208 16S142.3 39.62 132.1 72H24C10.75 72 0 82.75 0 96S10.75 120 24 120zM208 64c17.64 0 32 14.36 32 32s-14.36 32-32 32s-32-14.36-32-32S190.4 64 208 64z"
                            />
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </Link>
                </li>                
                <li v-if="roles.includes('Admin') || roles.includes('Security Supervisor')">
                    <Link :href="route('delivery.index')" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-sky-700 hover:bg-gray-100 group" :class="{ 'bg-gray-100 text-sky-700': $page.component === 'admin/delivery/index', }" data-drawer-hide="default-sidebar">                        
                        <svg class="h-5 fill-gray-900 group-hover:fill-sky-700" :class="{ 'fill-sky-700': $page.component === 'admin/delivery/index', }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M384 223.1L368 224V144c0-79.41-64.59-144-144-144S80 64.59 80 144V224L64 223.1c-35.35 0-64 28.65-64 64v160c0 35.34 28.65 64 64 64h320c35.35 0 64-28.66 64-64v-160C448 252.7 419.3 223.1 384 223.1zM144 144C144 99.88 179.9 64 224 64s80 35.88 80 80V224h-160V144z"/>
                        </svg>
                        <span class="ml-3">Security</span>
                    </Link>
                </li>
                <li v-if="roles.includes('Admin') || roles.includes('Weighbridge Operator') || roles.includes('Weighbridge Supervisor')">
                    <Link :href="route('weighbridge.index')" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-sky-700 hover:bg-gray-100 group" :class="{ 'bg-gray-100 text-sky-700': $page.component === 'admin/weighbridge/index', }" data-drawer-hide="default-sidebar">
                        <svg class="h-5 fill-gray-900 group-hover:fill-sky-700" :class="{'fill-sky-700':$page.component ==='admin/weighbridge/index',}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M256 264c22.12 0 40-17.88 40-40c0-10.5-4.25-20-11-27.12l33.75-78.63c3.5-8.125-.375-17.5-8.5-21c-8-3.5-17.5 .25-21 8.5L255.8 184C233.8 184.3 216 202 216 224C216 246.1 233.9 264 256 264zM440 64h-48.23C359.5 24.91 310.7 0 256 0C201.3 0 152.5 24.91 120.2 64H72C32.3 64 0 96.31 0 136v304C0 479.7 32.3 512 72 512h368c39.7 0 72-32.31 72-72v-304C512 96.31 479.7 64 440 64zM256 48c70.58 0 128 57.42 128 128s-57.42 128-128 128s-128-57.42-128-128S185.4 48 256 48zM464 440c0 13.22-10.77 24-24 24H72c-13.23 0-24-10.78-24-24v-304c0-13.22 10.77-24 24-24h20.18C84.42 131.9 80 153.4 80 176C80 273.2 158.8 352 256 352c97.2 0 176-78.8 176-176c0-22.61-4.414-44.14-12.18-64H440c13.23 0 24 10.78 24 24V440z"/>
                        </svg>
                        <span class="ml-3">Weighbridge</span>
                    </Link>
                </li>
                <li v-if="roles.includes('Admin') || roles.includes('Grain Inspector') || roles.includes('Laboratory Supervisor')">
                    <Link :href="route('quality-control.index')" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-sky-700 hover:bg-gray-100 group" :class="{ 'bg-gray-100 text-sky-700': $page.component === 'admin/quality-control/index', }" data-drawer-hide="default-sidebar" >                        
                    <svg class="h-5 fill-gray-900 group-hover:fill-sky-700" :class="{ 'fill-sky-700': $page.component === 'admin/quality-control/index', }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <path d="M543.8 256c0-35.5-19.21-68.25-49.46-85.5c9.125-33.63-.4117-70.38-25.54-95.5c-25.12-25.12-61.71-34.5-95.34-25.38C356.3 19.38 323.3 0 287.8 0S219.8 19.38 202.5 49.63C168.9 40.5 131.1 49.88 106.8 75S72.5 136.9 81.63 170.5C51.38 187.8 31.84 220.5 31.84 256s19.54 68.25 49.79 85.5C72.5 375.1 81.71 411.9 106.8 437c26.5 26.5 63.54 34.13 95.66 25.38C219.9 492.6 252.3 512 287.8 512s68.29-19.38 85.66-49.63c32.75 8.875 69.21 .75 95.34-25.38c25.12-25.12 34.66-61.88 25.54-95.5C524.6 324.3 543.8 291.5 543.8 256zM452.9 324.3c5.375 11.88 29.5 54.13-6.5 90.13c-28.88 28.88-57.5 21.38-90.13 6.5C351.8 433 339 480 288 480c-52.13 0-64.75-49.5-68.25-59.13c-32.63 14.88-61.38 22.25-90.13-6.5c-36.88-36.63-10.88-80.5-6.5-90.13C111 319.8 64 307 64 256c0-52.13 49.5-64.75 59.13-68.25c-5.375-11.88-29.5-54.13 6.5-90.13c36.75-36.88 80.75-10.75 90.13-6.5C224.3 79 237 32 288 32c52.13 0 64.75 49.5 68.25 59.13c11.88-5.375 54.13-29.5 90.13 6.5c36.88 36.63 10.88 80.5 6.5 90.13C465 192.3 512 205 512 256C512 308.1 462.5 320.8 452.9 324.3zM356.7 191.4L261.3 286.7L219.3 244.7c-6.25-6.25-16.38-6.25-22.62 0s-6.25 16.38 0 22.62l53.34 53.33c3.125 3.125 7.219 4.688 11.31 4.688s8.188-1.562 11.31-4.688l106.7-106.7c6.25-6.25 6.25-16.38 0-22.62S362.9 185.1 356.7 191.4z"/>
                    </svg>
                        <span class="ml-3">QC</span>
                    </Link>
                </li>
                <li v-if="roles.includes('Admin') || roles.includes('Store Manager') || roles.includes('Store Officer') || roles.includes('Store Supervisor')">
                    <Link :href="route('warehouse.index')" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-sky-700 hover:bg-gray-100 group" :class="{ 'bg-gray-100 text-sky-700': $page.component === 'admin/warehouse/index' }" data-drawer-hide="default-sidebar">                        
                        <svg class="h-5 fill-gray-900 group-hover:fill-sky-700" :class="{ 'fill-sky-700': $page.component === 'admin/warehouse/index', }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path d="M215.5 105.1C208.8 99.03 200.4 96 191.1 96S175.2 99.03 168.5 105.1L17.14 242.7C6.223 252.6 0 266.7 0 281.4V464C0 490.5 21.49 512 48 512h287.1c26.51 0 48-21.31 48-47.82L384 281.2c0-14.65-6.238-28.61-17.08-38.46L215.5 105.1zM335.1 464H48V281.4c0-1.229 .5215-2.406 1.43-3.23l142.6-129.6l142.7 129.7C335.6 279.1 336 280 336 281.1L335.1 464zM452 288L416 288l-.0013 64L452 352c6.625 0 12-5.375 12-12v-40C464 293.4 458.6 288 452 288zM452 192h-40C405.4 192 400 197.4 400 204v40C400 250.6 405.4 256 412 256h40C458.6 256 464 250.6 464 244v-40C464 197.4 458.6 192 452 192zM224 288h-64.01C151.1 288 144 295.1 144 304v64c0 8.875 7.125 16 16 16h64c8.875 0 16-7.125 16-16v-64C240 295.1 232.9 288 224 288zM548 192h-40C501.4 192 496 197.4 496 204v40C496 250.6 501.4 256 508 256h40C554.6 256 560 250.6 560 244v-40C560 197.4 554.6 192 548 192zM576 0h-192c-35.35 0-64 28.65-64 64v72C320 149.3 330.7 160 344 160s24-10.75 24-24V64c0-8.838 7.164-16 16-16h192c8.836 0 16 7.162 16 16v424c0 13.25 10.75 24 24 24S640 501.3 640 488V64C640 28.65 611.3 0 576 0zM452 96h-40C405.4 96 400 101.4 400 108v40C400 154.6 405.4 160 412 160h40C458.6 160 464 154.6 464 148v-40C464 101.4 458.6 96 452 96zM548 96h-40C501.4 96 496 101.4 496 108v40C496 154.6 501.4 160 508 160h40C554.6 160 560 154.6 560 148v-40C560 101.4 554.6 96 548 96zM548 288h-40C501.4 288 496 293.4 496 300v40c0 6.625 5.375 12 12 12h40c6.625 0 12-5.375 12-12v-40C560 293.4 554.6 288 548 288z"/>
                        </svg>
                        <span class="ml-3">Warehouse</span>
                    </Link>
                </li>
                <li v-if="roles.includes('Admin') || roles.includes('Store Manager') || roles.includes('Store Officer') || roles.includes('Store Supervisor')">
                    <Link :href="route('warehouse.bags')" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-sky-700 hover:bg-gray-100 group" :class="{ 'bg-gray-100 text-sky-700': $page.component === 'admin/warehouse/bags', }"  data-drawer-hide="default-sidebar">
                        <svg class="h-5 fill-gray-900 group-hover:fill-sky-700" :class="{ 'fill-sky-700': $page.component === 'admin/warehouse/bags', }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" data-slot="icon">
                            <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-3">Bags</span>
                    </Link>
                </li>
                <li v-if="roles.includes('Admin') || roles.includes('Store Manager')  || roles.includes('Store Supervisor')">
                    <Link :href="route('reports')" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-sky-700 hover:bg-gray-100 group" :class="{ 'bg-gray-100 text-sky-700': $page.component === 'admin/report', }"  data-drawer-hide="default-sidebar">
                        <svg class="h-5 fill-gray-900 group-hover:fill-sky-700" :class="{ 'fill-sky-700': $page.component === 'admin/report', }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" >
                            <path
                                d="M80 256v64c0 17.67 14.33 32 32 32h160c17.67 0 32-14.33 32-32V256c0-17.67-14.33-32-32-32h-160C94.33 224 80 238.3 80 256zM365.3 93.38l-74.63-74.64C278.6 6.742 262.3 0 245.4 0H64C28.65 0 0 28.65 0 64l.0065 384c0 35.34 28.65 64 64 64H320c35.2 0 64-28.8 64-64V138.6C384 121.7 377.3 105.4 365.3 93.38zM336 448c0 8.836-7.164 16-16 16H64.02c-8.838 0-16-7.164-16-16L48 64.13c0-8.836 7.164-16 16-16h160L224 128c0 17.67 14.33 32 32 32h79.1V448zM96 128h80C184.8 128 192 120.8 192 112S184.8 96 176 96H96C87.16 96 80 103.2 80 112S87.16 128 96 128zM96 192h80C184.8 192 192 184.8 192 176S184.8 160 176 160H96C87.16 160 80 167.2 80 176S87.16 192 96 192zM288 384h-80c-8.844 0-16 7.156-16 16s7.156 16 16 16H288c8.844 0 16-7.156 16-16S296.8 384 288 384z"
                            />
                        </svg>
                        <span class="ml-3">Reports</span>
                    </Link>
                </li>
                <li v-if="roles.includes('Admin')">
                    <Link :href="route('admin.users.index')" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-sky-700 hover:bg-gray-100 group" :class="{ 'bg-gray-100 text-sky-700': $page.component === 'admin/users/index', }"  data-drawer-hide="default-sidebar">
                        <svg
                            class="h-5 fill-gray-900 group-hover:fill-sky-700"
                            :class="{
                                'fill-sky-700':
                                    $page.component === 'admin/users/index',
                            }"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"
                        >
                            <path
                                d="M272 304h-96C78.8 304 0 382.8 0 480c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32C448 382.8 369.2 304 272 304zM48.99 464C56.89 400.9 110.8 352 176 352h96c65.16 0 119.1 48.95 127 112H48.99zM224 256c70.69 0 128-57.31 128-128c0-70.69-57.31-128-128-128S96 57.31 96 128C96 198.7 153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80S144 172.1 144 128C144 83.89 179.9 48 224 48z"
                            />
                        </svg>

                        <span class="ml-3">Users</span>
                    </Link>
                </li>
                <li v-if="roles.includes('Admin')">
                    <Link :href="route('admin.roles.index')" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-sky-700 hover:bg-gray-100 group" :class="{ 'bg-gray-100 text-sky-700': $page.component === 'admin/roles/index', }" data-drawer-hide="default-sidebar">
                        <svg class="h-5 fill-gray-900 group-hover:fill-sky-700" :class="{ 'fill-sky-700': $page.component === 'admin/roles/index', }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path
                                d="M384 192h-32V127.1c0-70.58-57.42-127.1-128-127.1s-128 57.42-128 127.1V192H64C28.65 192 0 220.7 0 256v191.1c0 35.35 28.65 64 64 64h320c35.35 0 64-28.65 64-64V256C448 220.7 419.3 192 384 192zM144 128c0-44.11 35.89-80 80-80s80 35.89 80 80v64h-160V128zM400 448c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16V256c0-8.822 7.178-16 16-16h320c8.822 0 16 7.178 16 16V448z"
                            />
                        </svg>
                        <span class="ml-3">Roles</span>
                    </Link>
                </li>
            </ul>
            <div class="my-5">
                <ul class="space-y-2 font-medium pt-3 text-sm">
                    <li v-if="roles.includes('Admin')">
                        <button type="button" class="flex items-center gap-2 py-3 hover:bg-white/5 text-gray-900 hover:text-gray-900 w-full text-start px-3" id="dropdownHoverButton" data-dropdown-offset-distance="2" data-dropdown-placement="right-start" data-dropdown-toggle="settingsDrop">
                            <svg class="h-5 fill-gray-900 group-hover:fill-sky-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path
                                    d="M504.1 315.1c0-8.652-4.607-16.84-12.36-21.39l-32.91-18.97C459.5 269.1 459.8 262.5 459.8 256s-.3228-13.1-.9683-19.62l32.91-18.97c7.752-4.548 12.36-12.74 12.36-21.39c0-21.27-49.32-128.2-84.52-128.2c-4.244 0-8.51 1.094-12.37 3.357l-32.78 18.97c-10.71-7.742-22.07-14.32-34.07-19.74V32.49c0-11.23-7.484-21.04-18.33-23.88C300.5 2.871 278.3 0 256 0C233.8 0 211.5 2.871 189.9 8.613C179.1 11.45 171.6 21.26 171.6 32.49v37.94c-12 5.42-23.36 12-34.07 19.74l-32.78-18.97C100.9 68.94 96.63 67.85 92.38 67.85c-.0025 0 .0025 0 0 0c-32.46 0-84.52 101.7-84.52 128.2c0 8.652 4.607 16.84 12.36 21.39l32.91 18.97C52.49 242.9 52.17 249.5 52.17 256s.3228 13.1 .9683 19.62L20.23 294.6C12.47 299.1 7.867 307.3 7.867 315.1c0 21.27 49.32 128.2 84.52 128.2c4.244 0 8.51-1.094 12.37-3.357l32.78-18.97c10.71 7.742 22.07 14.32 34.07 19.74v37.94c0 11.23 7.484 21.04 18.33 23.88C211.5 509.1 233.7 512 255.1 512c22.25 0 44.47-2.871 66.08-8.613c10.84-2.84 18.33-12.65 18.33-23.88v-37.94c12-5.42 23.36-12 34.07-19.74l32.78 18.97c3.855 2.264 8.123 3.357 12.37 3.357C452.1 444.2 504.1 342.4 504.1 315.1zM415.2 389.1l-43.66-25.26c-42.06 30.39-32.33 24.73-79.17 45.89v50.24c-13.29 2.341-25.58 3.18-36.44 3.18c-15.42 0-27.95-1.693-36.36-3.176v-50.24c-46.95-21.21-37.18-15.54-79.17-45.89l-43.64 25.25c-15.74-18.69-28.07-40.05-36.41-63.11L103.1 301.7C101.4 276.1 100.1 266.1 100.1 256c0-10.02 1.268-20.08 3.81-45.76L60.37 185.2C68.69 162.1 81.05 140.7 96.77 122l43.66 25.26c42.06-30.39 32.33-24.73 79.17-45.89V51.18c13.29-2.341 25.58-3.18 36.44-3.18c15.42 0 27.95 1.693 36.36 3.176v50.24c46.95 21.21 37.18 15.54 79.17 45.89l43.64-25.25c15.74 18.69 28.07 40.05 36.4 63.11L408 210.3c2.538 25.64 3.81 35.64 3.81 45.68c0 10.02-1.268 20.08-3.81 45.76l43.58 25.12C443.3 349.9 430.9 371.3 415.2 389.1zM256 159.1c-52.88 0-96 43.13-96 96S203.1 351.1 256 351.1s96-43.13 96-96S308.9 159.1 256 159.1zM256 304C229.5 304 208 282.5 208 256S229.5 208 256 208s48 21.53 48 48S282.5 304 256 304z"
                                />
                            </svg>

                            <span class="ml-3">Settings</span>
                        </button>
                        <div
                            id="settingsDrop"
                            class="z-50 hidden bg-white border rounded-lg shadow w-44"
                        >
                            <ul class="text-sm text-gray-900 font-medium divide-y" aria-labelledby="dropdownHoverButton">
                                <li>
                                    <Link :href="route('suppliers.index')" class="block px-4 py-3 hover:bg-sumo-500/20">Suppliers</Link>
                                </li>
                                <li>
                                    <Link :href="route('drivers.index')" class="block px-4 py-3 hover:bg-sumo-500/20">Drivers</Link>
                                </li>
                                <!-- <li>
                                    <Link
                                        :href="route('vehicles.index')"
                                        class="block px-4 py-3 hover:bg-sumo-500/20"
                                        >Vehicles</Link
                                    >
                                </li> -->
                                <!-- <li>
                                    <Link
                                        :href="route('grains.index')"
                                        class="block px-4 py-3 hover:bg-sumo-500/20"
                                        >Grains</Link
                                    >
                                </li> -->
                            </ul>
                        </div>
                    </li>

                    <li>
                        <button
                            @click="logout()"
                            class="flex items-center p-2 text-gray-900 rounded-lg hover:text-sky-700 hover:bg-gray-100 group"
                        >
                            <svg
                                class="h-5 fill-gray-900 group-hover:fill-sky-700"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"
                            >
                                <path
                                    d="M312 336c6.156 0 12.28-2.344 16.97-7.031c9.375-9.375 9.375-24.56 0-33.94L81.94 48H192c13.25 0 24-10.75 24-24S205.3 0 192 0H24C10.75 0 0 10.75 0 24V192c0 13.25 10.75 24 24 24S48 205.3 48 192V81.94l247 247C299.7 333.7 305.8 336 312 336zM288 64c-13.25 0-24 10.75-24 24S274.8 112 288 112c97.03 0 176 78.97 176 176s-78.97 176-176 176S112 385 112 288c0-13.25-10.75-24-24-24S64 274.8 64 288c0 123.5 100.5 224 224 224s224-100.5 224-224S411.5 64 288 64z"
                                />
                            </svg>

                            <span class="ml-3">Logout</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <div class="p-4 sm:ml-64 bg-gray-50">
        <div class="hidden sm:block">
            <div class="flex justify-between">
                <div class="flex gap-3 items-center">
                    <img
                        alt="Profile Picture"
                        :src="'/images/lady-smiling-on-call.jpg'"
                        class="h-12 rounded-full border border-white"
                    />
                    <h1 class="text-lg font-bold">
                        Hello {{ $page.props.auth.name }}, Welcome!
                    </h1>
                </div>
                <div class="flex gap-2 items-center">
                    <div>
                        <button
                            class="rounded-full h-10 w-10 bg-white flex items-center place-content-center border"
                        >
                            <svg
                                class="h-5 fill-gray-600"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 448 512"
                            >
                                <path
                                    d="M439.4 362.3C420.1 341.5 383.9 310.2 383.9 208c0-77.75-54.38-139.9-127.9-155.1V32c0-17.62-14.38-32-32-32S192 14.38 192 32v20.88C118.5 68.12 64.13 130.2 64.13 208c0 102.2-36.25 133.5-55.5 154.3C2.625 368.8 0 376.5 0 384c.125 16.38 13 32 32.13 32h383.8c19.12 0 32-15.62 32.13-32C448 376.5 445.4 368.8 439.4 362.3zM67.5 368C88.75 340 112 293.6 112 208.6V208C112 146.1 162.1 96 224 96s112 50.12 112 112v.625C336 293.6 359.2 340 380.5 368H67.5zM223.1 512C259.4 512 288 483.4 288 448H160C160 483.4 188.6 512 223.1 512z"
                                />
                            </svg>
                        </button>
                    </div>
                    <div>
                        <button class="btn-primary btn-medium">Logout</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-5">
            <slot></slot>
        </div>
    </div>
</template>

<style scoped></style>
