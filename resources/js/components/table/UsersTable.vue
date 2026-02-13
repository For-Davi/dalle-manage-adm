<script setup lang="ts">
import { ref } from 'vue';
import { goUrlName } from '@/composables/useRedirect';
import ConfirmAction from '../confirm/ConfirmAction.vue';
import { storeToRefs } from 'pinia';
import { useUserAdmStore } from '@/stores/user-adm-store';
import { createError } from '@/composables/useCreateNotify';

defineOptions({
  name: 'UsersTable',
});

const { loadingUserAdm, listUsersAdm } = storeToRefs(useUserAdmStore());

const isConfirmOpen = ref(false);
const selectedId = ref<number | null>(null);

const openDeleteModal = (id: number) => {
  selectedId.value = id;
  isConfirmOpen.value = true;
};
const handleExclude = async () => {
  try {
    const response = await useUserAdmStore().deleteUser(
      Number(selectedId.value)
    );

    if (response?.status === 200) {
      selectedId.value = null;
      isConfirmOpen.value = false;
    }
  } catch (error) {
    createError(error || 'Ocorreu um erro ao excluir o usuário.');
  }
};
</script>

<template>
  <main>
    <Table v-if="!loadingUserAdm">
      <TableHeader>
        <TableRow>
          <TableHead> Nome </TableHead>
          <TableHead>Email</TableHead>
          <TableHead> Ação </TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow v-for="(user, index) in listUsersAdm" :key="index">
          <TableCell>{{ user.name }}</TableCell>
          <TableCell>{{ user.email }}</TableCell>
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
                      goUrlName('user.edit', {
                        id: user.id,
                      })
                    "
                  >
                    <LucidePencil /> <span>Editar</span>
                  </DropdownMenuItem>
                  <DropdownMenuItem
                    class="cursor-pointer text-xs text-red-600 sm:text-sm"
                    @click="openDeleteModal(user.id)"
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
    title="Excluir Usuário"
    message="Esta ação é irreversível e excluirá este usuário."
    :loading="loadingUserAdm"
    variant="destructive"
    @confirm="handleExclude"
  />
</template>
