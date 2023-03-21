<?php

namespace Database\Seeders;

use App\Models\profileusers;
use App\Models\statusorder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        statusorder::create(
            ['status' => ['en' => 'Pending', 'ar' => 'قيد الانتظار']],
        );
        statusorder::create(
            ['status' => ['en' => 'Dispatched', 'ar' => 'مُرسَل']],
        );
        statusorder::create(
            ['status' => ['en' => 'Processed', 'ar' => 'معالجتها']],
        );
        statusorder::create(
            ['status' => ['en' => 'Shipped', 'ar' => 'شحنها']],
        );
        statusorder::create(
            ['status' => ['en' => 'Delivered', 'ar' => 'تم التوصيل']]
        );
        $user = User::create([
            'email' => 'ouafa@gmail.com',
            'password' => Hash::make('123456'),
            'roles_name' => ["Admin"],
            'Status' => '1',
            'admin' => '0',
            'email_verified_at' => Carbon::now()
        ]);
        $user_id = User::latest()->first()->id;
        profileusers::create([
            'user_id' => $user_id,
            'firstname' => ['en' => 'firsten1', 'ar' => 'firstar1'],
            'lastname' => ['en' => 'lasten1', 'ar' => 'lastar1'],
            'designation' => ['en' => 'null', 'ar' => 'فارغ'],
            'website' => 'null',
            'Address' => 'null',
            'twitter' => 'null',
            'facebook' => 'null',
            'google' => 'null',
            'linkedin' => 'null',
            'github' => 'null',
            'biographicalinfo' => 'null',
            'fullname' => 'null',
            'town' => 'null',
            'city' => 'null',
            'region' => 'null',
            'country' => 'null',
            'streetaddress' => 'null',
            'zipcode' => 'null',
            'phone' => 'null',
        ]);
            $role = Role::create(['name' => 'Admin']);

            $permissions = Permission::pluck('id','id')->all();

            $role->syncPermissions($permissions);

            $user->assignRole([$role->id]);

    }
}
