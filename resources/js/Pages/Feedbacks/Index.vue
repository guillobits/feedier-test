<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import FeedbackList from "@/Pages/Feedbacks/Partials/FeedbackList.vue";

defineProps(['feedbacks'])

</script>

<template>
    <AppLayout title="Feedbacks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Feedbacks
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                    <FeedbackList :feedbacks="feedbacks" />
                </div>
            </div>
        </div>

    </AppLayout>

</template>
