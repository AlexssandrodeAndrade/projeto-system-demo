<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form } from '@inertiajs/vue3';

interface Exemplo {
    id?: number;
    nome: string;
    descricao?: string | null;
    ativo: boolean;
}

interface Props {
    formBinding: Record<string, unknown>;
    exemplo?: Exemplo;
    submitLabel: string;
}

withDefaults(defineProps<Props>(), {
    exemplo: () => ({
        nome: '',
        descricao: '',
        ativo: true,
    }),
});
</script>

<template>
    <Form v-bind="formBinding" class="space-y-6" v-slot="{ errors, processing }">
        <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-2">
                <Label for="nome">Nome</Label>
                <Input
                    id="nome"
                    name="nome"
                    type="text"
                    :default-value="exemplo?.nome"
                    required
                    autofocus
                    placeholder="Informe o nome"
                />
                <InputError :message="errors.nome" />
            </div>

            <div class="space-y-2">
                <Label for="ativo">Ativo</Label>
                <div
                    class="flex items-center gap-3 rounded-lg border border-sidebar-border/70 px-3 py-2 dark:border-sidebar-border"
                >
                    <input type="hidden" name="ativo" value="0" />
                    <input
                        id="ativo"
                        type="checkbox"
                        name="ativo"
                        value="1"
                        :checked="exemplo?.ativo ?? true"
                        class="h-4 w-4 rounded border-muted-foreground/50"
                    />
                    <Label for="ativo" class="mb-0 cursor-pointer text-sm"
                        >Marque para manter o registro ativo</Label
                    >
                </div>
                <InputError :message="errors.ativo" />
            </div>
        </div>

        <div class="space-y-2">
            <Label for="descricao">Descrição</Label>
            <textarea
                id="descricao"
                name="descricao"
                rows="4"
                :value="exemplo?.descricao ?? ''"
                placeholder="Escreva uma descrição breve (opcional)"
                class="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm text-foreground shadow-xs outline-none transition-[color,box-shadow] focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
            ></textarea>
            <InputError :message="errors.descricao" />
        </div>

        <div class="flex justify-end gap-3">
            <Button type="submit" :disabled="processing">{{ submitLabel }}</Button>
        </div>
    </Form>
</template>
