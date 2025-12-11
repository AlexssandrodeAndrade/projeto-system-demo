<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { index as indexRoute, store } from '@/routes/exemplos';
import type { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import FormExemplo from './Form.vue';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: dashboard().url },
    { title: 'Exemplos', href: indexRoute().url },
    { title: 'Novo', href: store().url },
];
</script>

<template>
    <Head title="Novo exemplo" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-6 p-4 md:p-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold">Novo exemplo</h1>
                    <p class="text-sm text-muted-foreground">
                        Cadastre um novo registro para usar como modelo de CRUD.
                    </p>
                </div>
                <Link
                    :href="indexRoute().url"
                    class="text-sm font-medium text-primary underline underline-offset-4"
                    >Voltar para a lista</Link
                >
            </div>

            <div class="rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border">
                <FormExemplo :form-binding="store.form()" submit-label="Criar exemplo" />
            </div>
        </div>
    </AppLayout>
</template>
