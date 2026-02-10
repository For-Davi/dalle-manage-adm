export interface UserAdm {
  id: number;
  name: string;
  email: string;
  created_by: number;
}

export interface UserDm {
  id: number;
  name: string;
  email: string;
  active: number;
  role_id: number;
  enterprise_id: number;
  department_id: number;
  department: IDepartment | null;
  image_id: number | null;
  image: IImage | null;
}

export interface DataUserDm {
  id?: number;
  name: string;
  email: string;
  password: string;
  createEmployee: boolean;
}

export interface DataProfile {
  name: string;
  email: string;
}

export interface DataUserAdm {
  id?: number;
  name: string;
  email: string;
  password?: string;
}

export interface DataProfilePassword {
  current_password: string;
  password: string;
}
