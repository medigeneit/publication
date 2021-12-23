<template>
    <div class="w-full sm:max-w-xs bg-white shadow-md rounded-xl overflow-hidden relative">
        <div class="flex items-center gap-4 p-4">
            <div class="text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <slot>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </slot>
                </svg>
            </div>
            <div class="flex-auto">
                <div class="w-full text-gray-600 text-4xl" v-if="$props.count !== null">{{ count }}</div>
                <div class="w-full text-gray-800 text-lg">{{ title }}</div>
            </div>
        </div>
        <Link v-if="href" :href="href" class="absolute inset-0"></Link>
        <div v-else class="absolute inset-0"></div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
    components: {
        Link,
    },
    props: {
        href: {
            type: String,
            default: null
        },
        count: {
            type: Number,
            default: null
        },
        title: {
            type: String,
            required: true,
        },
    }
}
</script>