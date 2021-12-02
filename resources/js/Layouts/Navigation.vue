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

    <nav-link :href="route('publishers.index')" :active="route().current('publishers.*')">
        Publisher
    </nav-link>

    <nav-link :href="route('products.index')" :active="route().current('products.*')">
        Products
    </nav-link>

    <nav-link :href="route('outlets.index')" :active="route().current('outlets.*')">
        Outlets
    </nav-link>

    <nav-link :href="route('distributions.index')" :active="route().current('distributions.*')">
        Distributions
    </nav-link>
    
    <nav-link :href="route('sales.index')" :active="route().current('sales.*')">
        Sales
    </nav-link>

    <nav-link :href="route('storages.index')" :active="route().current('storages.*')">
        Storages
    </nav-link>

    <nav-link :href="route('account-categories.index')" :active="route().current('account-categories.*')">
        Account Category
    </nav-link>

    <nav-link :href="route('accounts.index')" :active="route().current('accounts.*')">
        Account
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