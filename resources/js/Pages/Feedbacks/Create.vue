<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import FormSection from "@/Components/FormSection.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";

const form = useForm({
    _method: 'POST',
    content: null,
    email: null,
});

const createFeedback = () => {
    form.post(route('feedbacks.store'), {
        errorBag: 'feedbackCreate',
        onSuccess: () => {
            form.reset();
        }
    });
}

</script>

<template>
    <AppLayout title="Feedbacks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add a feedback
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <FormSection @submitted="createFeedback">
                    <template #title>
                        Your feedback
                    </template>

                    <template #description>
                        Give us your feedback about Feedier.
                    </template>

                    <template #form>

                        <!-- Email -->
                        <div class="col-span-6 sm:col-span-4" v-if="!$page.props.auth.user">
                            <InputLabel for="email" value="Your email address" />
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.email" class="mt-2" />
                        </div>

                        <!-- Content -->
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="content" value="Your feedback in a few words" />
                            <TextInput
                                id="content"
                                v-model="form.content"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.content" class="mt-2" />
                        </div>
                    </template>

                    <template #actions>
                        <ActionMessage :on="form.recentlySuccessful" class="me-3">
                            Saved.
                        </ActionMessage>

                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </PrimaryButton>
                    </template>
                </FormSection>

            </div>
        </div>

    </AppLayout>

</template>
