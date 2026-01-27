<script setup lang="ts">
import { computed, watch } from 'vue';
import TitlePage from '../general/TitlePage.vue';
import { useSellerStore } from '@/stores/seller-store';
import { storeToRefs } from 'pinia';

defineOptions({
  name: 'SellerRegistration',
});

const props = defineProps<{
  open: boolean;
}>();
const emit = defineEmits<{
  'update:open': [void];
  'edit:seller-registration': [seller: ISellerRegistration];
}>();

const { loadingSeller, listRegistrations } = storeToRefs(useSellerStore());

const loadRegistrations = async () => {
  await useSellerStore().getSellersRegistration();
};
const startEdit = (seller: ISellerRegistration) => {
  emit('edit:seller-registration', seller);
};

const open = computed({
  get: () => props.open,
  set: () => emit('update:open'),
});

watch(
  () => props.open,
  async (newVal) => {
    if (newVal) {
      await loadRegistrations();
    }
  }
);
</script>

<template>
  <div class="flex flex-col gap-4">
    <TitlePage title="Registros de Vendedores" />

    <div
      v-if="loadingSeller"
      class="text-muted-foreground flex justify-center py-6"
    >
      Carregando registros...
    </div>

    <div
      v-else-if="listRegistrations.length === 0"
      class="text-muted-foreground flex justify-center py-6"
    >
      Nenhum registro encontrado.
    </div>

    <div v-else class="rounded-md border">
      <Table>
        <TableHeader>
          <TableRow>
            <TableHead>Nome</TableHead>
            <TableHead>Email</TableHead>
            <TableHead>Telefone</TableHead>
            <TableHead>Data</TableHead>
            <TableHead class="w-[120px]">Ações</TableHead>
          </TableRow>
        </TableHeader>

        <TableBody>
          <TableRow v-for="seller in listRegistrations" :key="seller.id">
            <TableCell class="font-medium">
              {{ seller.name }}
            </TableCell>

            <TableCell>
              {{ seller.email }}
            </TableCell>

            <TableCell>
              {{ seller.phone }}
            </TableCell>

            <TableCell>
              {{ new Date(seller.registration_date).toLocaleDateString() }}
            </TableCell>

            <TableCell>
              <Button variant="outline" size="sm" @click="startEdit(seller)">
                Editar
              </Button>
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
  </div>
</template>
