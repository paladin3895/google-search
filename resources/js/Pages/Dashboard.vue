<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Keywords" />

    <AuthenticatedLayout>
        <div class="flex h-screen antialiased text-gray-900 bg-gray-100 dark:bg-dark dark:text-light">
            <section class="fixed inset-y-0 z-12 flex-shrink-0 w-64 bg-white border-r dark:border-indigo-800 dark:bg-darker lg:static focus:outline-none">
                <div class="flex flex-col h-screen">
                    <!-- Panel header -->
                    <div class="flex-shrink-0">
                        <div class="px-4 pt-4 border-b dark:border-indigo-800">
                            <div class="flex">
                            <h2 class="pb-4 font-semibold">Keywords</h2>
                            <button type="button" class="flex ml-auto mb-3 text-xs text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                <vue-feather type="upload" size="16" class="mr-3" />
                                Upload
                            </button>
                            </div>
                        </div>
                    </div>

                    <!-- Panel content -->
                    <div class="flex-shrink-0">
                        <div v-for="keyword in items" class="px-4 pt-3 pb-3 border-b dark:border-indigo-800">
                            <template v-if="keyword.state === 'processed'">
                                <a @click="openPage(keyword)" href="javascript:void(0)" class="flex">
                                    <h2 class="pb-3 font-semibold">{{ keyword.key }}</h2>
                                    <small class="flex ml-auto">
                                        {{ formatDatetime(keyword.updated_at) }}
                                    </small>
                                </a>
                                <div class="flex">
                                    <small>Links: {{ keyword.links }}</small>
                                    <small class="flex ml-auto">Adwords: {{ keyword.adwords }}</small>
                                </div>
                                <span class="text-xs" v-html="keyword.results"></span>
                            </template>
                            <template v-else>
                                <div class="flex">
                                    <h2 class="font-semibold">{{ keyword.key }}</h2>
                                    <small class="flex ml-auto">
                                        Processing...
                                    </small>
                                </div>
                            </template>
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
<script charset="utf-8">
import moment from 'moment';
import http from 'axios';

export default {

    data() {
        return {
            items: [],
        }
    },

    props: {
        token: {
            type: String,
        },
        keywords: {
            type: Array,
        },
    },

    components: {

    },

    created() {
        this.items = this.keywords || [];

        // polling for keywords changed
        setInterval(this.fetchData, 5000);
    },

    mounted() {
        document.body.classList.add('overflow-y-hidden');
    },

    unmounted() {
        document.body.classList.remove('overflow-y-hidden');
    },

    methods: {
        fetchData() {
            return http.get('/api/keywords', {
                headers: {
                    authorization: `Bearer ${this.token}`
                }
            })
                .then(res => {
                    this.items = res.data;
                })
        },

        formatDatetime(dt) {
            return moment(dt).calendar();
        },
    },
}
</script>
