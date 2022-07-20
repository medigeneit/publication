<template>
    <div
        v-if="item.active"
        class="overflow-hidden col-span-6 md:col-span-4 lg:col-span-2 border border-white-200 shadow-md relative transition ease-in-out delay-100 hover:translate-y-1 hover:scale-110 duration-300 bg-white rounded-lg p-6 hover:z-50 cursor-pointer hover:bg-gradient-to-br hover:from-white hover:to-gray-300"
        :class="{
            'border-2 border-blue-500 bg-gradient-to-br from-white to-blue-200':
                clicked,
            'bg-green-300': item.copy_quantity == item.total_recieved,
        }"
        @click="itemClicked"
    >
        <div class="">
            <div
                class="absolute right-0 top-0 h-16 w-16 hover:z-40 transition ease-in-out delay-100 hover:translate-y-1 hover:scale-110 duration-300"
            >
                <div
                    class="absolute transform rotate-45 text-center text-sm text-white font-bold left-[-66px] top-[30px] w-[170px] bg-gradient-to-r from-orange-400 to-amber-500"
                >
                    Printing {{ item.active }}
                </div>
            </div>

            <a href="#">
                <div class="font-bold text-sm">Sl: {{ item.id }}</div>

                <!-- :class="{'bg-gradient-to-r from-orange-300 to-amber-200': item.requested_by.name == 'Your Outlet'}" -->
                <div
                    class="mb-2 -ml-6 text-2xl font-bold tracking-tight text-white-900"
                >
                    <!-- <div class="ml-6">{{ item.requested_by.name }}</div> -->
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
                    {{ item.product_name }}
                </a>
            </div>
            <div class="mb-3 text-sm">
                Copy order
                <span class="text-sm font-extrabold"
                    >{{ item.copy_quantity }} pcs
                </span>
                to
                <span class="font-extrabold">
                    {{ item.press ?? "all" }}
                </span>
            </div>
            <div class="mb-3">
                <p class="font-extrabold text-sm">Order Date:</p>
                {{ item.order_date }}
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
        // this.item.responses.forEach((res) => {
        //     this.isClosed = res.status == 5;
        // });
    },
};
</script>
