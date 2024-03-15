<script setup>
import FeedbackListItem from "@/Pages/Feedbacks/Partials/FeedbackListItem.vue";

defineProps(['feedbacks'])
</script>

<template>
    <template v-if="feedbacks.length === 0">
        <p>No feedbacks available at the moment.</p>
    </template>
    <template v-else>
        <div class="flex flex-col gap-2">
            <FeedbackListItem v-for="(feedback, idx) in feedbacks" class="w-full" :feedback="feedback" :idx="idx" />
        </div>
    </template>
</template>
