<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import ConfirmAction from '../confirm/ConfirmAction.vue';

defineOptions({
  name: 'SellersTable',
});

const props = defineProps<{
  sellers: ISeller[];
}>();

const emit = defineEmits<{
  'edit:seller': [ISeller];
}>();

const showConfirmAction = ref<boolean>(false);
const monitoringSellerId = ref<number | null>(null);

const openConfirmAction = (id: number) => {
  ((showConfirmAction.value = true), (monitoringSellerId.value = id));
};
const closeConfirmAction = () => {
  ((showConfirmAction.value = false), clear());
};
const okConfirmAction = async () => {
  await exclude(monitoringSellerId.value ?? 0);
  clear();
};
const clear = () => {
  monitoringSellerId.value = null;
};
const exclude = (id: number) => {
  if (id !== null) {
    ((showConfirmAction.value = false),
      router.delete(route('seller.delete', id)));
  }
};
</script>

<template>
  <Table>
    <TableHeader>
      <TableRow>
        <TableHead> Nome </TableHead>
        <TableHead>Email</TableHead>
        <TableHead>Telefone</TableHead>
        <TableHead>Código</TableHead>
        <TableHead>Ações</TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-for="(seller, index) in props.sellers" :key="index">
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
                  @click="emit('edit:seller', seller)"
                >
                  <Pencil /> <span>Editar</span>
                </DropdownMenuItem>
                <DropdownMenuItem
                  class="cursor-pointer text-xs text-red-600 sm:text-sm"
                  @click="openConfirmAction(seller.id)"
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
  <!-- Modals -->
  <ConfirmAction
    :open="showConfirmAction"
    title="Exclusão de vendedor"
    message="Caso tenha certeza, clique em 'Confirmar', pois essa ação é irreversível e excluirá o vendedor permanentemente."
    @update:open="closeConfirmAction()"
    @okConfirmAction="okConfirmAction()"
  />
</template>
