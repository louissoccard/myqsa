<template>
    <div class="min-h-screen">
        <Head :title="title"/>
        <header
            class="fixed top-0 left-0 right-0 z-30 h-16 py-4 bg-gray-50 dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between h-full px-6 mx-auto text-grey-80 dark:text-grey-5">
                <Link :href="route('dashboard')">
                    <Logo width="w-24"></Logo>
                </Link>
                <div class="flex items-center flex-shrink-0">
                    <!-- Notifications Menu -->
                    <Dropdown width="72">
                        <template #trigger>
                            <button class="flex items-center focus:shadow-outline-purple focus:outline-none"
                                    aria-label="Notifications" aria-haspopup="true"
                                    @click="showingMobileSidebar = false">
                                <Feather class="inline" :size="24" icon="bell"/>
                                <Feather class="inline" :size="16" icon="chevron-down"/>
                            </button>
                        </template>
                        <template #content>
                            <DropdownItem class="py-20 text-center">
                                <h6 class="text-lg font-bold">No Notifications</h6>
                                <span>(Not yet implemented)</span>

                            </DropdownItem>
                        </template>
                    </Dropdown>

                    <!-- User Menu -->
                    <Dropdown width="72" class="hidden md:inline">
                        <template #trigger>
                            <button class="ml-4 flex items-center focus:shadow-outline-purple focus:outline-none"
                                    aria-label="Account" aria-haspopup="true">
                                <Feather class="inline" :size="24" icon="user"/>
                                <Feather class="inline" :size="16" icon="chevron-down"/>
                            </button>
                        </template>
                        <template #content>
                            <DropdownItem class="px-6 py-4 border-b border-gray-300 dark:border-gray-700">
                                <h4 class="text-xl font-bold">{{ fullName }}</h4>
                                <p class="text-sm">{{ this.user.district }}</p>
                            </DropdownItem>
                            <DropdownItem :href="route('profile.show')" icon="user" class="flex items-center">
                                <span class="inline">Manage Account</span>
                            </DropdownItem>
                            <DropdownItem @click="signOut" icon="lock"
                                          class="bg-red text-white hover:text-grey-80 dark:hover:text-grey-5 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 flex items-center">
                                <span class="inline font-bold">Sign Out</span>
                            </DropdownItem>
                        </template>
                    </Dropdown>

                    <!-- Hamburger -->
                    <button
                        class="inline md:hidden flex items-center ml-3 focus:shadow-outline-purple focus:outline-none"
                        aria-label="Main Menu" aria-haspopup="true" @click="showingMobileSidebar = true"
                        v-show="!showingMobileSidebar">
                        <Feather class="inline" :size="24" icon="menu"/>
                    </button>

                    <!-- Close -->
                    <button
                        class="inline md:hidden flex items-center ml-3 focus:shadow-outline-purple focus:outline-none"
                        aria-label="Main Menu" aria-haspopup="true" @click="showingMobileSidebar = false"
                        v-show="showingMobileSidebar">
                        <Feather class="inline" :size="24" icon="x"/>
                    </button>
                </div>
            </div>
        </header>
        <div class="fixed inset-0 flex">
            <!-- Desktop Sidebar -->
            <aside
                class="z-20 hidden fixed left-0 bottom-0 top-16 w-64 overflow-y-auto bg-gray-100 dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 md:flex flex-shrink-0 shadow cursor-default select-none">
                <div class="flex-1 flex flex-col justify-between py-4 text-black dark:text-white">
                    <MainMenu class="mb-3"></MainMenu>
                    <div class="inline-block px-6 text-grey-60 text-sm dark:text-grey-20">
                        <h6 class="font-normal">© Hampshire Scouts 2022</h6>
                        <a class="font-bold hover:text-blue dark:hover:text-white" href="#">Privacy Policy</a>
                    </div>

                </div>
            </aside>

            <!-- Mobile Sidebar -->
            <transition
                enter-active-class="transition ease-in-out duration-200"
                enter-from-class="opacity-0 transform -translate-x-20"
                enter-to-class="opacity-100"
                leave-active-class="transition ease-in-out duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0 transform -translate-x-20">
                <div v-show="showingMobileSidebar"
                     class="flex fixed inset-y-0 z-50 flex-shrink-0 mt-16 overflow-y-auto bg-gray-100 dark:bg-gray-800 md:hidden min-w-72 max-w-9/10"
                     @click="showingMobileSidebar = false">
                    <aside class="flex flex-1 flex-col justify-between py-4 text-black dark:text-white">
                        <div class="mb-3">
                            <DropdownItem class="px-6">
                                <h4 class="text-xl font-bold">{{ fullName }}</h4>
                                <p class="text-sm">{{ this.user.district }}</p>
                            </DropdownItem>
                            <div class="w-full my-3 px-3">
                                <div class="w-full h-0.5 border-b border-gray-200 dark:border-gray-700"></div>
                            </div>
                            <MainMenu></MainMenu>
                            <div class="w-full my-3 px-3">
                                <div class="w-full h-0.5 border-b border-gray-200 dark:border-gray-700"></div>
                            </div>
                            <MainMenuItem :href="route('profile.show')" class="font-bold" icon="user">
                                <span class="inline">Manage Account</span>
                            </MainMenuItem>
                            <MainMenuItem @click="signOut"
                                          class="bg-red text-white hover:text-gray-500 dark:hover:text-gray-400 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-900"
                                          icon="lock">
                                <span class="inline font-bold">Sign Out</span>
                            </MainMenuItem>
                        </div>
                        <div class="inline-block px-6 text-grey-60 text-sm dark:text-grey-20">
                            <h6 class="font-normal">© Hampshire Scouts 2022</h6>
                            <a class="font-bold hover:text-blue dark:hover:text-white" href="#">Privacy Policy</a>
                        </div>
                    </aside>
                </div>
            </transition>

            <!-- Full Screen Sidebar Overlay -->
            <transition
                leave-active-class="transition-opacity ease-in-out duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-show="showingMobileSidebar" class="opacity-100">
                    <div
                        class="fixed top-16 bottom-0 inset-x-0 z-40 bg-grey-80 opacity-25"
                        @click="showingMobileSidebar = false"></div>
                </div>
            </transition>

            <div class="relative w-full mt-16 md:ml-64">
                <main>
                    <div class="absolute inset-0 mx-auto p-6 md:py-10 md:px-10"
                         :class="{ 'overflow-y-hidden': showingMobileSidebar, 'overflow-y-auto': !showingMobileSidebar }">
                        <slot></slot>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent} from 'vue'
import {Head, Link} from '@inertiajs/inertia-vue3';
import Logo from "@/Components/Logo";
import Dropdown from "@/Components/Interface/Dropdown";
import Feather from "@/Components/Feather";
import DropdownItem from "@/Components/Interface/DropdownItem";
import MainMenu from "@/Components/Interface/MainMenu";
import MainMenuItem from "@/Components/Interface/MainMenuItem";

export default defineComponent({
    props: {
        title: String,
        user: Object,
    },

    components: {
        MainMenuItem,
        MainMenu,
        DropdownItem,
        Dropdown,
        Logo,
        Head,
        Link,
        Feather,
    },

    data() {
        return {
            showingMobileSidebar: false,
        }
    },

    methods: {
        signOut() {
            this.$inertia.post(route('sign-out'));
        },
    },

    computed: {
        fullName() {
            return this.user.first_name + ' ' + this.user.last_name;
        }
    }
})
</script>
