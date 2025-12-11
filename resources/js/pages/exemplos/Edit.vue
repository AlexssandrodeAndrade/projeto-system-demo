<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { edit as editRoute, index as indexRoute, update } from '@/routes/exemplos';
import type { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import FormExemplo from './Form.vue';

interface Exemplo {
    id: number;
    nome: string;
    descricao?: string | null;
    ativo: boolean;
}

const props = defineProps<{
    exemplo: Exemplo;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: dashboard().url },
    { title: 'Exemplos', href: indexRoute().url },
    { title: 'Editar', href: editRoute(props.exemplo.id).url },
];
</script>

<template>
    <Head title="Editar exemplo" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-6 p-4 md:p-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold">Editar exemplo</h1>
                    <p class="text-sm text-muted-foreground">
                        Atualize os dados do registro selecionado.
                    </p>
                </div>
                <Link
                    :href="indexRoute().url"
                    class="text-sm font-medium text-primary underline underline-offset-4"
                    >Voltar para a lista</Link
                >
            </div>

            <div class="rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border">
                <FormExemplo
                    :exemplo="exemplo"
                    :form-binding="update.form(exemplo.id)"
                    submit-label="Salvar alterações"
                />
            </div>
        </div>
    </AppLayout>
</template>
