<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { router } from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";

defineProps(['feedback', 'idx'])

const deleteFeedback = (id) => {
    router.delete(route('feedbacks.delete', { id: id }));
}

const restoreFeedback = (id) => {
    router.put(route('feedbacks.restore', { id: id }));
}
</script>

<template>
    <div class="flex items-center gap-8 border border-gray-800 rounded-lg px-4 py-2">
        <div>{{ idx }}</div>
        <div class="flex-auto">
            <p class="whitespace-pre-wrap">
                {{ feedback.content }}
            </p>
            <p v-if="feedback.email" class="mt-1 text-xs italic text-indigo-400 font-bold">
                {{ feedback.email }}
            </p>
        </div>
        <div>
            <SecondaryButton @click="restoreFeedback(feedback.id)" v-if="feedback.deleted_at">
                Restore
            </SecondaryButton>
            <DangerButton @click="deleteFeedback(feedback.id)" v-else>
                Delete
            </DangerButton>
        </div>
    </div>
</template>
