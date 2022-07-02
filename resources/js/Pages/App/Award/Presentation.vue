<template>
    <Head>
        <title>Presentation</title>
    </Head>
    <RequirementPage title="Presentation" accent="purple" :progress-percentage="progressPercentage"
                     :progress-message="progressMessage" :approval-needed="false" :history-needed="false"
                     :completion-message="completionMessage">
        <template #description>
            <p>
                You must:<br>
                Make a presentation covering all elements of your award to a suitable audience, with the aim of
                inspiring and motivating others to achieve the award. The presentation should be the final activity you
                complete.
            </p>
        </template>

        <p class="mb-4">
            To sign off this section, send the link below to the commissioner who saw your presentation. They can fill
            in the statement required to approve this section. If they are having trouble with the form, ask them to
            email <Link href="mailto:qsa@hampshirescouts.org.uk" class="text-purple">qsa@hampshirescouts.org.uk</Link> for assistance.
        </p>
        <div class="flex w-full items-end mb-6">
            <Input id="presentation-link" label="Presentation Link" v-model="presentation_link" disabled=""
                   class="w-full" input-class="select-none"/>
            <Button class="bg-purple hover:bg-purple-darkened disabled:bg-purple-darkened h-9 w-28"
                    type="submit" @click="copy">
                <span v-if="copied === false">Copy</span>
                <Feather class="ml-2" icon="copy" :size="16" v-if="copied === false"/>
                <span v-if="copied === true">Copied</span>
            </Button>
        </div>

        <p v-if="completed_by === null">Your presentation statement has not yet been completed by a commissioner.</p>
        <p v-else>Your presentation statement has been completed by {{ completed_by }}.</p>

    </RequirementPage>
</template>

<script>
import {defineComponent} from "vue";
import RequirementPage from "@/Components/Award/RequirementPage";
import {Head} from "@inertiajs/inertia-vue3";
import Input from "@/Components/Forms/Input";
import Button from "@/Components/Buttons/Button";
import Feather from "@/Components/Feather";
import Link from "@/Components/Interface/Link";

export default defineComponent({
    components: {Link, Button, Input, RequirementPage, Head, Feather},
    props: {
        id: Number,
        presentation_link: String,
        completed_by: null,
    },

    data() {
        return {
            copied: false,
        }
    },

    computed: {
        progressPercentage() {
            return this.completed_by === null ? 0 : 100;
        },
        progressMessage() {
            return 'Prepare your presentation, invite a commissioner, and give it to a suitable audience';
        },
        completionMessage() {
            return 'Give the commissioner this link so they can fill in the necessary details';
        }
    },

    methods: {
        copy() {
            let link = document.getElementById("presentation-link");
            link.select();
            link.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(link.value);

            this.copied = true;
            setTimeout(() => this.copied = false, 2500);
        }
    }
})
</script>
