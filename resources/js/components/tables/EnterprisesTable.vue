<script setup lang="ts">
import { CircleCheckBig, CircleX } from 'lucide-vue-next';
import { isActive } from '@/composables/Active';
import { getNameSubscription } from '@/composables/Subscription';
import { Ellipsis, Pencil, Trash } from 'lucide-vue-next';
import ConfirmAction from '../confirm/ConfirmAction.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

defineOptions({
  name: 'EnterprisesTable',
});

const emit = defineEmits<{
  'edit:enterprise': [enterprise: IEnterprise];
}>();
const props = defineProps<{
  enterprises: IEnterprise[];
}>();

const showConfirmAction = ref<boolean>(false);
const monirotingEnterpriseId = ref<number | null>(null);

const openConfirmAction = (id: number) => {
  ((showConfirmAction.value = true), (monirotingEnterpriseId.value = id));
};
const closeConfirmAction = () => {
  ((showConfirmAction.value = false), clear());
};
const okConfirmAction = async () => {
  await exclude(monirotingEnterpriseId.value ?? 0);
  clear();
};
const clear = () => {
  monirotingEnterpriseId.value = null;
};
const exclude = (id: number) => {
  if (id !== null) {
    ((showConfirmAction.value = false),
      router.delete(route('enterprise.delete', id)));
  }
};
</script>

<template>
  <Table>
    <TableHeader>
      <TableRow>
        <TableHead> Status </TableHead>
        <TableHead>Nome</TableHead>
        <TableHead>Email</TableHead>
        <TableHead> Assinatura </TableHead>
        <TableHead> Ações </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-for="(enterprise, index) in props.enterprises" :key="index">
        <TableCell>
          <CircleCheckBig
            v-if="isActive(enterprise.active)"
            class="h-5 w-5 text-green-600"
          />
          <CircleX v-else class="h-5 w-5 text-red-600" />
        </TableCell>
        <TableCell>{{ enterprise.name }}</TableCell>
        <TableCell>{{ enterprise.email }}</TableCell>
        <TableCell>
          {{ getNameSubscription(enterprise.subscription.name) }}
        </TableCell>
        <TableCell>
          <DropdownMenu>
            <DropdownMenuTrigger as-child>
              <Button variant="ghost" class="cursor-pointer">
                <Ellipsis />
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
                  @click="emit('edit:enterprise', enterprise)"
                >
                  <Pencil /> <span>Editar</span>
                </DropdownMenuItem>
                <DropdownMenuItem
                  class="cursor-pointer text-xs text-red-600 sm:text-sm"
                  @click="openConfirmAction(enterprise.id)"
                >
                  <Trash class="text-red-600" /> <span>Excluir</span>
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
    title="Exclusão de empresa"
    message="Caso tenha certeza, clique em 'Confirmar', pois essa ação é irreversível e excluirá a empresa permanentemente."
    @update:open="closeConfirmAction()"
    @okConfirmAction="okConfirmAction()"
  />
</template>
