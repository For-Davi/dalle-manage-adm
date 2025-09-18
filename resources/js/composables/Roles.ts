export function getRoleName(value: string) {
  switch (value) {
    case 'super_admin':
      return 'Super Admin';
    case 'admin':
      return 'Admin';
    default:
      return 'Usuário Comum';
  }
}

export function canSeeActionButton(
  role: string,
  rowRole: string,
  id: number,
  rowId: number
) {
  return (
    role === 'super_admin' ||
    (role === 'admin' && rowRole === 'common_user') ||
    (role === 'admin' && id === rowId)
  );
}

export function canEditUsers(role: string, id: number, rowId: number) {
  return role === 'super_admin' || (role === 'admin' && id === rowId);
}

export function canDeleteUsers(
  role: string,
  rowRole: string,
  id: number,
  rowId: number
) {
  return (
    (role === 'super_admin' && id !== rowId) ||
    (role === 'admin' && rowRole === 'common_user')
  );
}

export function canEditSelfData(role: string, data: IUser) {
  return role === 'super_admin' || (role === 'admin' && !data);
}

export function canEditRole(role: string, data: IUser, rowRole: string) {
  return !data || (role === 'super_admin' && role !== rowRole);
}
