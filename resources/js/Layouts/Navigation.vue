<template>
    <nav-link :href="route('dashboard')" :active="route().current('dashboard')">
        Dashboard
    </nav-link>

    <nav-link-wrapper
        title="Administration"
        :active="route().current('(users).*')"
    >
        <nav-link
            :href="route('users.index')"
            :active="route().current('users.*')"
        >
            Admins
        </nav-link>
    </nav-link-wrapper>

    <nav-link-wrapper
        title="Roles"
        :active="route().current('(roles).*')"
    >
        <nav-link
            :href="route('roles.index')"
            :active="route().current('roles.*')"
        >
            Roles
        </nav-link>
    </nav-link-wrapper>

    <nav-link-wrapper
        title="Production Management"
        :active="route().current(
            '(publishers|productions|versions|moderator-types|contributors|moderators|categories|price-categories|products|packages|authors|presses|version-variables).*'
            )"
    >
        <nav-link-wrapper
            title="Publication Prerequisite"
            :active="
                route().current(
                    '(categories|price-categories|packages|authors|publishers|moderator-types|presses|version-variables).*'
                )
            "
        >
            <nav-link
                :href="route('categories.index')"
                :active="route().current('categories.*')"
            >
                Categories
            </nav-link>
            <nav-link
                :href="route('price-categories.index')"
                :active="route().current('price-categories.*')"
            >
                Price Category
            </nav-link>

            <nav-link
                :href="route('authors.index')"
                :active="route().current('authors.*')"
            >
                Authors
            </nav-link>
            <nav-link
                :href="route('publishers.index')"
                :active="route().current('publishers.*')"
            >
                Publishers
            </nav-link>
            <nav-link
                :href="route('moderator-types.index')"
                :active="route().current('moderator-types.*')"
            >
               Contributor Types
            </nav-link>
            <nav-link
                :href="route('packages.index')"
                :active="route().current('packages.*')"
            >
                Packages
            </nav-link>
            <nav-link
                :href="route('version-variables.index')"
                :active="route().current('version-variables.*')"
            >
                Cost Variables
            </nav-link>

              <nav-link
                :href="route('presses.index')"
                :active="route().current('presses.*')">
                Presses
            </nav-link>
        </nav-link-wrapper>

        <nav-link
            :href="route('productions.index')"
            :active="route().current('productions.*')"
        >
            Raw Products
        </nav-link>
        <nav-link
            :href="route('versions.index')"
            :active="route().current('versions.*')"
        >
            Release Versions
        </nav-link>

        <!-- <nav-link
            :href="route('printing-costs.index')"
            :active="route().current('printing-costs.*')"
        >
            Printing-details
        </nav-link> -->

        <nav-link
            :href="route('products.index')"
            :active="route().current('products.*')"
        >
            Products
        </nav-link>
    </nav-link-wrapper>



    <nav-link-wrapper
        title="Stock & Circulation"
        :active="route().current('(outlets|distributions|storages|circulations).*')"
    >
        <nav-link
            :href="route('outlets.index')"
            :active="route().current('outlets.*')"
        >
            Outlets
        </nav-link>
        <nav-link
            :href="route('distributions.index')"
            :active="route().current('distributions.*')"
        >
            Distributor
        </nav-link>
        <nav-link
            :href="route('storages.index')"
            :active="route().current('storages.*')"
        >
            Storages
        </nav-link>
        <nav-link
            :href="route('circulations.index')"
            :active="route().current('circulations.*')"
        >
            Circulaion
        </nav-link>
    </nav-link-wrapper>

    <nav-link-wrapper title="Sales" :active="route().current('sales.*')">
        <nav-link
            :href="route('sales.index')"
            :active="route().current('sales.*')"
        >
            Sales
        </nav-link>
    </nav-link-wrapper>

    <nav-link-wrapper
        title="Accounts"
        :active="
            route().current('(account-categories|accounts|incomes|expenses).*')
        "
    >
        <nav-link
            :href="route('account-categories.index')"
            :active="route().current('account-categories.*')"
        >
            Account Category
        </nav-link>

        <nav-link
            :href="route('accounts.index')"
            :active="route().current('accounts.*')"
        >
            Account
        </nav-link>

        <nav-link
            :href="route('incomes.index')"
            :active="route().current('incomes.*')"
        >
            Income
        </nav-link>

        <nav-link
            :href="route('expenses.index')"
            :active="route().current('expenses.*')"
        >
            Expense
        </nav-link>
    </nav-link-wrapper>
</template>

<script>
import NavLink from "@/Components/NavLink.vue";
import NavLinkWrapper from "@/Components/NavLinkWrapper.vue";
export default {
    components: {
        NavLink,
        NavLinkWrapper,
    },
};
</script>
