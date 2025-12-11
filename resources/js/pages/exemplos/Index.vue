<template>
    <Head title="Exemplos" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-6 p-4 md:p-6">
            <div
                class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between"
            >
                <div>
                    <h1 class="text-2xl leading-tight font-semibold">
                        Exemplos
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        CRUD de referência para novos módulos do sistema.
                    </p>
                </div>
                <Button as-child>
                    <Link :href="createRoute().url">Novo exemplo</Link>
                </Button>
            </div>

            <div
                class="grid gap-4 rounded-xl border border-sidebar-border/70 bg-card p-4 shadow-sm dark:border-sidebar-border"
            >
                <div
                    class="grid gap-3 md:grid-cols-[2fr,1fr,auto] md:items-end"
                >
                    <div class="space-y-2">
                        <label
                            for="search"
                            class="text-sm font-medium text-foreground"
                            >Buscar</label
                        >
                        <Input
                            id="search"
                            name="search"
                            type="search"
                            v-model="filters.search"
                            placeholder="Filtrar por nome"
                            @keyup.enter="applyFilters"
                        />
                    </div>

                    <div class="space-y-2">
                        <label
                            for="ativo"
                            class="text-sm font-medium text-foreground"
                            >Status</label
                        >
                        <select
                            id="ativo"
                            name="ativo"
                            v-model="filters.ativo"
                            class="h-9 w-full rounded-md border border-input bg-background px-3 text-sm text-foreground shadow-xs transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                        >
                            <option value="">Todos</option>
                            <option value="1">Ativos</option>
                            <option value="0">Inativos</option>
                        </select>
                    </div>

                    <div class="flex gap-2 self-end">
                        <Button
                            variant="outline"
                            class="w-full md:w-auto"
                            @click="resetFilters"
                            >Limpar</Button
                        >
                        <Button class="w-full md:w-auto" @click="applyFilters"
                            >Filtrar</Button
                        >
                    </div>
                </div>

                <div
                    class="overflow-hidden rounded-lg border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <table class="w-full text-sm">
                        <thead
                            class="bg-muted/50 text-xs tracking-wide text-muted-foreground uppercase"
                        >
                            <tr>
                                <th class="px-4 py-3 text-left">Nome</th>
                                <th class="px-4 py-3 text-left">Descrição</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody
                            v-if="exemplos.data.length"
                            class="divide-y divide-border"
                        >
                            <tr
                                v-for="exemplo in exemplos.data"
                                :key="exemplo.id"
                                class="hover:bg-muted/40"
                            >
                                <td
                                    class="px-4 py-3 font-medium text-foreground"
                                >
                                    {{ exemplo.nome }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ exemplo.descricao || '—' }}
                                </td>
                                <td class="px-4 py-3">
                                    <Badge
                                        :variant="
                                            exemplo.ativo
                                                ? 'default'
                                                : 'secondary'
                                        "
                                    >
                                        {{
                                            exemplo.ativo ? 'Ativo' : 'Inativo'
                                        }}
                                    </Badge>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2"
                                    >
                                        <Button
                                            as-child
                                            variant="secondary"
                                            size="sm"
                                        >
                                            <Link
                                                :href="
                                                    editRoute(exemplo.id).url
                                                "
                                                >Editar</Link
                                            >
                                        </Button>

                                        <Dialog>
                                            <DialogTrigger as-child>
                                                <Button
                                                    variant="destructive"
                                                    size="sm"
                                                    >Excluir</Button
                                                >
                                            </DialogTrigger>
                                            <DialogContent>
                                                <DialogHeader class="space-y-2">
                                                    <DialogTitle
                                                        >Confirmar
                                                        exclusão</DialogTitle
                                                    >
                                                    <DialogDescription>
                                                        Essa ação removerá o
                                                        registro
                                                        <strong>{{
                                                            exemplo.nome
                                                        }}</strong
                                                        >. Deseja continuar?
                                                    </DialogDescription>
                                                </DialogHeader>
                                                <DialogFooter class="gap-2">
                                                    <DialogClose as-child>
                                                        <Button
                                                            variant="secondary"
                                                            >Cancelar</Button
                                                        >
                                                    </DialogClose>
                                                    <Form
                                                        v-bind="
                                                            destroyRoute.form(
                                                                exemplo.id,
                                                            )
                                                        "
                                                        class="inline-flex"
                                                        v-slot="{ processing }"
                                                    >
                                                        <Button
                                                            type="submit"
                                                            variant="destructive"
                                                            :disabled="
                                                                processing
                                                            "
                                                        >
                                                            Excluir
                                                        </Button>
                                                    </Form>
                                                </DialogFooter>
                                            </DialogContent>
                                        </Dialog>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td
                                    colspan="4"
                                    class="px-4 py-6 text-center text-muted-foreground"
                                >
                                    Nenhum registro encontrado com os filtros
                                    atuais.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div
                    class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between"
                >
                    <p class="text-sm text-muted-foreground">
                        {{ exemplos.from ?? 0 }}–{{ exemplos.to ?? 0 }} de
                        {{ exemplos.total }} registros
                    </p>
                    <div class="flex flex-wrap items-center gap-2">
                        <Link
                            v-for="link in exemplos.links"
                            :key="link.label"
                            :href="link.url || '#'"
                            :class="[
                                'rounded-md border border-transparent px-3 py-1 text-sm transition-colors',
                                link.active
                                    ? 'bg-primary text-primary-foreground'
                                    : 'hover:border-muted-foreground/40 hover:bg-muted/60',
                                !link.url
                                    ? 'pointer-events-none opacity-50'
                                    : '',
                            ]"
                            v-html="link.label"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import {
    create as createRoute,
    destroy as destroyRoute,
    edit as editRoute,
    index as indexRoute,
} from '@/routes/exemplos';
import type { BreadcrumbItem } from '@/types';
import { Form, Head, Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Exemplo {
    id: number;
    nome: string;
    descricao?: string | null;
    ativo: boolean;
    created_at: string;
}

const props = defineProps<{
    exemplos: {
        data: Exemplo[];
        from: number | null;
        to: number | null;
        total: number;
        links: PaginationLink[];
    };
    filters: {
        search?: string | null;
        ativo?: string | null;
    };
}>();

const filters = reactive({
    search: props.filters.search ?? '',
    ativo: props.filters.ativo ?? '',
});

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: dashboard().url },
    { title: 'Exemplos', href: indexRoute().url },
];

const applyFilters = () => {
    router.get(indexRoute().url, filters, {
        preserveScroll: true,
        preserveState: true,
        replace: true,
    });
};

const resetFilters = () => {
    filters.search = '';
    filters.ativo = '';
    applyFilters();
};
</script>
