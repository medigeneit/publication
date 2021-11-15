<template>
    <nav-link :href="route('dashboard')" :active="route().current('dashboard')">
        Dashboard
    </nav-link>
    <nav-link :href="route('users.index')" :active="route().current('users.*')">
        Users
    </nav-link>
</template>

<script>
import NavLink from '@/Components/NavLink.vue';
export default {
    components: {
        NavLink,
    },
}
</script>