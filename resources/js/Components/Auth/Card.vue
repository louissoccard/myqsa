<template>
    <div
        class="min-h-screen flex flex-col justify-center items-center"
    >

        <div
            class="flex flex-col items-center w-full max-w-md m-4 sm:m-8 p-8 bg-white shadow-md overflow-hidden"
        >
            <div>
                <Logo width="w-32" class="mb-8" />
            </div>
            <slot />
        </div>
    </div>
</template>

<script>
    import Logo from '@/Components/Logo.vue';

    export default {
        components: {
            Logo,
        }
    }
</script>
