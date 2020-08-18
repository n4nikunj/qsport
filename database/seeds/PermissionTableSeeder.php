<?php


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'permission-list',
            'permission-create',
            'permission-delete',
            'user-list',
            'user-create',
            'user-delete',
            'country-list',
            'country-create',
            'country-edit',
            'country-delete',
            'faq-list',
            'faq-create',
            'faq-edit',
            'faq-delete',
            'cms-list',
            'cms-create',
            'cms-edit',
            'cms-delete',
            'message-template-list',
            'message-template-create',
            'message-template-edit',
            'message-template-delete',
            'setting-list',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'game-list',
            'game-create',
            'game-edit',
            'game-delete',
            'level-list',
            'level-create',
            'level-edit',
            'level-delete',
            'quiz-list',
            'quiz-create',
            'quiz-edit',
            'quiz-delete',
            'watch-live-list',
            'watch-live-create',
            'watch-live-edit',
            'watch-live-delete',
            'training_sheet-list',
            'training_sheet-create',
            'training_sheet-edit',
            'training_sheet-delete',
            'enquiry-list',
            'enquiry-show',
            'training_online-list',
            'training_online-create',
            'training_online-edit',
            'training_online-delete',
            'general_config-list',
            'gems_config-list',
            'customer-list',
        ];
        foreach ($permissions as $permission) {
          Permission::create(['name' => $permission]);
        }
    }
}