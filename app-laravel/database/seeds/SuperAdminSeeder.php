<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $emailSuperAdmin = config('custom-config.super_admin.email');
            $userSuperAdmin = User::whereEmail($emailSuperAdmin)->first();
            $roleSuperAdmin = Role::whereSlug('super-admin')->first();
            $userSuperAdmin->roles()->sync($roleSuperAdmin);

            DB::commit();


        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
