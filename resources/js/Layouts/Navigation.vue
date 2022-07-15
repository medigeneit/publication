<template>
    <nav-link :href="route('dashboard')" :active="route().current('dashboard')">
        Dashboard
    </nav-link>

    <nav-link-wrapper
        title="Administration"
        :active="route().current('(users).*')"
        v-if="$can('Admin List')"
    >
        <nav-link
            :href="route('users.index')"
            :active="route().current('users.*')"
            v-if="$can('Admin List')"
        >
            Admins
        </nav-link>
    </nav-link-wrapper>

    <nav-link-wrapper
        title="Roles"
        :active="route().current('(roles).*')"
        v-if="$can('Roles List')"
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
        :active="
            route().current(
                '(publishers|productions|versions|moderator-types|contributors|moderators|categories|price-categories|products|packages|authors|presses|version-variables).*'
            )
        "
        v-if="
            $can(
                'Publisher List|Raw Product List|Version List|Contributor Type List|Author List|Category List|Price Category List|Presses List'
            )
        "
    >
        <nav-link-wrapper
            title="Publication Prerequisite"
            :active="
                route().current(
                    '(categories|price-categories|packages|authors|publishers|moderator-types|presses|version-variables).*'
                )
            "
            v-if="
                $can(
                    'Publisher List|Version List|Contributor Type List|Author List|Category List|Price Category List|Presses List'
                )
            "
        >
            <nav-link
                :href="route('categories.index')"
                :active="route().current('categories.*')"
                v-if="$can('Category List')"
            >
                Categories
            </nav-link>
            <nav-link
                :href="route('price-categories.index')"
                :active="route().current('price-categories.*')"
                v-if="$can('Price Category List')"
            >
                Price Category
            </nav-link>

            <nav-link
                :href="route('authors.index')"
                :active="route().current('authors.*')"
                v-if="$can('Author List')"
            >
                Authors
            </nav-link>
            <nav-link
                :href="route('publishers.index')"
                :active="route().current('publishers.*')"
                v-if="$can('Publisher List')"
            >
                Publishers
            </nav-link>
            <nav-link
                :href="route('moderator-types.index')"
                :active="route().current('moderator-types.*')"
                v-if="$can('Contributor Type List')"
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
                :active="route().current('presses.*')"
                v-if="$can('Presses List')"
            >
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

    <nav-link
        v-if="$page.props.outlet_id"
        :href="
            route('product-requests.index', {
                outlet_id: $page.props.outlet_id,
            })
        "
        :active="route().current('product-requests.*')"
    >
        <div class="flex items-center gap-2">
            <svg
                class="h-8 w-8"
                version="1.1"
                viewBox="0 0 752 752"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="m353.76 287.04c-81.109-41.863-149.14 13.082-214.55 102.04l91.578 94.191 39.246-47.098h191l154.37-138.67c-39.246-49.715-99.426 20.934-170.07 75.879h-68.027c-10.465-5.2344-18.316-10.465-20.934-20.934h83.727c23.547-23.547 20.934-44.48-5.2344-65.41z"
                    fill-rule="evenodd"
                />
            </svg>

            Product Request
        </div>
    </nav-link>

    <nav-link-wrapper
        title="Stock & Circulation"
        :active="
            route().current('(outlets|distributions|storages|circulations).*')
        "
        v-if="$can('')"
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
