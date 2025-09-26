<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue';
import { Ellipsis, Pencil, Trash } from 'lucide-vue-next';
import Empty from '../info/Empty.vue';
import axios from 'axios';
import ConfirmAction from '../confirm/ConfirmAction.vue';
import { router } from '@inertiajs/vue3';

defineOptions({
  name: 'UsersEnterpriseTable',
});

const props = defineProps<{
  enterpriseID: number | null;
}>();
const emit = defineEmits<{
  'edit:user': [IUser];
}>();

const listUsers = reactive<{ users: any[] }>({
  users: [],
});
const showConfirmAction = ref<boolean>(false);
const monitoringUserId = ref<number | null>(null);

const openConfirmAction = (id: number) => {
  ((showConfirmAction.value = true), (monitoringUserId.value = id));
};
const closeConfirmAction = () => {
  ((showConfirmAction.value = false), clear());
};
const okConfirmAction = async () => {
  await exclude(monitoringUserId.value ?? 0);
  clear();
};
const clear = () => {
  monitoringUserId.value = null;
};
const exclude = async (id: number) => {
  if (id !== null) {
    ((showConfirmAction.value = false),
      router.delete(route('delete.user.enterprise', id)));
      await fetchUsers()
  }
};
const fetchUsers = async () => {
  if (props.enterpriseID) {
    const response = await axios.get(
      `/adm/enterprise/users/${props.enterpriseID}`
    );
    listUsers.users = response.data.users || [];
  }
};

onMounted(async () => {
  if (props.enterpriseID) {
    await fetchUsers();
  }
});
</script>

<template>
  <Table v-if="listUsers.users.length > 0">
    <TableHeader>
      <TableRow>
        <TableHead>Nome</TableHead>
        <TableHead>Email</TableHead>
        <TableHead>Ações</TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-for="user in listUsers.users" :key="user.id">
        <TableCell
          style="
            white-space: normal;
            word-break: break-word;
            overflow-wrap: break-word;
          "
          >{{ user.name }}</TableCell
        >
        <TableCell
          style="
            white-space: normal;
            word-break: break-word;
            overflow-wrap: break-word;
          "
          >{{ user.email }}</TableCell
        >
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
  <div v-else class="m-5 flex justify-center">
    <Empty message="Esta empresa não possui usuários" icon="UserRoundX" />
  </div>

  <!-- Modals -->
  <ConfirmAction
    :open="showConfirmAction"
    title="Exclusão de empresa"
    message="Caso tenha certeza, clique em 'Confirmar', pois essa ação é irreversível e excluirá o usuário permanentemente."
    @update:open="closeConfirmAction()"
    @okConfirmAction="okConfirmAction()"
  />
</template>
