<?php

namespace Database\Seeders;


use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use App\Services\PermissionService;

class PermissionModelSeeder extends Seeder
{
    ## Service properties
    private PermissionService $permission_service;

    /**
     * constructor method
     * @return void
     */
    public function __construct()
    {
        $this->permission_service = new PermissionService();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $permissions = $this->permission_service->get_permission_lists();
        #module inputs;
        $module_name = "";
        $parent_checked = "";
        $label = "";

        #initial permission entries;
        foreach ($permissions as $index => $module) {
            $module_name = $index;
            $parent_checked = $module['parent_checked'];
            $label = $module['label'];
            $list = $module['list'];

            //dump($module);
            $module = Module::Create([
                'module_name' => $module_name,
                'parent_checked' => $parent_checked,
                'label' => $label,
            ]);

            for ($i = 0; $i < count($list); $i++) {
                $permission = Permission::Create([
                    'name' => $list[$i]['name'],
                    'module_id' => $module->id,
                    'checked' => $list[$i]['checked'],
                ]);
            }
        }
    }
}
