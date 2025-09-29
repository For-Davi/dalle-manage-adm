<?php

namespace App\Models\DalleManage;

use Illuminate\Database\Eloquent\Model;

class SettingAppearanceDM extends Model
{
    protected $connection = 'dalle_manage';

    protected $table = 'setting_appearance';

    protected $fillable = [
        'title_page_color_default',
        'navbar_color_default',
        'navbar_icon_color_default',
        'side_menu_color_default_not_selected_item',
        'side_menu_color_default_selected_item',
        'side_menu_color_default_not_selected_icon',
        'side_menu_color_default_selected_icon',
        'title_page_color_code',
        'navbar_color_code',
        'navbar_icon_color_code',
        'side_menu_color_code_not_selected_item',
        'side_menu_color_code_selected_item',
        'side_menu_color_code_not_selected_icon',
        'side_menu_color_code_selected_icon',
        'enterprise_id',
    ];

    public function enterprise()
    {
        return $this->belongsTo(EnterpriseDM::class, 'enterprise_id');
    }
}
