<template>
    <div class="p-2 overflow-scroll h-72">
        <ul
            class="fixed md:static inset-0 overflow-auto w-full max-w-sm rounded border bg-white p-4 z-30"
        >
            <li>
                <input
                    placeholder="Search..."
                    @input="searchProduct"
                    class="px-2 py-2 w-full rounded border border-gray-500 focus:outline-none focus:ring-0"
                />
            </li>
             <!-- :class="{
                    'bg-green-400':
                        form.price_type_infos[index].product_ids.includes(
                            productId
                        ),
                }" -->
            <li
                class="w-full p-2 border-b cursor-pointer flex justify-between"
                v-for="(product, productId) in products"
                :key="productId"
                :class="{ 'bg-green-200' : selected.includes(productId)}"
                @click="selectProductHandler(productId)"
            >
                <div class="w-full">
                    {{ product.name }}
                </div>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    props: ['products', 'form', 'index'],
    emits: ["productSelected"],
    data() {
        return {
            selected : []
        }
    },
    methods: {
        searchProduct(event) {
            let url = this.route(this.routeName || this.route().current(), {
                selected: this.selected.toString(),
                search: !event.target.value.includes("\\")
                    ? event.target.value
                    : "",
            });

            this.$inertia.get(url, {}, { preserveState: true });
        },

        selectProductHandler(productId) {
            if (this.selected.includes(productId)) {
                let index = this.selected.indexOf(productId);

                this.selected.splice(index, 1);
                // return this.selected;
            }
            else {
                this.selected.push(productId)
            }
            return this.$emit("productSelected", { index: this.index, selected: this.selected })
        }
    }
}
</script>
