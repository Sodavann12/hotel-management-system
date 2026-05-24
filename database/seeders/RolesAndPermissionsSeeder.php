<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        $permissions = [
            'rooms.view', 'rooms.create', 'rooms.edit', 'rooms.delete',
            'bookings.view', 'bookings.create', 'bookings.edit', 'bookings.delete',
            'bookings.check-in', 'bookings.check-out', 'bookings.cancel',
            'customers.view', 'customers.create', 'customers.edit',
            'payments.view', 'payments.process', 'payments.refund',
            'invoices.view', 'invoices.generate',
            'staff.view', 'staff.create', 'staff.edit', 'staff.delete',
            'housekeeping.view', 'housekeeping.manage',
            'maintenance.view', 'maintenance.manage',
            'reports.view', 'reports.export',
            'settings.manage',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Super Admin — full access
        Role::firstOrCreate(['name' => 'super_admin'])
            ->givePermissionTo(Permission::all());

        // Manager — full operational access
        Role::firstOrCreate(['name' => 'manager'])
            ->givePermissionTo([
                'rooms.view', 'rooms.create', 'rooms.edit',
                'bookings.view', 'bookings.create', 'bookings.edit',
                'bookings.check-in', 'bookings.check-out', 'bookings.cancel',
                'customers.view', 'customers.create', 'customers.edit',
                'payments.view', 'payments.process',
                'invoices.view', 'invoices.generate',
                'staff.view',
                'housekeeping.view', 'housekeeping.manage',
                'maintenance.view', 'maintenance.manage',
                'reports.view', 'reports.export',
            ]);

        // Receptionist — front desk only
        Role::firstOrCreate(['name' => 'receptionist'])
            ->givePermissionTo([
                'rooms.view',
                'bookings.view', 'bookings.create', 'bookings.edit',
                'bookings.check-in', 'bookings.check-out',
                'customers.view', 'customers.create',
                'payments.view', 'payments.process',
                'invoices.view', 'invoices.generate',
            ]);

        // Housekeeping — room tasks only
        Role::firstOrCreate(['name' => 'housekeeping'])
            ->givePermissionTo([
                'rooms.view',
                'housekeeping.view',
                'housekeeping.manage',
            ]);

        $this->command->info('Roles and permissions seeded successfully.');
    }
}