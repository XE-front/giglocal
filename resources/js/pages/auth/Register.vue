<script setup lang="ts">
import {ref, computed} from 'vue';
import { Form, Head } from "@inertiajs/vue3";
import InputError from "@/components/InputError.vue";
import PasswordInput from "@/components/PasswordInput.vue";
import TextLink from "@/components/TextLink.vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Spinner } from "@/components/ui/spinner";
import AuthBase from "@/layouts/AuthLayout.vue";
import { login } from "@/routes";
import { store } from "@/routes/register";

const password = ref('');
const hasMinLength = computed(() => password.value.length >= 9);
const hasUppercase = computed(() => /[A-Z]/.test(password.value));
const hasNumber = computed(() => /\d/.test(password.value));
const hasSpecial = computed(() => /[^A-Za-z0-9]/.test(password.value));
</script>

<template>
    <AuthBase
      title="Create an account"
      description="Enter your details below to create your account"
      class="border border-slate-200 dark:border-slate-700 rounded-lg p-8 bg-white dark:bg-slate-900 shadow-md"
    >
      <Head title="Register" />

      <Form
        v-bind="store.form()"
        :reset-on-success="['password', 'password_confirmation']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-6 "
      >
        <div class="grid gap-6">
          <div class="grid gap-2">
            <Label for="name">Name</Label>
            <Input
              id="name"
              type="text"
              required
              autofocus
              :tabindex="1"
              autocomplete="name"
              name="name"
              placeholder="Full name"
            />
            <InputError :message="errors.name" />
          </div>

          <div class="grid gap-2">
            <Label for="email">Email address</Label>
            <Input
              id="email"
              type="email"
              required
              :tabindex="2"
              autocomplete="email"
              name="email"
              placeholder="email@example.com"
            />
            <InputError :message="errors.email" />
          </div>

          <div class="grid gap-2">
            <Label for="password">Password</Label>
            <PasswordInput
              id="password"
              required
              :tabindex="3"
              autocomplete="new-password"
              name="password"
              placeholder="Password"
              v-model = "password"
            />
            <InputError :message="errors.password" />
            <ul class="text-xs mt-1 space-y-1">
                <li :class="hasMinLength ? 'text-green-600' : 'text-slate-500'">
                    <span v-if="hasMinLength">✔</span>
                    <span v-else>✖</span>
                    &nbsp;At least 9 characters
                </li>
                <li :class="hasUppercase ? 'text-green-600' : 'text-slate-500'">
                    <span v-if="hasUppercase">✔</span>
                    <span v-else>✖</span>
                    &nbsp;At least one uppercase letter
                </li>
                <li :class="hasNumber ? 'text-green-600' : 'text-slate-500'">
                    <span v-if="hasNumber">✔</span>
                    <span v-else>✖</span>
                    &nbsp;At least one number
                </li>
                <li :class="hasSpecial ? 'text-green-600' : 'text-slate-500'">
                    <span v-if="hasSpecial">✔</span>
                    <span v-else>✖</span>
                    &nbsp;At least one special character
                </li>
                </ul>
          </div>

          <div class="grid gap-2">
            <Label for="password_confirmation">Confirm password</Label>
            <PasswordInput
              id="password_confirmation"
              required
              :tabindex="4"
              autocomplete="new-password"
              name="password_confirmation"
              placeholder="Confirm password"
            />
            <InputError :message="errors.password_confirmation" />
          </div>

          <Button
            type="submit"
            class="mt-2 w-full"
            tabindex="5"
            :disabled="processing"
            data-test="register-user-button"
          >
            <Spinner v-if="processing" />
            Create account
          </Button>
        </div>

        <div class="text-center text-sm text-muted-foreground">
          Already have an account?
          <TextLink
            :href="login()"
            class="underline underline-offset-4"
            :tabindex="6"
            >Log in</TextLink>
        </div>
      </Form>
    </AuthBase>
</template>
