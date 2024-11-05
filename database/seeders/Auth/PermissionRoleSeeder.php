<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles
        Role::create([
            'id' => 1,
            'type' => User::TYPE_ADMIN,
            'name' => 'Administrator',
        ]);
        Role::create([
            'id' => 2,
            'type' => User::TYPE_ADMIN,
            'name' => 'Merchant Administrator',
        ]);
        Role::create([
            'id' => 3,
            'type' => User::TYPE_USER,
            'name' => 'Customer',
        ]);
        // Non Grouped Permissions
        //

        // Grouped permissions
        // Users category
        $users = Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.access.user',
            'description' => 'All Admin Permissions',
        ]);

        $users->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.list',
                'description' => 'View Admins',
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.deactivate',
                'description' => 'Deactivate Admins',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.reactivate',
                'description' => 'Reactivate Admins',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.clear-session',
                'description' => 'Clear Admins Sessions',
                'sort' => 4,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.impersonate',
                'description' => 'Impersonate Admins',
                'sort' => 5,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.change-password',
                'description' => 'Change Admin Passwords',
                'sort' => 6,
            ]),
        ]);

        // Assign Permissions to other Roles
        //
        //Merchant
        $merchant= Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.merchant',
            'description' => __('All Merchant Permissions'),
        ]);

        $merchant->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.merchant.list',
                'description' => __('View Merchants'),
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.merchant.store',
                'description' => __('Create Merchants'),
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.merchant.update',
                'description' => __('Update Merchants'),
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.merchant.delete',
                'description' => __('Delete Merchants'),
                'sort' => 4,
            ]),
        ]);
        //

        //Customer
        $customer= Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.customer',
            'description' => __('All Customer Permissions'),
        ]);

        $customer->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.customer.list',
                'description' => __('View Customers'),
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.customer.store',
                'description' => __('Create Customers'),
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.customer.update',
                'description' => __('Update Customers'),
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.customer.delete',
                'description' => __('Delete Customers'),
                'sort' => 4,
            ]),
        ]);
        //
            //Order
            $order= Permission::create([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.order',
                'description' => __('All Order Permissions'),
            ]);

        $order->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.order.list',
                'description' => __('View Orders'),
            ]),
        ]);
            //
            //Rating
            $rating= Permission::create([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.rating',
                'description' => __('All Ratings Permissions'),
            ]);

        $rating->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.rating.list',
                'description' => __('View Ratings'),
            ]),
        ]);
        //
        //Notification
        $notification= Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.notification',
            'description' => __('All Notification Permissions'),
        ]);

        $notification->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.notification.list',
                'description' => __('View Notifications'),
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.notification.store',
                'description' => __('Create Notifications'),
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.notification.update',
                'description' => __('Update Notifications'),
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.notification.delete',
                'description' => __('Delete Notifications'),
                'sort' => 4,
            ]),
        ]);
        //
        //Information
        $information= Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.information',
            'description' => __('All Information Permissions'),
        ]);

        $information->children()->saveMany([

            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.information.update',
                'description' => __('Update Information'),
                'sort' => 3,
            ]),
        ]);
        //
        //Social
        $social= Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.social',
            'description' => __('All Social Media Permissions'),
        ]);

        $social->children()->saveMany([

            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.social.update',
                'description' => __('Update Social Media'),
                'sort' => 3,
            ]),
        ]);
        //
        //Page
        $page = Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.lookups.page',
            'description' => __('All Page Permissions'),
        ]);

        $page->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.page.list',
                'description' => __('View Page'),
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.page.update',
                'description' => __('Update Page'),
                'sort' => 3,
            ]),
        ]);
        //

        //Country
        $countries = Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.lookups.country',
            'description' => __('All Country Permissions'),
        ]);

        $countries->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.country.list',
                'description' => __('View Country'),
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.country.store',
                'description' => __('Create Country'),
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.country.update',
                'description' => __('Update Country'),
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.country.delete',
                'description' => __('Delete Country'),
                'sort' => 4,
            ]),
        ]);
        //

        //City
        $cities = Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.lookups.city',
            'description' => __('All City Permissions'),
        ]);

        $cities->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.city.list',
                'description' => __('View City'),
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.city.store',
                'description' => __('Create City'),
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.city.update',
                'description' => __('Update City'),
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.city.delete',
                'description' => __('Delete City'),
                'sort' => 4,
            ]),
        ]);
//
        //userType
//        $userType = Permission::create([
//            'type' => User::TYPE_ADMIN,
//            'name' => 'admin.lookups.userType',
//            'description' => __('All User Type Permissions'),
//        ]);
//        $userType->children()->saveMany([
//            new Permission([
//                'type' => User::TYPE_ADMIN,
//                'name' => 'admin.lookups.userType.list',
//                'description' => __('View User Type'),
//            ]),
//            new Permission([
//                'type' => User::TYPE_ADMIN,
//                'name' => 'admin.lookups.userType.store',
//                'description' => __('Create User Type'),
//                'sort' => 2,
//            ]),
//            new Permission([
//                'type' => User::TYPE_ADMIN,
//                'name' => 'admin.lookups.userType.update',
//                'description' => __('Update User Type'),
//                'sort' => 3,
//            ]),
//            new Permission([
//                'type' => User::TYPE_ADMIN,
//                'name' => 'admin.lookups.userType.delete',
//                'description' => __('Delete User Type'),
//                'sort' => 4,
//            ]),
//        ]);
//        //
//                //category
        $category = Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.lookups.category',
            'description' => __('All Categories Permissions'),
        ]);
        $category->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.category.list',
                'description' => __('View Categories'),
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.category.store',
                'description' => __('Create Categories'),
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.category.update',
                'description' => __('Update Categories'),
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.category.delete',
                'description' => __('Delete Categories'),
                'sort' => 4,
            ]),
        ]);

        //label
        $label = Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.lookups.label',
            'description' => __('All Labels Permissions'),
        ]);
        $label->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.label.list',
                'description' => __('View Labels'),
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.label.store',
                'description' => __('Create Labels'),
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.label.update',
                'description' => __('Update Labels'),
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.lookups.label.delete',
                'description' => __('Delete Labels'),
                'sort' => 4,
            ]),
        ]);
        //
        //deliveryFees
//        $deliveryFees = Permission::create([
//            'type' => User::TYPE_ADMIN,
//            'name' => 'admin.lookups.deliveryFee',
//            'description' => __('All Delivery Fees Permissions'),
//        ]);
//        $deliveryFees->children()->saveMany([
//            new Permission([
//                'type' => User::TYPE_ADMIN,
//                'name' => 'admin.lookups.deliveryFee.list',
//                'description' => __('View Delivery Fees'),
//            ]),
//            new Permission([
//                'type' => User::TYPE_ADMIN,
//                'name' => 'admin.lookups.deliveryFee.store',
//                'description' => __('Create Delivery Fees'),
//                'sort' => 2,
//            ]),
//            new Permission([
//                'type' => User::TYPE_ADMIN,
//                'name' => 'admin.lookups.deliveryFee.update',
//                'description' => __('Update Delivery Fees'),
//                'sort' => 3,
//            ]),
//            new Permission([
//                'type' => User::TYPE_ADMIN,
//                'name' => 'admin.lookups.deliveryFee.delete',
//                'description' => __('Delete Delivery Fees'),
//                'sort' => 4,
//            ]),
//        ]);
        //

        $this->enableForeignKeys();
    }
}
