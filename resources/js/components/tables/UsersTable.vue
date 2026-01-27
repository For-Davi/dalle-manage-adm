<script setup lang="ts">
import { Ellipsis, Pencil, Trash } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import ConfirmAction from '../confirm/ConfirmAction.vue';
import { router } from '@inertiajs/vue3';

defineOptions({
  name: 'UsersTable',
});

const page = usePage();

const props = defineProps<{
  users: IUserAdm[];
}>();

const emit = defineEmits<{
  'edit:user:': [user: IUserAdm];
}>();

const showConfirmAction = ref<boolean>(false);
const monitoringUserId = ref<number | null>(null);

const okConfirmAction = async () => {
  await exclude(monitoringUserId.value ?? 0);
  clear();
};
const openConfirmAction = (id: number) => {
  showConfirmAction.value = true;
  monitoringUserId.value = id;
};
const closeConfirmAction = () => {
  showConfirmAction.value = false;
  clear();
};
const exclude = (id: number) => {
  if (id !== null) {
    ((showConfirmAction.value = false),
      router.delete(route('user.delete', id)));
  }
};
const clear = () => {
  monitoringUserId.value = null;
};

const userId = computed(() => page.props.auth.user?.id);
</script>

<template>
  <Table>
    <TableHeader>
      <TableRow>
        <TableHead> Nome </TableHead>
        <TableHead>Email</TableHead>
        <TableHead> Ação </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-for="(user, index) in props.users" :key="index">
        <TableCell>{{ user.name }}</TableCell>
        <TableCell>{{ user.email }}</TableCell>
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
                  @click="emit('edit:user', user)"
                >
                  <Pencil /> <span>Editar</span>
                </DropdownMenuItem>
                <DropdownMenuItem
                  class="cursor-pointer text-xs text-red-600 sm:text-sm"
                  @click="openConfirmAction(user.id)"
                  v-if="user.created_by && user.id !== userId"
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
    title="Exclusão de usuário"
    message="Caso tenha certeza, clique em 'Confirmar', pois essa ação é irreversível e excluirá o usuário permanentemente."
    @update:open="closeConfirmAction()"
    @okConfirmAction="okConfirmAction()"
  />
</template>
