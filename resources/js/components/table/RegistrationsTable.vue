<script setup lang="ts">
import { ref, watch } from 'vue';
import ConfirmAction from '../confirm/ConfirmAction.vue';
import { storeToRefs } from 'pinia';
import { useSellerStore } from '@/stores/seller-store';
import { formatDateBrazil } from '@/composables/useFormat';
import { LucideUserCheck } from 'lucide-vue-next';
import FormApproveRegistration from '../form/seller/FormApproveRegistration.vue';

defineOptions({
  name: 'RegistrationsTable',
});

const { loadingSeller, listRegistrations } = storeToRefs(useSellerStore());

const isConfirmOpen = ref<boolean>(false);
const showFormApproveRegistration = ref<boolean>(false);
const selectedId = ref<number | null>(null);
const selectedRegistration = ref<ISellerRegistration | null>(null);

const openDeleteModal = (id: number) => {
  selectedId.value = id;
  isConfirmOpen.value = true;
};
const handleExclude = async () => {
  const response = await useSellerStore().deleteRegistration(
    Number(selectedId.value)
  );

  if (response?.status === 200) {
    clear();
  }
};
const approveSellerRegistration = async (registration: ISellerRegistration) => {
  selectedRegistration.value = registration;
  showFormApproveRegistration.value = true;
};
const clear = () => {
  selectedId.value = null;
  isConfirmOpen.value = false;
  selectedRegistration.value = null;
};

watch(
  () => showFormApproveRegistration,
  (show) => {
    if (!show) {
      clear();
    }
  }
);
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
          <TableCell>{{ formatDateBrazil(registration.created_at) }}</TableCell>
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
                    class="cursor-pointer text-xs text-green-600 sm:text-sm"
                    @click="approveSellerRegistration(registration)"
                  >
                    <LucideUserCheck class="text-green-600" />
                    <span>Aprovar</span>
                  </DropdownMenuItem>
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
  <FormApproveRegistration
    v-model:open="showFormApproveRegistration"
    :registration="selectedRegistration"
  />
</template>
