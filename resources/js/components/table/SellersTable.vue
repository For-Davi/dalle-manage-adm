<script setup lang="ts">
import { ref } from 'vue';
import { goUrlName } from '@/composables/useRedirect';
import ConfirmAction from '../confirm/ConfirmAction.vue';
import { storeToRefs } from 'pinia';
import { createError } from '@/composables/useCreateNotify';
import { useSellerStore } from '@/stores/seller-store';
import { formatDateBrazil } from '@/composables/useFormat';
import { LucideDollarSign } from 'lucide-vue-next';
import { toast } from 'vue-sonner';

defineOptions({
  name: 'SellersTable',
});

const { loadingSeller, listSellers } = storeToRefs(useSellerStore());

const isConfirmOpen = ref(false);
const selectedId = ref<number | null>(null);

const openDeleteModal = (id: number) => {
  selectedId.value = id;
  isConfirmOpen.value = true;
};
const handleExclude = async () => {
  try {
    const response = await useSellerStore().deleteSeller(
      Number(selectedId.value)
    );

    if (response?.status === 200) {
      selectedId.value = null;
      isConfirmOpen.value = false;
    }
  } catch (error) {
    createError(error || 'Ocorreu um erro ao excluir o vendedor.');
  }
};
const copyToClipboard = async (text: string) => {
  try {
    await navigator.clipboard.writeText(text);
    toast.success(`O código ${text} foi copiado para a área de transferência.`);
  } catch (err) {
    toast.success(`Erro ao copiar código`);
  }
};
</script>

<template>
  <main>
    <div
      v-if="!loadingSeller"
      class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3"
    >
      <Card v-for="(seller, index) in listSellers" :key="index">
        <CardHeader class="flex-column flex items-center justify-between pb-2">
          <div class="flex flex-col gap-1">
            <CardTitle class="text-base leading-none font-semibold">
              {{ seller.name }}
            </CardTitle>
            <p class="text-muted-foreground text-[11px]">
              Criado em: {{ formatDateBrazil(seller.created_at, 0) }}
            </p>
          </div>
          <DropdownMenu>
            <DropdownMenuTrigger as-child>
              <Button variant="ghost" size="icon" class="cursor-pointer">
                <LucideEllipsis class="size-4" />
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent class="w-48 sm:w-56">
              <DropdownMenuLabel class="text-xs sm:text-sm"
                >Opções</DropdownMenuLabel
              >
              <DropdownMenuSeparator />
              <DropdownMenuGroup>
                <DropdownMenuItem
                  class="cursor-pointer text-xs sm:text-sm"
                  @click="goUrlName('seller.edit', { id: seller.id })"
                >
                  <LucidePencil /> <span>Editar</span>
                </DropdownMenuItem>
                <DropdownMenuItem
                  class="cursor-pointer text-xs text-red-600 sm:text-sm"
                  @click="openDeleteModal(seller.id)"
                >
                  <LucideTrash class="text-red-600" /> <span>Excluir</span>
                </DropdownMenuItem>
              </DropdownMenuGroup>
            </DropdownMenuContent>
          </DropdownMenu>
        </CardHeader>

        <CardContent class="space-y-3 text-sm">
          <div class="flex items-center justify-between">
            <span class="text-muted-foreground flex items-center gap-2">
              <LucideMail class="size-4 shrink-0" />
              <span class="font-medium">E-mail</span>
            </span>
            <span class="max-w-[60%] truncate">{{ seller.email }}</span>
          </div>

          <Separator />

          <div class="flex items-center justify-between">
            <span class="text-muted-foreground flex items-center gap-2">
              <LucidePhone class="size-4 shrink-0" />
              <span class="font-medium">Telefone</span>
            </span>
            <span class="">{{ seller.phone }}</span>
          </div>

          <Separator />

          <div class="flex items-center justify-between">
            <span class="text-muted-foreground flex items-center gap-2">
              <LucideDollarSign class="size-4 shrink-0" />
              <span class="font-medium">Comissão</span>
            </span>
            <span>{{ seller.commission }} %</span>
          </div>

          <Separator />

          <div
            class="hover:bg-muted/50 group flex cursor-pointer items-center justify-between rounded p-1 transition-colors"
            @click="copyToClipboard(seller.code)"
            title="Clique para copiar"
          >
            <span class="text-muted-foreground flex items-center gap-2">
              <LucideHash class="size-4 shrink-0" />
              <span class="text-xs font-medium uppercase">Código</span>
            </span>

            <span
              class="text-primary flex items-center gap-2 font-mono font-bold"
            >
              {{ seller.code }}
              <LucideCopy
                class="size-3 opacity-0 transition-opacity group-hover:opacity-100"
              />
            </span>
          </div>
        </CardContent>
      </Card>
    </div>

    <div class="p-6" v-else>
      <Spinner class="size-8" />
    </div>
  </main>

  <!-- Modals -->
  <ConfirmAction
    v-model:open="isConfirmOpen"
    title="Excluir Vendedor"
    message="Esta ação é irreversível e excluirá este vendedor."
    :loading="loadingSeller"
    variant="destructive"
    @confirm="handleExclude"
  />
</template>
