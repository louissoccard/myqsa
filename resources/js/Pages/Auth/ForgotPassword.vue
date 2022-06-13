<template>
    <Head title="Sign In"/>

    <Page>
        <div class="w-full" v-if="!this.submitted">
            <p class="mb-8 text-center">If you have forgotten your password, enter your email address below to request a
                password reset.</p>
            <form @submit.prevent="submit" class="flex flex-col w-full">
                <Input id="email-address" class="mb-8 w-full" label="Email Address" type="email" v-model="form.email"
                       required autofocus/>
                <div class="ml-auto">
                    <Button class="inline bg-navy hover:bg-navy-darkened disabled:bg-navy-darkened"
                            :disabled="form.processing">Email Reset Link
                    </Button>
                </div>
            </form>
        </div>
        <div v-else class="text-center">
            <h4 class="font-bold text-lg mb-2">Password Reset Submitted</h4>
            <p>Please open the email we just sent you for details on how to reset your password.</p>
        </div>

        <p class="w-full text-center border-t mt-4 pt-4 border-gray-400 dark:border-gray-700">Remembered your password?
            <Link :href="route('login')" class="font-bold hover:text-blue">Sign In</Link>
        </p>
    </Page>
</template>

<script>
import {defineComponent} from 'vue'
import {Head, Link} from '@inertiajs/inertia-vue3';
import Logo from "@/Components/Logo";
import Input from "@/Components/Forms/Input";
import Button from "@/Components/Buttons/Button";
import Page from "@/Components/Auth/Page";


export default defineComponent({
    components: {
        Page,
        Head,
        Link,
        Logo,
        Input,
        Button
    },

    props: {
        status: String
    },

    data() {
        return {
            form: this.$inertia.form({
                email: ''
            }),
            submitted: false,
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.email'), {
                onFinish: () => this.submitted = true,
            })
        }
    }
})
</script>
