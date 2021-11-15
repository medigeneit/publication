<template>
    <span @click="goBack" class="text-center font-bold cursor-pointer border border-blue-500 text-blue-600 hover:bg-blue-500 hover:text-white rounded-lg px-3 py-1.5">
        Go to list
    </span>
</template>

<script>
export default {
    props: {
        href: { type: String, default: '#' }
    },
    methods: {
        goBack() {
            this.$inertia.get(localStorage.getItem('historyOfList') || this.href);
        },
    },
}
</script>