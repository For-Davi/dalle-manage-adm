<script setup lang="ts">
import { ref } from 'vue';
import { goUrlName } from '@/composables/useRedirect';
import ConfirmAction from '../confirm/ConfirmAction.vue';
import { storeToRefs } from 'pinia';
import { createError } from '@/composables/useCreateNotify';
import { useSellerStore } from '@/stores/seller-store';
import { formatDateBrazil } from '@/composables/useFormat';

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
</script>

<template>
  <main>
    <Table v-if="!loadingSeller">
      <TableHeader>
        <TableRow>
          <TableHead> Nome </TableHead>
          <TableHead>Email</TableHead>
          <TableHead>Telefone</TableHead>
          <TableHead>Código</TableHead>
          <TableHead> Ação </TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow v-for="(seller, index) in listSellers" :key="index">
          <TableCell>{{ seller.name }}</TableCell>
          <TableCell>{{ seller.email }}</TableCell>
          <TableCell>{{ seller.phone }}</TableCell>
          <TableCell>{{ seller.code }}</TableCell>
          <TableCell>
            <DropdownMenu>
              <DropdownMenuTrigger as-child>
                <Button variant="ghost" class="cursor-pointer">
                  <LucideEllipsis />
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
                    @click="
                      goUrlName('seller.edit', {
                        id: seller.id,
                      })
                    "
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
          </TableCell>
        </TableRow>
      </TableBody>
    </Table>
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
