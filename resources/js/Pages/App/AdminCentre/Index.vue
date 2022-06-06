<template>
    <Head title="Admin Centre" />

    <h2 class="font-bold text-2xl mb-2">Welcome to the Admin Centre, {{ user.first_name }}</h2>
    <p class="mb-6">From here you can manage myQSA and assist users with any issues they may have.</p>

    <h4 class="w-full border-b border-gray-300 font-bold pb-1 mb-2">Manage myQSA</h4>
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <OptionCard :href="route('admin-centre.users.index')" icon="users">Users</OptionCard>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import {Head} from "@inertiajs/inertia-vue3";
import OptionCard from "@/Components/Interface/OptionCard";

export default defineComponent({
    components: {OptionCard, Head},
    props: {user: Object},
})
</script>
