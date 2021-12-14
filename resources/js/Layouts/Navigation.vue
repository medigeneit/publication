<template>
    <nav-link :href="route('dashboard')" :active="route().current('dashboard')">
        Dashboard
    </nav-link>

    <nav-link-wrapper title="Publication" :active="route().current('(users|categories|authors|publishers|products).*')"> 
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
    </nav-link-wrapper>

    <nav-link-wrapper title="Stock & Circulation" :active="route().current('(outlets|distributions|storages).*')"> 
        <nav-link :href="route('outlets.index')" :active="route().current('outlets.*')">
            Outlets
        </nav-link>

        <nav-link :href="route('distributions.index')" :active="route().current('distributions.*')">
            Distributor
        </nav-link>
        <nav-link :href="route('storages.index')" :active="route().current('storages.*')">
            Storages
        </nav-link>
    </nav-link-wrapper>

    <nav-link-wrapper title="Sales" :active="route().current('sales.*')">
        <nav-link :href="route('sales.index')" :active="route().current('sales.*')">
            Sales
        </nav-link>
    </nav-link-wrapper>

    <nav-link-wrapper title="Accounts" :active="route().current('(account-categories|accounts|incomes|expenses).*')">
        <nav-link :href="route('account-categories.index')" :active="route().current('account-categories.*')">
            Account Category
        </nav-link>

        <nav-link :href="route('accounts.index')" :active="route().current('accounts.*')">
            Account
        </nav-link>

        <nav-link :href="route('incomes.index')" :active="route().current('incomes.*')">
            Income
        </nav-link>

        <nav-link :href="route('expenses.index')" :active="route().current('expenses.*')">
            Expense
        </nav-link> 
    </nav-link-wrapper>
</template>

<script>
import NavLink from '@/Components/NavLink.vue';
import NavLinkWrapper from '@/Components/NavLinkWrapper.vue';
export default {
    components: {
        NavLink,
        NavLinkWrapper
    },
}
</script>