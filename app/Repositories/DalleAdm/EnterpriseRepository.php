<?php

namespace App\Repositories\DalleAdm;

use App\Models\DalleManage\EnterpriseDM;
use Illuminate\Support\Facades\DB;

class EnterpriseRepository
{
    public function __construct(public EnterpriseDM $model) {}

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $enterprise = $this->findById($id);

        if ($enterprise) {
            $enterprise->update($data);

            return $enterprise;
        }

        return null;
    }

    public function delete($id)
    {
        $enterprise = $this->findById($id);

        if ($enterprise) {
            DB::connection('dalle_manage')->table('clients')->where('enterprise_id', $id)->delete();

            // DEPARTMENTS
            DB::connection('dalle_manage')->table('users')->where('enterprise_id', $id)
                ->whereNotNull('department_id')
                ->update(['department_id' => null]);
            DB::connection('dalle_manage')->table('employees')->where('enterprise_id', $id)
                ->whereNotNull('department_id')
                ->update(['department_id' => null]);
            DB::connection('dalle_manage')->table('departments')->where('enterprise_id', $id)->delete();

            // EMPLOYEES
            DB::connection('dalle_manage')->table('employees')->where('enterprise_id', $id)->delete();

            // PRODUCTS ADVANCED
            DB::connection('dalle_manage')->table('product_advanced')
                ->whereIn('product_id', function ($query) use ($id) {
                    $query->select('id')
                        ->from('products')
                        ->where('enterprise_id', $id);
                })->delete();

            // PRODUCT LOG
            DB::connection('dalle_manage')->table('product_log')
                ->whereIn('product_id', function ($query) use ($id) {
                    $query->select('id')
                        ->from('products')
                        ->where('enterprise_id', $id);
                })->delete();

            // PRODUCT IMAGE
            DB::connection('dalle_manage')->table('product_image')
                ->whereIn('product_id', function ($query) use ($id) {
                    $query->select('id')
                        ->from('products')
                        ->where('enterprise_id', $id);
                })->delete();

            // PRODUCT TAG
            DB::connection('dalle_manage')->table('product_tag')
                ->whereIn('product_id', function ($query) use ($id) {
                    $query->select('id')
                        ->from('products')
                        ->where('enterprise_id', $id);
                })->delete();

            // PRODUCT MOVEMENTS
            DB::connection('dalle_manage')->table('product_movements')->where('enterprise_id', $id)->delete();

            // PRODUCT VARIANTS
            DB::connection('dalle_manage')->table('supplier_catalog')->where('enterprise_id', $id)
                ->whereNotNull('product_variant_id')
                ->update(['product_variant_id' => null]);
            DB::connection('dalle_manage')->table('product_variants')->where('enterprise_id', $id)->delete();

            // PRODUCT COLORS
            DB::connection('dalle_manage')->table('product_colors')->where('enterprise_id', $id)->delete();

            // PRODUCT CATEGORIES
            DB::connection('dalle_manage')->table('products')->where('enterprise_id', $id)
                ->whereNotNull('product_category_id')
                ->update(['product_category_id' => null]);
            DB::connection('dalle_manage')->table('product_categories')->where('enterprise_id', $id)->delete();

            // PRODUCTS
            DB::connection('dalle_manage')->table('products')->where('enterprise_id', $id)->delete();

            // GRID ITEMS
            DB::connection('dalle_manage')->table('grid_items')->where('enterprise_id', $id)->delete();

            // GRID GROUPS
            DB::connection('dalle_manage')->table('grid_groups')->where('enterprise_id', $id)->delete();

            // IMAGES
            DB::connection('dalle_manage')->table('feedbacks')
                ->whereIn('image_id', function ($query) use ($id) {
                    $query->select('id')
                        ->from('images')
                        ->where('enterprise_id', $id);
                })->delete();
            DB::connection('dalle_manage')->table('images')->where('enterprise_id', $id)->delete();

            // MOVEMENTS
            DB::connection('dalle_manage')->table('movements')->where('enterprise_id', $id)->delete();

            // NOTIFICATIONS
            DB::connection('dalle_manage')->table('notifications')->where('enterprise_id', $id)->delete();

            // RECEIPTS
            DB::connection('dalle_manage')->table('receipts')->where('enterprise_id', $id)->delete();

            // ROLES
            DB::connection('dalle_manage')->table('users')->where('enterprise_id', $id)
                ->whereNotNull('role_id')
                ->update(['role_id' => null]);
            DB::connection('dalle_manage')->table('roles')->where('enterprise_id', $id)->delete();

            // SCHEDULES
            DB::connection('dalle_manage')->table('schedules')->where('enterprise_id', $id)->delete();

            // SETTING APPEARANCE
            DB::connection('dalle_manage')->table('setting_appearance')->where('enterprise_id', $id)->delete();

            // SETTING SYSTEM
            DB::connection('dalle_manage')->table('setting_system')->where('enterprise_id', $id)->delete();

            // SUPPLIER CATALOG
            DB::connection('dalle_manage')->table('supplier_catalog')->where('enterprise_id', $id)->delete();

            // SUPPLIER CATEGORIES
            DB::connection('dalle_manage')->table('suppliers')->where('enterprise_id', $id)
                ->whereNotNull('supplier_category_id')
                ->update(['supplier_category_id' => null]);
            DB::connection('dalle_manage')->table('supplier_categories')->where('enterprise_id', $id)->delete();

            // SUPPLIERS
            DB::connection('dalle_manage')->table('suppliers')->where('enterprise_id', $id)->delete();

            // TAGS
            DB::connection('dalle_manage')->table('tags')->where('enterprise_id', $id)->delete();

            // TRANSACTION CATEGORIES
            DB::connection('dalle_manage')->table('transaction_categories')->where('enterprise_id', $id)->delete();

            // TYPES RECEIPT
            DB::connection('dalle_manage')->table('types_receipt')->where('enterprise_id', $id)->delete();

            // USERS
            DB::connection('dalle_manage')->table('users')->where('enterprise_id', $id)->delete();

            return $enterprise->delete();
        }

        return false;
    }
}
