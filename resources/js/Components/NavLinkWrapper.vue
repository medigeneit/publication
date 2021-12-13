<template>
    <div class="py-1 px-2 text-base cursor-pointer flex justify-between items-center gap-2 font-medium" @click="expand = ! expand">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span>{{ title }}</span>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" :class="{ 'transform rotate-180' : expand }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>
    <div v-show="expand" class="pl-3">
        <slot />
    </div>
</template>

<script>

export default {
    props: {
        title: {
            type: String,
            required: true,
        },
        active: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            expand: false,
        }
    },
    created() {
        this.expand =  this.active || false;
    }
}
</script>
