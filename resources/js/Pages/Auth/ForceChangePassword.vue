<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <AuthenticationCard>
      <template #logo>
        <AuthenticationCardLogo />
      </template>

      <h1 class="text-xl font-bold text-center text-gray-800 mb-6">Cambiar contraseña</h1>
      <p class="text-sm text-gray-600 text-center mb-6">Debes cambiar tu contraseña para continuar.</p>

      <form @submit.prevent="submit">
        <div class="mt-4">
          <InputLabel for="password" value="Nueva contraseña" />
          <TextInput
            id="password"
            v-model="form.password"
            type="password"
            class="mt-1 block w-full"
            required
            autofocus
            autocomplete="new-password"
          />
          <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="mt-4">
          <InputLabel for="password_confirmation" value="Confirmar contraseña" />
          <TextInput
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            class="mt-1 block w-full"
            required
            autocomplete="new-password"
          />
          <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>

        <div class="flex items-center justify-end mt-4">
          <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            Guardar
          </PrimaryButton>
        </div>
      </form>
    </AuthenticationCard>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AuthenticationCard from '@/Components/AuthenticationCard.vue'
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'

const form = useForm({
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post(route('password.update'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>