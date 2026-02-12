<script setup lang="ts">
import { ref } from 'vue';
import { goUrlName } from '@/composables/useRedirect';
import ConfirmAction from '../confirm/ConfirmAction.vue';
import { storeToRefs } from 'pinia';
import { createError } from '@/composables/useCreateNotify';
import { useSellerStore } from '@/stores/seller-store';

defineOptions({
  name: 'RegistrationsTable',
});

const { loadingSeller, listRegistrations } = storeToRefs(useSellerStore());

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
    createError(error || 'Ocorreu um erro ao excluir a inscrição.');
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
          <TableHead>Data de registro</TableHead>
          <TableHead> Ação </TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow
          v-for="(registration, index) in listRegistrations"
          :key="index"
        >
          <TableCell>{{ registration.name }}</TableCell>
          <TableCell>{{ registration.email }}</TableCell>
          <TableCell>{{ registration.phone }}</TableCell>
          <TableCell>{{ registration.created_at }}</TableCell>
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
                  <!-- <DropdownMenuItem
                    class="cursor-pointer text-xs sm:text-sm"
                    @click="
                      goUrlName('seller.edit', {
                        id: seller.id,
                      })
                    "
                  >
                    <LucidePencil /> <span>Editar</span>
                  </DropdownMenuItem> -->
                  <DropdownMenuItem
                    class="cursor-pointer text-xs text-red-600 sm:text-sm"
                    @click="openDeleteModal(registration.id)"
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
    title="Excluir Inscrição"
    message="Esta ação é irreversível e excluirá esta inscrição."
    :loading="loadingSeller"
    variant="destructive"
    @confirm="handleExclude"
  />
</template>
