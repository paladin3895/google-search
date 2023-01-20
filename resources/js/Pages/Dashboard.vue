<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Keywords" />

    <AuthenticatedLayout>
        <div class="flex h-screen antialiased text-gray-900 bg-gray-100 dark:bg-dark dark:text-light">
            <section class="fixed inset-y-0 z-12 flex-shrink-0 w-75 bg-white border-r dark:border-indigo-800 dark:bg-darker lg:static focus:outline-none">
                <div class="flex flex-col overflow-y-auto" style="height: calc(100vh - 80px)">
                    <!-- Panel header -->
                    <div class="flex-shrink-0">
                        <div class="px-3 pt-4 border-b dark:border-indigo-800">
                            <div class="flex">
                            <h2 class="pb-4 font-semibold">Keywords</h2>
                            <label for="keyword-upload" type="button" class="flex ml-auto mb-3 text-xs text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                <input @change.prevent="uploadFile" id="keyword-upload" type="file" style="display: none;">
                                <vue-feather type="upload" size="16" class="mr-3" />
                                Upload
                            </label>
                            </div>
                        </div>
                    </div>

                    <!-- Panel content -->
                    <div class="flex-shrink-0">
                        <div v-for="keyword in items" class="px-3 pt-3 pb-3 border-b dark:border-indigo-800">
                            <template v-if="keyword.state === 'processed'">
                                <a @click="openPage(keyword)" href="javascript:void(0)" class="flex">
                                    <h2 class="pb-3 font-semibold" :title="keyword.key">{{ formatKeyword(keyword.key) }}</h2>
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
                    <iframe ref="search-page" class="w-full h-full"></iframe>
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
            currentItem: null,
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
        setInterval(this.fetchData, 15000);
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
            }).then(res => {
                this.items = res.data;
            })
        },

        openPage(keyword) {
            return http.get(`/api/keywords/${keyword.id}`, {
                headers: {
                    authorization: `Bearer ${this.token}`
                }
            }).then(res => {
                this.currentItem = res.data;
                this.$refs['search-page'].contentDocument.documentElement.innerHTML = this.currentItem.html || '<div><i>Page HTML is not available</i></div>';
            })
        },

        uploadFile(e) {
            const file = e.target.files[0];
            const formData = new FormData();
            formData.append('file', file);

            return http.post('/api/keywords/csv', formData, {
                headers: {
                    authorization: `Bearer ${this.token}`
                }
            }).then(this.fetchData)
        },

        getLink(keyword) {
            return `/api/keywords/${keyword.id}/html`;
        },

        formatDatetime(dt) {
            return moment(dt).calendar();
        },

        formatKeyword(keyword) {
            // limit keyword length to 15 chars
            if (String(keyword).length > 15) {
                return String(keyword).slice(0, 12) + '...';
            }

            return keyword;
        },
    },
}
</script>
