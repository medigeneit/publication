<template>
    <div
        class="overflow-hidden col-span-6 md:col-span-4 lg:col-span-2"
        v-for="(item, index) in productRequests.data"
        :key="index"
        :class="{
            'border border-green-600 bg-gradient-to-r from-gray-400 via-gray-200 to-white':
                clicked[index],
        }"
    >
        <div
            class="border border-white-200 shadow-md relative transition ease-in-out delay-100 hover:translate-y-1 hover:scale-110 duration-300 bg-white rounded-lg p-6"
        >
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
                <h5
                    class="mb-2 text-2xl font-bold tracking-tight text-white-900"
                >
                    {{ item.requested_by.name }}
                </h5>
            </a>
            <div class="mb-3 font-extrabold">
                <!-- route('product-requests.index', {
                        outlet_id: form.from,
                        product: item.product_info.id,
                    }) -->
                <a
                    :href="
                        route('product-requests.index', {
                            product: item.product_info.id,
                        })
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

            <div
                class="inline-flex ite-ms-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 cursor-pointer"
                @click="
                    circulaitonShow = !circulaitonShow;
                    productRequest = item;
                    form.request_id = item.id;
                    clicked[index] = true;

                    clickHandler(index);
                    divShow($event, item.id);
                "
            >
                Details
            </div>
        </div>

        <div class="fixed inset-0 hidden z-50 text-black">
            <div
                class="relative w-full h-full flex justify-center items-center"
            >
                <div
                    class="relative p-2 w-full max-w-7xl bg-white rounded border shadow z-50"
                >
                    <div class="text-center">
                        <div class="font-bold text-sm">Sl: {{ item.id }}</div>
                        <div class="font-bold text-lg">
                            {{ item.requested_by.name }}
                            {{
                                item.requested_by.name == "Your Outlet"
                                    ? `(${your_outlets[form.from]})`
                                    : ""
                            }}
                        </div>
                        <div class="font-extrabold text-base">
                            {{ item.product_info.product_name }}
                        </div>
                        <div>
                            <span
                                class="px-2 rounded-sm font-extrabold"
                                :class="{
                                    'text-blue-500': item.type == 1,
                                    'text-red-500': item.type == 2,
                                }"
                            >
                                {{ item.type_name }}
                            </span>
                            <span class="font-bold text-base"
                                >{{ item.product_quantity }} pcs</span
                            >
                            to
                            <span class="font-extrabold text-base">
                                {{
                                    item.requested_to.length
                                        ? item.requested_to.name
                                        : "all"
                                }}</span
                            >
                            <div class="text-sm">
                                Expected Date:
                                <span class="font-extrabold text-base">{{
                                    item.expected_date
                                }}</span>
                            </div>
                        </div>
                    </div>
                    <hr class="my-1" />
                    <div class="p-3">
                        <div class="bg-white rounded border shadow z-50">
                            <div class="p-3 grid grid-cols-12 gap-2">
                                <div class="col-span-6 border-r-2">
                                    <div class="flex justify-between">
                                        <h1 class="underline font-extrabold">
                                            On The Way
                                        </h1>
                                        <div
                                            class="cursor-pointer px-2 mr-2 bg-gray-500 text-white rounded"
                                            v-if="
                                                item.button_access.includes(
                                                    'stock_out'
                                                )
                                            "
                                            @click="modalHandler"
                                        >
                                            Send
                                        </div>
                                        <div class="fixed inset-0 z-50 hidden">
                                            <div
                                                class="relative w-full h-full flex justify-center items-center"
                                            >
                                                <div
                                                    class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50"
                                                >
                                                    <div
                                                        class="text-lg font-bold text-center"
                                                    >
                                                        Send
                                                    </div>
                                                    <hr class="my-1" />
                                                    <div class="p-3">
                                                        <form
                                                            @submit.prevent="
                                                                send
                                                            "
                                                            class=""
                                                        >
                                                            <Label
                                                                value="Send Quantity"
                                                            />
                                                            <input
                                                                type="number"
                                                                class="mt-1 block w-full"
                                                                placeholder="Quantity"
                                                                v-model="
                                                                    form.quantity
                                                                "
                                                                required
                                                            />
                                                            <Button
                                                                type="submit"
                                                                class="bg-gray-600 text-white px-2 py-1 rounded mt-2"
                                                            >
                                                                Submit
                                                            </Button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div
                                                    class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40"
                                                >
                                                    <div
                                                        class="w-full h-full"
                                                        @click="closeModal"
                                                    ></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="border-2 shadow rounded-md px-2 my-2 mr-2"
                                        :class="{
                                            'bg-green-200':
                                                Math.abs(
                                                    circulation.quantity
                                                ) == circulation.total_received,
                                        }"
                                        v-for="circulation in item.circulations"
                                        :key="circulation"
                                    >
                                        <span class="text-sm">
                                            {{ circulation.circulationDate }}
                                        </span>
                                        <div class="flex justify-between">
                                            <div>
                                                <span class="font-extrabold">
                                                    {{
                                                        circulation.circulation_of
                                                    }}
                                                </span>
                                                <span>
                                                    {{
                                                        circulation.quantity < 0
                                                            ? " sends "
                                                            : " recieved "
                                                    }}
                                                </span>
                                                <span class="font-extrabold">
                                                    {{
                                                        Math.abs(
                                                            circulation.quantity
                                                        )
                                                    }}
                                                    pcs
                                                </span>
                                                <span>
                                                    {{
                                                        circulation.quantity < 0
                                                            ? " to "
                                                            : " from "
                                                    }}
                                                </span>
                                                <span class="font-extrabold">
                                                    {{
                                                        circulation.destination
                                                    }}
                                                </span>
                                            </div>
                                            <div class="pb-2">
                                                <div
                                                    class="px-2 mr-2 bg-gray-500 text-white rounded cursor-pointer"
                                                    v-if="
                                                        item.button_access.includes(
                                                            'stock_in'
                                                        ) &&
                                                        Math.abs(
                                                            circulation.quantity
                                                        ) !=
                                                            circulation.total_received
                                                    "
                                                    @click="
                                                        form.circulation_id =
                                                            circulation.id;
                                                        modalHandler($event);
                                                    "
                                                >
                                                    Recieve
                                                </div>
                                                <div
                                                    class="fixed inset-0 z-50 hidden"
                                                >
                                                    <div
                                                        class="relative w-full h-full flex justify-center items-center"
                                                    >
                                                        <div
                                                            class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50"
                                                        >
                                                            <div
                                                                class="text-sm text-center"
                                                            >
                                                                {{
                                                                    circulation.quantity <
                                                                    0
                                                                        ? " Sends "
                                                                        : " Recieved "
                                                                }}
                                                                <span
                                                                    class="font-bold"
                                                                >
                                                                    {{
                                                                        Math.abs(
                                                                            circulation.quantity
                                                                        )
                                                                    }}
                                                                    pcs
                                                                </span>

                                                                and Recieved
                                                                <span
                                                                    class="font-bold"
                                                                >
                                                                    {{
                                                                        circulation.total_received
                                                                    }}
                                                                    pcs
                                                                </span>
                                                            </div>
                                                            <hr class="my-1" />
                                                            <div class="p-3">
                                                                <form
                                                                    @submit.prevent="
                                                                        recieve
                                                                    "
                                                                    class=""
                                                                >
                                                                    <Label
                                                                        value="Send Quantity"
                                                                    />
                                                                    <input
                                                                        type="number"
                                                                        class="mt-1 block w-full"
                                                                        placeholder="Quantity"
                                                                        v-model="
                                                                            form.quantity
                                                                        "
                                                                        required
                                                                    />
                                                                    <Button
                                                                        type="submit"
                                                                        class="bg-gray-600 text-white px-2 py-1 rounded mt-2"
                                                                    >
                                                                        Submit
                                                                    </Button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40"
                                                        >
                                                            <div
                                                                class="w-full h-full"
                                                                @click="
                                                                    closeModal
                                                                "
                                                            ></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="ml-5"
                                            v-for="circulation in circulation.circulations"
                                            :key="circulation"
                                        >
                                            <span class="text-sm">
                                                {{
                                                    circulation.circulationDate
                                                }}
                                            </span>
                                            <div>
                                                <!-- {{ circulation }} -->
                                                <span class="font-extrabold">
                                                    {{
                                                        circulation.circulation_of
                                                    }}
                                                </span>
                                                <span>
                                                    {{
                                                        circulation.quantity < 0
                                                            ? " sends "
                                                            : " recieved "
                                                    }}
                                                </span>
                                                <span class="font-extrabold">
                                                    {{
                                                        Math.abs(
                                                            circulation.quantity
                                                        )
                                                    }}
                                                    pcs
                                                </span>
                                                <span>
                                                    {{
                                                        circulation.quantity < 0
                                                            ? " to "
                                                            : " from "
                                                    }}
                                                </span>
                                                <span class="font-extrabold">
                                                    {{
                                                        circulation.destination
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-6">
                                    <div class="flex justify-between">
                                        <h1 class="underline font-extrabold">
                                            Responses
                                        </h1>
                                        <div class="">
                                            <span
                                                class="cursor-pointer px-2 mr-2 bg-gray-500 text-white rounded"
                                                v-if="
                                                    item.button_access.includes(
                                                        'request_accept'
                                                    )
                                                "
                                                @click="
                                                    modalHandler($event);
                                                    form.request_id = item.id;
                                                "
                                            >
                                                Accept
                                            </span>
                                            <div
                                                class="fixed inset-0 z-50 hidden"
                                            >
                                                <div
                                                    class="relative w-full h-full flex justify-center items-center"
                                                >
                                                    <div
                                                        class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50"
                                                    >
                                                        <div
                                                            class="text-sm text-center"
                                                        >
                                                            Accept
                                                        </div>
                                                        <hr class="my-1" />
                                                        <div class="p-3">
                                                            <form
                                                                @submit.prevent="
                                                                    accept
                                                                "
                                                                class=""
                                                            >
                                                                <input
                                                                    type="number"
                                                                    class="mt-1 block w-full"
                                                                    placeholder="Accept Quantity"
                                                                    v-model="
                                                                        form.accept_quantity
                                                                    "
                                                                    required
                                                                />
                                                                <input
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    placeholder="Note"
                                                                    v-model="
                                                                        form.note
                                                                    "
                                                                />
                                                                <Button
                                                                    type="submit"
                                                                    class="bg-gray-600 text-white px-2 py-1 rounded mt-2"
                                                                >
                                                                    Submit
                                                                </Button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40"
                                                    >
                                                        <div
                                                            class="w-full h-full"
                                                            @click="closeModal"
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span
                                                class="cursor-pointer px-2 mr-2 bg-gray-500 text-white rounded"
                                                v-if="
                                                    item.button_access.includes(
                                                        'request_deny'
                                                    )
                                                "
                                                @click="
                                                    modalHandler($event);
                                                    form.request_id = item.id;
                                                "
                                            >
                                                Deny
                                            </span>
                                            <div
                                                class="fixed inset-0 z-50 hidden"
                                            >
                                                <div
                                                    class="relative w-full h-full flex justify-center items-center"
                                                >
                                                    <div
                                                        class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50"
                                                    >
                                                        <div
                                                            class="text-sm text-center"
                                                        >
                                                            Deny
                                                        </div>
                                                        <hr class="my-1" />
                                                        <div class="p-3">
                                                            <form
                                                                @submit.prevent="
                                                                    deny
                                                                "
                                                            >
                                                                <input
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    placeholder="Note"
                                                                    v-model="
                                                                        form.note
                                                                    "
                                                                />
                                                                <Button
                                                                    type="submit"
                                                                    class="bg-gray-600 text-white px-2 py-1 rounded mt-2"
                                                                >
                                                                    Submit
                                                                </Button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40"
                                                    >
                                                        <div
                                                            class="w-full h-full"
                                                            @click="closeModal"
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <span
                                                class="cursor-pointer px-2 mr-2 bg-gray-500 text-white rounded"
                                                v-if="
                                                    item.button_access.includes(
                                                        'request_edit'
                                                    )
                                                "
                                                @click="
                                                    modalHandler($event);
                                                    form.request_id = item.id;
                                                    form.expected_date =
                                                        item.expected_date;
                                                    form.type = item.type;
                                                    form.request_quantity =
                                                        item.product_quantity;
                                                    form.note = item.note;
                                                "
                                            >
                                                Edit
                                            </span>
                                            <div
                                                class="fixed inset-0 z-50 hidden"
                                            >
                                                <div
                                                    class="relative w-full h-full flex justify-center items-center"
                                                >
                                                    <div
                                                        class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50"
                                                    >
                                                        <div
                                                            class="text-sm text-center"
                                                        >
                                                            Edit
                                                        </div>
                                                        <hr class="my-1" />
                                                        <div class="p-3">
                                                            <form
                                                                @submit.prevent="
                                                                    edit
                                                                "
                                                            >
                                                                <input
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    placeholder="Quantity"
                                                                    v-model="
                                                                        form.request_quantity
                                                                    "
                                                                    required
                                                                />
                                                                <input
                                                                    type="date"
                                                                    class="mt-1 block w-full"
                                                                    placeholder="Quantity"
                                                                    v-model="
                                                                        form.expected_date
                                                                    "
                                                                    required
                                                                />

                                                                <Select
                                                                    class="mt-1 block w-full"
                                                                    name=""
                                                                    id=""
                                                                    v-model="
                                                                        form.type
                                                                    "
                                                                >
                                                                    <option
                                                                        v-for="(
                                                                            type,
                                                                            index
                                                                        ) in types"
                                                                        :key="
                                                                            index
                                                                        "
                                                                        :value="
                                                                            index
                                                                        "
                                                                    >
                                                                        {{
                                                                            type
                                                                        }}
                                                                    </option>
                                                                </Select>
                                                                <Select
                                                                    class="mt-1 block w-full"
                                                                    name=""
                                                                    id=""
                                                                    v-model="
                                                                        form.requested_to
                                                                    "
                                                                >
                                                                    <option
                                                                        value=""
                                                                    >
                                                                        To All
                                                                    </option>
                                                                    <option
                                                                        v-for="(
                                                                            outlet,
                                                                            index
                                                                        ) in outlets"
                                                                        :key="
                                                                            index
                                                                        "
                                                                        :value="
                                                                            index
                                                                        "
                                                                    >
                                                                        {{
                                                                            outlet
                                                                        }}
                                                                    </option>
                                                                </Select>
                                                                <input
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    placeholder="Note"
                                                                    v-model="
                                                                        form.note
                                                                    "
                                                                />
                                                                <Button
                                                                    type="submit"
                                                                    class="bg-gray-600 text-white px-2 py-1 rounded mt-2"
                                                                >
                                                                    Submit
                                                                </Button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40"
                                                    >
                                                        <div
                                                            class="w-full h-full"
                                                            @click="closeModal"
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span
                                                class="cursor-pointer px-2 mr-2 bg-gray-500 text-white rounded"
                                                v-if="
                                                    item.button_access.includes(
                                                        'request_close'
                                                    )
                                                "
                                                @click="
                                                    modalHandler($event);
                                                    form.request_id = item.id;
                                                "
                                            >
                                                Close
                                            </span>
                                            <div
                                                class="fixed inset-0 z-50 hidden"
                                            >
                                                <div
                                                    class="relative w-full h-full flex justify-center items-center"
                                                >
                                                    <div
                                                        class="relative p-2 w-full mx-auto max-w-xs bg-white rounded border shadow z-50"
                                                    >
                                                        <div
                                                            class="text-sm text-center"
                                                        >
                                                            Close
                                                        </div>
                                                        <hr class="my-1" />
                                                        <div class="p-3">
                                                            <form
                                                                @submit.prevent="
                                                                    close
                                                                "
                                                            >
                                                                <input
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    placeholder="Note"
                                                                    v-model="
                                                                        form.note
                                                                    "
                                                                />
                                                                <Button
                                                                    type="submit"
                                                                    class="bg-gray-600 text-white px-2 py-1 rounded mt-2"
                                                                >
                                                                    Submit
                                                                </Button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40"
                                                    >
                                                        <div
                                                            class="w-full h-full"
                                                            @click="closeModal"
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="flex justify-between border-2 shadow rounded-md px-2 py-1 my-2 mr-2"
                                        v-for="response in item.responses"
                                        :key="response"
                                    >
                                        <div>
                                            <!-- {{ response }} -->
                                            <span class="font-extrabold">
                                                {{ `${response.outlet_name} ` }}
                                            </span>
                                            <span>
                                                {{
                                                    `${
                                                        response.status_name
                                                            .charAt(0)
                                                            .toLowerCase() +
                                                        response.status_name.slice(
                                                            1
                                                        )
                                                    } `
                                                }}
                                            </span>
                                            <span class="font-extrabold">
                                                {{ response.quantity }}
                                                pcs
                                            </span>
                                            responsed by
                                            <span class="font-extrabold">
                                                {{ response.user_name }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="absolute right-2 top-0 p-1 cursor-pointer text-red-500 text-3xl z-40"
                        @click="closeModal"
                    >
                        &times;
                    </div>
                </div>
                <div class="absolute inset-0 bg-gray-500 bg-opacity-50 z-40">
                    <div class="w-full h-full" @click="closeModal"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "product-request-item",
    props: "item",
};
</script>
