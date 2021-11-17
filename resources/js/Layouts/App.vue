<template>
    <div class="min-h-screen bg-gray-100">
        <header class="bg-white w-full shadow z-40 px-2">
            <div class="flex justify-between items-center h-16">
                <!-- Hamburger -->
                <div class="flex items-center">
                    <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 focus:text-gray-700 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Page Heading -->
                <h3 class="px-2 text-blue-800 text-xs sm:text-sm h-16 overflow-hidden flex justify-center items-center">
                    <slot name="header" />
                </h3>

                <div class="min-w-max flex items-center">
                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center gap-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="hidden sm:block">{{ $page.props.auth.user.name }}</span>
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <dropdown-link :href="route('logout')" method="post" as="button">
                                    Log Out
                                </dropdown-link>
                            </template>
                        </dropdown>
                    </div>
                </div>
            </div>
        </header>

        <div class="w-full flex z-30 overflow-hidden">
            <nav class="bg-white shadow w-full sm:max-w-max fixed sm:static top-16 left-0 overflow-hidden z-30">
                <!-- Navigation Menu -->
                <div :class="{'block sm:hidden': showingNavigationDropdown, 'hidden sm:block': ! showingNavigationDropdown}" class="h-screen -mt-16 pt-16 overflow-auto">
                    <navigation />
                </div>
            </nav>

            <!-- Page Content -->
            <main class="w-full h-screen -mt-16 pt-16 overflow-hidden">
                <div class="h-full p-2 sm:p-4 overflow-auto">
                    <slot />
                </div>
            </main>
        </div>

    </div>

</template>

<script>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Navigation from './Navigation.vue';

export default {
    components: {
        ApplicationLogo,
        Dropdown,
        DropdownLink,
        NavLink,
        Link,
        Navigation,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        }
    },
}
</script>
