<template>
    <Head><title>Generate Reports</title></Head>

    <div class="flex flex-col lg:flex-row justify-between relative">
        <div class="w-full mb-8 lg:mb-0 lg:pr-4 lg:fixed lg:w-1/3">
            <h2 class="font-bold text-2xl mb-4">Generate Reports</h2>
            <p>On this page, you can generate award reports in a PDF format based on the stage you are at with your
                report.</p>

            <p class="mt-2 font-bold" v-if="award_complete">Congratulations! You have completed all the necessary parts
                of your QSA. Once you
                have filled in the
                additional information below, you can download your Completion Report that can then be sent off to Scout
                Headquarters for validation.</p>
            <p class="mt-2 font-bold" v-else>You're still working towards your Queen's Scout Award, so we've compiled a
                report of everything you've done so far. Simply click the button below to download it.</p>

            <form class="mt-4 space-y-3" v-if="award_complete">
                <TextArea id="address" label="Address" rows="4" v-model="address" @input="update_report_address"/>
                <Input id="postcode" label="Postcode" v-model="postcode" @input="update_report_postcode"/>
                <Select id="permanent-address" label="Is this your permanent address?" v-model="permanent_address"
                        @change="update_report_permanent_address">
                    <option value="">Select...</option>
                    <option value="true">Yes</option>
                    <option value="false">No</option>
                </Select>
                <Input id="phone-number" label="Phone Number" v-model="phone_number"
                       @input="update_report_phone_number"/>
            </form>

            <Button class="mt-8 bg-navy hover:bg-navy-darkened disabled:bg-navy-darkened"
                    :href="route('award.reports.generate', {address: this.address, postcode: this.postcode, permanent_address: this.permanent_address === 'true' ? 'Yes' : 'No', phone_number: this.phone_number_formatted})"
                    :normal_link="true" target="_blank">Download Report (PDF)
            </Button>
        </div>
        <div class="w-full lg:w-1/2 lg:pl-4 ml-auto">
            <p class="hidden dark:block p-4 font-bold text-center">To help your eyes, we've darkened the report preview.<br/>Click
                on the report to disable this.</p>
            <div class="bg-gray-200 dark:bg-gray-800">
                <div ref="record-sheet-container" id="record-sheet-container"
                     class="relative"
                     style="resize: both;">
                    <div ref="record-sheet" id="record-sheet" @click="this.report_active = !this.report_active"
                         class="select-none cursor-default dark:cursor-pointer" :class="{'active': this.report_active}"
                         style="width: 56rem; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); transform-origin: center center;">
                        <div class="p-8">
                            <div v-html="html">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<style>
.page {
    padding: 5rem 4rem;
    background-color: white;
    filter: drop-shadow(0 10px 8px rgb(0 0 0 / 0.04)) drop-shadow(0 4px 3px rgb(0 0 0 / 0.1));
    min-height: 73.5rem;
    font-size: 17px;
    color: #333333;
    overflow: visible;
}

@media (prefers-color-scheme: dark) {
    .page {
        opacity: 50%;
    }

    #record-sheet.active .page {
        opacity: 100%;
    }
}

.page .text-sm {
    font-size: 16px;
}

.page table {
    font-size: 17px;
}

.page + .page {
    margin-top: 2rem;
}

</style>

<script>
import {defineComponent} from "vue";
import {Head} from "@inertiajs/inertia-vue3";
import Button from "@/Components/Buttons/Button";
import Input from "@/Components/Forms/Input";
import TextArea from "@/Components/Forms/TextArea";
import Select from "@/Components/Forms/Select";

export default defineComponent({
    props: {
        html: null,
        award_complete: {
            type: Boolean,
            required: true,
        }
    },
    components: {Head, Select, TextArea, Input, Button},
    mounted() {
        this.resize();
        window.addEventListener('resize', this.resize);
    },

    data() {
        return {
            address: '',
            postcode: '',
            permanent_address: '',
            phone_number: '',

            report_active: false,
        }
    },

    computed: {
        phone_number_formatted() {
            let phone_number = this.phone_number;

            if (!phone_number.includes(' ')) {
                if (phone_number.at(0) === '0') {
                    phone_number = phone_number.substring(0, 5) + ' ' + phone_number.substring(5, 8) + ' ' + phone_number.substring(8);
                } else if (phone_number.substring(0, 3) === '+44') {
                    phone_number = '(+44) ' + phone_number.substring(3, 7) + ' ' + phone_number.substring(7, 10) + ' ' + phone_number.substring(10);
                }
            }

            return phone_number;
        }
    },

    methods: {
        resize() {
            let scale = this.$refs['record-sheet-container'].offsetWidth / this.$refs["record-sheet"].offsetWidth;

            let transform_string = "translate(-50%, -50%) " + "scale(" + scale + ")";
            let container_height = (this.$refs["record-sheet"].offsetHeight * scale) + "px";

            this.$refs["record-sheet"].style.transform = transform_string;
            this.$refs["record-sheet-container"].style.height = container_height;
        },

        update_report_address() {
            document.getElementById('report-address').innerText = this.address;
            this.resize();
        },

        update_report_postcode() {
            this.postcode = this.postcode.toUpperCase();
            document.getElementById('report-postcode').innerText = this.postcode;
            this.resize();
        },

        update_report_permanent_address() {
            document.getElementById('report-permanent-address').innerText = this.permanent_address === 'true' ? 'Yes' : 'No';
            this.resize();
        },

        update_report_phone_number() {
            document.getElementById('report-phone-number').innerText = this.phone_number_formatted;
            this.resize();
        },
    }
})
</script>
