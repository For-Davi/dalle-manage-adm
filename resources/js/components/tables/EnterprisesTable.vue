<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { isActive } from '@/composables/useVerify';
import { getNameSubscription } from '@/composables/useSubscription';
import { goUrlName } from '@/composables/useRedirect';
import ConfirmAction from '../confirm/ConfirmAction.vue';

defineOptions({ name: 'EnterprisesTable' });

const props = defineProps<{
  enterprises: IEnterprise[];
}>();

const emit = defineEmits<{
  'open:manage': [enterprise: IEnterprise];
}>();

const isConfirmOpen = ref(false);
const isDeleting = ref(false);
const selectedId = ref<number | null>(null);

const openDeleteModal = (id: number) => {
  selectedId.value = id;
  isConfirmOpen.value = true;
};
const handleExclude = () => {
  if (selectedId.value === null) return;

  router.delete(route('enterprise.delete', selectedId.value), {
    onBefore: () => { isDeleting.value = true; },
    onSuccess: () => {
      isConfirmOpen.value = false;
      selectedId.value = null;
    },
    onFinish: () => { isDeleting.value = false; },
  });
};

const goEdit = (id: number) => goUrlName('enterprise.edit', { id });
</script>

<template>
  <Table>
    <TableHeader>
      <TableRow>
        <TableHead>Status</TableHead>
        <TableHead>Nome</TableHead>
        <TableHead>Email</TableHead>
        <TableHead>Assinatura</TableHead>
        <TableHead class="text-right">Ações</TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-for="enterprise in props.enterprises" :key="enterprise.id">
        <TableCell>
          <LucideCircleCheckBig v-if="isActive(enterprise.active)" class="h-5 w-5 text-green-600" />
          <LucideCircleX v-else class="h-5 w-5 text-red-600" />
        </TableCell>
        <TableCell class="font-medium">{{ enterprise.name }}</TableCell>
        <TableCell>{{ enterprise.email }}</TableCell>
        <TableCell>{{ getNameSubscription(enterprise.subscription.name) }}</TableCell>
        <TableCell class="text-right">
          <DropdownMenu>
            <DropdownMenuTrigger as-child>
              <Button variant="ghost" size="icon">
                <LucideEllipsis class="h-4 w-4" />
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end" class="w-48">
              <DropdownMenuLabel>Opções</DropdownMenuLabel>
              <DropdownMenuSeparator />

              <DropdownMenuItem @click="emit('open:manage', enterprise)">
                <LucideUsers class="mr-2 h-4 w-4" /> Usuários
              </DropdownMenuItem>

              <DropdownMenuItem @click="goEdit(enterprise.id)">
                <LucidePencil class="mr-2 h-4 w-4" /> Editar
              </DropdownMenuItem>

              <DropdownMenuSeparator />

              <DropdownMenuItem
                class="text-red-600 focus:text-red-600"
                @click="openDeleteModal(enterprise.id)"
              >
                <LucideTrash class="mr-2 h-4 w-4" /> Excluir
              </DropdownMenuItem>
            </DropdownMenuContent>
          </DropdownMenu>
        </TableCell>
      </TableRow>
    </TableBody>
  </Table>

  <ConfirmAction
    v-model:open="isConfirmOpen"
    title="Excluir Empresa"
    message="Esta ação é irreversível e excluirá todos os dados vinculados a esta empresa."
    :loading="isDeleting"
    variant="destructive"
    @confirm="handleExclude"
  />
</template>
