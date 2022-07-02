<template>
    <h2 class="font-bold text-2xl mb-4">{{ title }}</h2>
    <div class="text-lg lg:hidden mb-6">
        <slot name="description"></slot>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="flex flex-col gap-6 lg:col-span-2 lg:row-span-2 order-2 lg:order-1">
            <div class="text-lg hidden lg:block">
                <slot name="description"></slot>
            </div>
            <div class="flex-1">
                <slot></slot>
            </div>
            <Card title="Approval" class="flex-grow-0" v-if="approvalNeeded"
                  :description="'Once you have complete the ' + (altTitle === null ? title.toLowerCase() : altTitle) + ' requirement, you can submit it to be approved. You may also add additional comments.'">
                <template #header-content>
                    <p>Status: Draft</p>
                </template>
                <form class="text-right">
                    <TextArea id="approval-message" label="Comments" rows="4" class="mb-3" bg="bg-white dark:bg-gray-800"
                              placeholder="Enter your comments here..."></TextArea>
                    <Button :class="buttonColourClasses">Submit</Button>
                </form>
            </Card>
        </div>

        <Card title="Progress" class="text-center order-1 lg:order-2">
            <div class="flex flex-1 flex-col justify-center items-center pt-4">
                <CircularProgressBar :id="progressBarId" :colour="progressBarColour" :percentage="progressPercentage"
                                     container-class="mb-6"></CircularProgressBar>
                <div class="px-1">
                    <p class="mb-2" v-if="progressMessage && progressPercentage < 100">{{ progressMessage }}</p>
                    <p class="font-bold" v-if="progressPercentage < 100">{{ completionMessage }}</p>
                    <p class="font-bold" v-else>Congratulations! You have completed the
                        {{ altTitle === null ? title.toLowerCase() : altTitle }} requirement</p>
                </div>
            </div>
        </Card>

        <Card title="History" class="min-h-72 order-3" description="Click on a notification to view more information." v-if="historyNeeded">
        </Card>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import Card from "@/Components/Interface/Card";
import CircularProgressBar from "@/Components/Interface/CircularProgressBar";
import TextArea from "@/Components/Forms/TextArea";
import Button from "@/Components/Buttons/Button";

export default defineComponent({
    components: {Button, TextArea, CircularProgressBar, Card},
    props: {
        title: {
            type: String,
            required: true,
        },
        altTitle: {
            type: String,
            required: false,
            default: null,
        },
        accent: {
          type: String,
          required: true,
        },
        progressPercentage: {
          type: Number,
          required: true,
        },
        progressMessage: {
            type: String,
            required: false,
        },
        completionMessage: {
            type: String,
            required: true,
        },
        approvalNeeded: {
            type: Boolean,
            required: false,
            default: true,
        },
        historyNeeded: {
            type: Boolean,
            required: false,
            default: true,
        }
    },
    computed: {
        progressBarId() {
            if (this.altTitle === null) {
                return this.title.toLowerCase().replaceAll(' ', '-') + '-page-progress';
            } else {
                return this.altTitle.toLowerCase().replaceAll(' ', '-') + '-page-progress';
            }
        },
        progressBarColour() {
            if (this.accent === 'navy') return '#003982';
            else if (this.accent === 'teal') return '#00a794';
            else if (this.accent === 'pink') return '#ffb4e5';
            else if (this.accent === 'yellow') return '#ffe627';
            else if (this.accent === 'purple') return '#7413dc';
        },
        buttonColourClasses() {
            if (this.accent === 'navy') return 'bg-navy hover:bg-navy-darkened';
            else if (this.accent === 'teal') return 'bg-teal hover:bg-teal-darkened';
            else if (this.accent === 'pink') return 'bg-pink hover:bg-pink-darkened text-grey-80';
            else if (this.accent === 'yellow') return 'bg-yellow hover:bg-yellow-darkened text-grey-80';
            else if (this.accent === 'purple') return 'bg-purple hover:bg-purple-darkened';
        }
    }
})
</script>
