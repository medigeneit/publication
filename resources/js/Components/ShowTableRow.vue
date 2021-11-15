<template>
    <tr class="bg-blue-600 text-sm leading-normal">
        <th class="p-2 text-right bg-gray-200 uppercase align-top">{{ heading }}</th> 
        <td class="p-2 text-left bg-white">
            <slot/>
        </td>
    </tr>
</template>

<script>
export default {
    props: {
        heading: { type: String, default: "" }
    }
}
</script>