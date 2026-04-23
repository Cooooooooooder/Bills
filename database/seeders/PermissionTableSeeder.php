<?php

namespace Database\Seeders;


use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 1. تنظيف كاش الصلاحيات قبل البدء (مهم جداً)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // الصلاحيات الأساسية للقوائم
            'الفواتير', ////
            'قائمة الفواتير', ////
            'الفواتير المدفوعة',////
            'الفواتير المدفوعة جزئيا',////
            'الفواتير الغير مدفوعة',  ////
            'الارشيف', ////

            'التقارير',
            'تقرير الفواتير',
            'تقرير العملاء',

            'المستخدمين', ////
            'قائمة المستخدمين', ////
            'صلاحيات المستخدمين', ////
            'الأقسام و المنتجات',  ////
            'المنتجات', ////
            'الاقسام',   ////

            // صلاحيات العمليات (Actions)
            'اضافة فاتورة', ////
            'حذف الفاتورة', ////
            'طباعة فاتورة', ////
            'ارشفة', ////
            'استرداد', ////
            'تصدير EXCEL',
            'تغير حالة الدفع', ////
            'تعديل الفاتورة', ////
            'المرفقات', ////

            // صلاحيات المستخدمين
            'اضافة مستخدم', ////
            'تعديل مستخدم', ////
            'حذف مستخدم', ////

            // صلاحيات الأدوار (Roles)
            'عرض صلاحية', ////
            'اضافة صلاحية', ////
            'تعديل صلاحية', ////
            'حذف صلاحية', ////

            // صلاحيات المنتجات
            'اضافة منتج', ////
            'تعديل منتج', ////
            'حذف منتج', ////

            // صلاحيات الأقسام
            'اضافة قسم', ////
            'تعديل قسم', ////
            'حذف قسم', ////

        ];

        foreach ($permissions as $permission) {
            // نستخدم firstOrCreate عشان نضمن ميتكررش ونحدد الـ guard_name
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 2. إنشاء الدور
        $role = Role::firstOrCreate(['name' => 'Owner', 'guard_name' => 'web']);

        // 3. ربط الصلاحيات بالأسماء بدلاً من الـ IDs (أضمن بكتير)
        $allPermissions = Permission::all();
        $role->syncPermissions($allPermissions);

        // 4. إنشاء المستخدم
        $user = User::create([
            'name' => 'Mora Soft',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'roles_name' => ['Owner'],
            'Status' => 'مفعل',
        ]);

        // تعيين الدور للمستخدم
        $user->assignRole($role->id);
    }
}
