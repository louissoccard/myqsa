<template>
    <Head>
        <title>Presentation Statement</title>
    </Head>

    <Page max-width="max-w-xl">
        <h1 class="font-bold text-xl mb-2 -mt-2">Presentation Statement</h1>
                <div v-if="completed" class="text-center">
                    <p>{{ possessive(name) }} presentation statement has already been completed. The statement can only be
                        filled in once. If you think this is an error or have any other questions, please email
                        <Link href="mailto:qsa@hampshirescouts.org.uk">qsa@hampshirescouts.org.uk</Link>.
                    </p>
                </div>
        <form @submit.prevent="submit" v-else-if="!success">
            <p class="mb-6 text-center">You are filling in {{ possessive(name) }} presentation statement for their
                Queen's
                Scout Award. If you have any questions,
                please email
                <Link href="mailto:qsa@hampshirescouts.org.uk">qsa@hampshirescouts.org.uk</Link>.
            </p>
            <Input id="name" label="Your Name" class="mb-4 w-full" v-model="form.name"/>
            <Input id="email" label="Your Email Address" type="email" class="mb-4 w-full" v-model="form.email">
                <template #tooltip-label>Why?</template>
                <template #tooltip>We need your email address so that we can verify the authenticity of this statement.
                    We
                    may contact you if we have any queries regarding this statement.
                </template>
            </Input>
            <Input id="date" label="Presentation Date" type="date" class="mb-4 w-full" v-model="form.date"/>
            <TextArea id="statement" label="Your Statement" container-class="w-full mb-2" rows="4"
                      v-model="form.statement">
            <template #tooltip-label>Help</template>
            <template #tooltip>
                Your statement should include a summary of the presentation. It doesn't need to be too long, just explain who {{ name }} gave their presentation to and what it was about.
            </template>
        </TextArea>
            <p class="text-sm mb-4 text-left">Please ensure that your statement is factual and does not contain any
                personal
                data that is not required.</p>
            <ValidationErrors class="mb-4"></ValidationErrors>
            <div class="text-right mt-2">
                <Button class="bg-navy hover:bg-navy-darkened disabled:bg-navy-darkened" type="submit">Submit</Button>
            </div>
        </form>
        <div v-else-if="success === true" class="text-center">
            <p class="text-center mb-8">
                Thank you for completing {{ possessive(name) }} presentation statement and helping them with their
                Queen's
                Scout Award. There is nothing else for you to do, but we will be in touch if we have any queries. If you
                have any questions,
                please contact us by emailing
                <Link href="mailto:qsa@hampshirescouts.org.uk">qsa@hampshirescouts.org.uk</Link>.
            </p>
            <p class="font-bold">You may now close this window</p>
        </div>
    </Page>
</template>

<script>
import {defineComponent} from "vue";
import {Head} from "@inertiajs/inertia-vue3";
import Page from "@/Components/Auth/Page";
import Link from "@/Components/Interface/Link";
import Input from "@/Components/Forms/Input";
import TextArea from "@/Components/Forms/TextArea";
import Button from "@/Components/Buttons/Button";
import ValidationErrors from "@/Components/Forms/ValidationErrors";

export default defineComponent({
    components: {ValidationErrors, Button, Link, Head, Page, Input, TextArea},
    props: {
        name: {
            type: String,
            required: true,
        },
        completed: {
            type: Boolean,
            required: true,
        }
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                date: '',
                statement: '',
            }),

            success: false,
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('presentation-statement.store', this.route().params.presentation_key), {
                onSuccess: () => this.success = true,
            });
        }
    }
})
</script>
