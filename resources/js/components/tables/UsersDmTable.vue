<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { goUrlName } from '@/composables/useRedirect';
import ConfirmAction from '../confirm/ConfirmAction.vue';
import { storeToRefs } from 'pinia';
import { useEnterpriseStore } from '@/stores/enterprise-store';

defineOptions({
  name: 'UsersDmTable',
});

const { loadingEnterprise, listUserDm } = storeToRefs(useEnterpriseStore());

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
    onBefore: () => {
      isDeleting.value = true;
    },
    onSuccess: () => {
      isConfirmOpen.value = false;
      selectedId.value = null;
    },
    onFinish: () => {
      isDeleting.value = false;
    },
  });
};
</script>

<template>
  <main>
    <Table v-if="!loadingEnterprise">
      <TableHeader>
        <TableRow>
          <TableHead> Nome </TableHead>
          <TableHead>Email</TableHead>
          <TableHead> Ação </TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow v-for="(user, index) in listUserDm" :key="index">
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
                      goUrlName('enterprise-user.edit', { userID: user.id })
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
    :loading="isDeleting"
    variant="destructive"
    @confirm="handleExclude"
  />
</template>
