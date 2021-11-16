<template>
    <nav-link :href="route('dashboard')" :active="route().current('dashboard')">
        Dashboard
    </nav-link>
    <nav-link :href="route('users.index')" :active="route().current('users.*')">
        Users
    </nav-link>
    <nav-link :href="route('categories.index')" :active="route().current('categories.*')">
        Categories
    </nav-link>
    <nav-link :href="route('authors.index')" :active="route().current('authors.*')">
        Authors
    </nav-link>
    <nav-link :href="route('products.index')" :active="route().current('products.*')">
        Products
    </nav-link>
    <nav-link :href="route('publishers.index')" :active="route().current('publishers.*')">
        Publisher
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