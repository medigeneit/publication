<template>
    <div
        v-if="!isClosed"
        class="overflow-hidden col-span-6 md:col-span-4 lg:col-span-2 border border-white-200 shadow-md relative transition ease-in-out delay-100 hover:translate-y-1 hover:scale-110 duration-300 bg-white rounded-lg p-6 hover:z-50 cursor-pointer"
        
        :class="{
                        'border-2 border-blue-500 bg-gradient-to-br from-white to-gray-300':
                            item.type == 1 && clicked,
                        'border-2 border-rose-500 bg-gradient-to-br from-white to-gray-300':
                            item.type == 2 && clicked,
                    }"
        @click="itemClicked"
    >
        <div class="">
            <div
                class="absolute right-0 top-0 h-16 w-16 hover:z-40 transition ease-in-out delay-100 hover:translate-y-1 hover:scale-110 duration-300"
            >
                <div
                    class="absolute transform rotate-45 text-center text-sm text-white font-bold left-[-66px] top-[30px] w-[170px]"
                    :class="{
                        'bg-gradient-to-r from-sky-400 to-blue-500':
                            item.type == 1,
                        'bg-gradient-to-r from-rose-400 to-rose-500':
                            item.type == 2,
                    }"
                >
                    {{ item.type_name }}
                </div>
            </div>

            <a href="#">
                <div class="font-bold text-sm">Sl: {{ item.id }}</div>
                <div
                    class="mb-2 -ml-6 text-2xl font-bold tracking-tight text-white-900"
                    :class="{'bg-gradient-to-r from-orange-300 to-amber-200': item.requested_by.name == 'Your Outlet'}"
                >
                    <div class="ml-6">{{ item.requested_by.name }}</div>
                </div>
            </a>
            <div class="mb-3 font-extrabold">
                <!-- route('product-requests.index', {
                            product: item.product_info.id,
                        }) -->
                <a
                    href="#
                    "
                >
                    {{ item.product_info.product_name }}
                </a>
            </div>
            <div class="mb-3 text-sm">
                {{ item.type_name }}
                <span class="text-sm font-extrabold"
                    >{{ item.product_quantity }} pcs
                </span>
                to
                <span class="font-extrabold">
                    {{ item.requested_to.name ?? "all" }}
                </span>
            </div>
            <div class="mb-3">
                <p class="font-extrabold text-sm unde">Expected Date:</p>
                {{ item.expected_date }}
            </div>

            <!-- @click="
                    circulaitonShow = !circulaitonShow;
                    productRequest = item;
                    form.request_id = item.id;
                    clicked[index] = true;

                    clickHandler(index);
                    divShow($event, item.id);
                " -->

            <!-- <div
                class="inline-flex ite-ms-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 cursor-pointer"
                @click="itemClicked"
            >
                Details
            </div> -->
        </div>
    </div>
</template>

<script>
export default {
    name: "product-request-item",
    emits: ["clicked"],
    props: ["item", "clicked"],
    data() {
        return {
            isClosed: false,
        };
    },
    methods: {
        itemClicked() {
            this.$emit("clicked", { item: this.item });
        },
    },
    created() {
        // this.form.from = this.$page.url.includes("outlet_id=")
        //     ? this.$page.url.split("?")[1].split("=")[1]
        //     : "";

        this.item.responses.forEach((res) => {
            this.isClosed = res.status == 5;
        });
    },
};
</script>
