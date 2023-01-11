<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="flex h-screen antialiased text-gray-900 bg-gray-100 dark:bg-dark dark:text-light">
            <aside class="fixed inset-y-0 z-10 flex-shrink-0 w-64 bg-white border-r lg:static dark:border-indigo-800 dark:bg-darker focus:outline-none">
                <div class="flex flex-col h-full">
                    <!-- Sidebar links -->
                    <nav aria-label="Main" class="flex-1 px-2 py-4 space-y-2 overflow-y-hidden hover:overflow-y-auto">
                        <!-- Dashboards links -->
                        <div>
                            <!-- active & hover classes 'bg-indigo-100 dark:bg-indigo-600' -->
                            <a class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-indigo-100 dark:hover:bg-indigo-600" role="button" aria-haspopup="true" aria-expanded="false">
                                <span aria-hidden="true">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                </span>
                                <span class="ml-2 text-sm"> Dashboards </span>
                                <span class="ml-auto" aria-hidden="true">
                                    <!-- active class 'rotate-180' -->
                                    <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                            </a>
                            <div role="menu" class="mt-2 space-y-2 px-7" aria-label="Dashboards" style="display: none;">
                                <!-- active & hover classes 'text-gray-700 dark:text-light' -->
                                <!-- inActive classes 'text-gray-400 dark:text-gray-400' -->
                                <a role="menuitem" class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                                    Default
                                </a>
                                <a role="menuitem" class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:hover:text-light hover:text-gray-700">
                                    Project Mangement
                                </a>
                                <a role="menuitem" class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:hover:text-light hover:text-gray-700">
                                    E-Commerce
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </aside>
            <section class="fixed inset-y-0 z-10 flex-shrink-0 w-64 bg-white border-r dark:border-indigo-800 dark:bg-darker lg:static focus:outline-none">
                <div class="flex flex-col h-screen">
                    <!-- Panel header -->
                    <div class="flex-shrink-0">
                        <div class="px-4 pt-4 border-b dark:border-indigo-800">
                            <h2 class="pb-4 font-semibold">Header</h2>
                        </div>
                    </div>

                    <!-- Panel content -->
                    <div class="flex-1 pt-4 overflow-y-hidden hover:overflow-y-auto">
                        <div class="space-y-4">
                            <!-- Content -->
                            <p class="px-4">Content</p>
                        </div>
                    </div>
                </div>
            </section>
            <main class="flex-1">
                <div class="flex flex-col items-center justify-center flex-1 h-full min-h-screen p-4 overflow-x-hidden overflow-y-auto">
                    <h1 class="mb-4 text-2xl font-semibold text-center md:text-3xl">Two Columns Sidebar</h1>
                    <div class="mb-4">
                        <div class="relative flex p-1 space-x-1 bg-white shadow-md w-80 h-72 dark:bg-darker">
                            <div class="w-16 h-full bg-gray-200 dark:bg-dark"></div>
                            <div class="w-16 h-full bg-gray-200 dark:bg-dark"></div>
                            <div class="flex-1 h-full bg-gray-100 dark:bg-dark"></div>
                        </div>
                    </div>
                    <div>
                        <p class="text-center">See full project</p>
                        <a target="_blank" class="text-base text-blue-600 hover:underline">Live</a>
                        <a target="_blank" class="ml-4 text-base text-blue-600 hover:underline">Github repo</a>
                    </div>
                </div>
            </main>
        </div>
    </AuthenticatedLayout>
</template>
