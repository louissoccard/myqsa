<template>
    <Head title="Email Verification"/>

    <Page>
        <h2 class="text-lg font-bold mb-2">
            Thank you for signing up!
        </h2>
        <p class="text-center mb-4">
            To access your account you must verify your email. If you don't receive it within a few minutes, you can
            resend it using the link below.
        </p>

        <Message class="mb-4 p-4" icon="check-circle" v-if="verificationLinkSent">
            A new verification link has been sent to the email address you provided during registration.
        </Message>

        <form @submit.prevent="submit" class="mt-4 w-full flex flex-col items-center">
            <Button class="bg-navy hover:bg-navy-darkened disabled:bg-navy-darkened"
                    :disabled="form.processing">Resend Verification Email
            </Button>

            <Link :href="route('sign-out')" method="post" as="button"
                  class="hover:text-gray-700 dark:hover:text-gray-400 cursor-pointer text-sm mt-3">Sign Out
            </Link>
        </form>
    </Page>
</template>

<script>
import {defineComponent} from 'vue'
import {Head, Link} from '@inertiajs/inertia-vue3';
import Button from "@/Components/Buttons/Button";
import Logo from "@/Components/Logo";
import Message from "@/Components/Interface/Message";
import Page from "@/Components/Auth/Page";

export default defineComponent({
    components: {
        Page,
        Message,
        Button,
        Logo,
        Head,
        Link,
    },

    props: {
        status: String
    },

    data() {
        return {
            form: this.$inertia.form()
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('verification.send'))
        },
    },

    computed: {
        verificationLinkSent() {
            return this.status === 'verification-link-sent';
        }
    }
})
</script>
