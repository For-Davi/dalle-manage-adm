<script setup lang="ts">
import { ref } from 'vue';
import { goUrlName } from '@/composables/useRedirect';
import ConfirmAction from '../confirm/ConfirmAction.vue';
import { storeToRefs } from 'pinia';
import { useEnterpriseStore } from '@/stores/enterprise-store';
import { createError } from '@/composables/useCreateNotify';

defineOptions({
  name: 'UsersDmTable',
});

const props = defineProps<{
  enterpriseId: string;
}>();

const { loadingEnterprise, listUserDm } = storeToRefs(useEnterpriseStore());

const isConfirmOpen = ref(false);
const isDeleting = ref(false);
const selectedId = ref<number | null>(null);

const openDeleteModal = (id: number) => {
  selectedId.value = id;
  isConfirmOpen.value = true;
};
const handleExclude = async () => {
  try {
    isDeleting.value = true;
    const response = await useEnterpriseStore().deleteUserByEnterprise(
      Number(selectedId.value),
      Number(props.enterpriseId) ?? 0
    );

    if (response?.status === 200) {
      selectedId.value = null;
      isConfirmOpen.value = false;
    }
  } catch (error) {
    createError(error || 'Ocorreu um erro ao excluir o usuário.');
  } finally {
    isDeleting.value = false;
  }
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
                      goUrlName('enterprise-user.edit', {
                        userID: user.id,
                        id: props.enterpriseId,
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
    :loading="isDeleting"
    variant="destructive"
    @confirm="handleExclude"
  />
</template>
