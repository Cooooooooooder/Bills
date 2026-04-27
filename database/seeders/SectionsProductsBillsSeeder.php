<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SectionsProductsBillsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('sections')->insert([
            [
                'section_name' => 'Electronics',
                'description' => 'Devices and gadgets',
                'created_by' => 'Admin',
            ],
            [
                'section_name' => 'Clothing',
                'description' => 'Men and women apparel',
                'created_by' => 'Admin',
            ],
            [
                'section_name' => 'Books',
                'description' => 'Educational and novels',
                'created_by' => 'Admin',
            ],
            [
                'section_name' => 'Furniture',
                'description' => 'Home and office furniture',
                'created_by' => 'Admin',
            ],
            [
                'section_name' => 'Toys',
                'description' => 'Kids toys and games',
                'created_by' => 'Admin',
            ],
            [
                'section_name' => 'Sports',
                'description' => 'Sports equipment',
                'created_by' => 'Admin',
            ],
            [
                'section_name' => 'Beauty',
                'description' => 'Cosmetics and skincare',
                'created_by' => 'Admin',
            ],
            [
                'section_name' => 'Automotive',
                'description' => 'Car accessories',
                'created_by' => 'Admin',
            ],
            [
                'section_name' => 'Groceries',
                'description' => 'Daily food and supplies',
                'created_by' => 'Admin',
            ],
            [
                'section_name' => 'Health',
                'description' => 'Medical supplies',
                'created_by' => 'Admin',
            ],
        ]);
        DB::table('products')->insert([
            [
                'product_name' => 'iPhone 14',
                'description' => 'Apple smartphone',
                'section_id' => 1, // Electronics
            ],
            [
                'product_name' => 'Samsung TV',
                'description' => 'Smart LED TV',
                'section_id' => 1,
            ],
            [
                'product_name' => 'T-Shirt',
                'description' => 'Cotton casual wear',
                'section_id' => 2, // Clothing
            ],
            [
                'product_name' => 'Jeans',
                'description' => 'Denim pants',
                'section_id' => 2,
            ],
            [
                'product_name' => 'Novel Book',
                'description' => 'Fiction story',
                'section_id' => 3, // Books
            ],
            [
                'product_name' => 'Office Chair',
                'description' => 'Ergonomic chair',
                'section_id' => 4, // Furniture
            ],
            [
                'product_name' => 'Football',
                'description' => 'Professional ball',
                'section_id' => 6, // Sports
            ],
            [
                'product_name' => 'Lipstick',
                'description' => 'Beauty product',
                'section_id' => 7, // Beauty
            ],
            [
                'product_name' => 'Car Cover',
                'description' => 'Vehicle protection',
                'section_id' => 8, // Automotive
            ],
            [
                'product_name' => 'Vitamins',
                'description' => 'Health supplements',
                'section_id' => 10, // Health
            ],
        ]);
        DB::table('bills')->insert([
            [
                'bill_number' => 'INV-2004',
                'bill_date' => now(),
                'due_date' => now()->addDays(5),
                'product' => 2,
                'payment_date' => null,
                'discount' => 10,
                'rate_vat' => '10%',
                'value_vat' => 180,
                'total' => 1800,
                'collection_amount' => 1800,
                'commission_amount' => 180,
                'status' => 'مدفوع',
                'value_status' => 1,
                'note' => 'Samsung TV fully paid',
                'user' => 'Admin',
                'file_name' => null,
                'section_id' => 1,
            ],
            [
                'bill_number' => 'INV-2005',
                'bill_date' => now(),
                'due_date' => now()->addDays(7),
                'product' => 3,
                'payment_date' => null,
                'discount' => 5,
                'rate_vat' => '5%',
                'value_vat' => 3,
                'total' => 53,
                'collection_amount' => 0,
                'commission_amount' => 5,
                'status' => 'غير مدفوع',
                'value_status' => 2,
                'note' => 'T-shirt pending',
                'user' => 'Admin',
                'file_name' => null,
                'section_id' => 2,
            ],
            [
                'bill_number' => 'INV-2006',
                'bill_date' => now(),
                'due_date' => now()->addDays(4),
                'product' => 5,
                'payment_date' => now(),
                'discount' => 0,
                'rate_vat' => '5%',
                'value_vat' => 3,
                'total' => 63,
                'collection_amount' => 63,
                'commission_amount' => 6,
                'status' => 'مدفوع',
                'value_status' => 1,
                'note' => 'Book order completed',
                'user' => 'Admin',
                'file_name' => null,
                'section_id' => 3,
            ],
            [
                'bill_number' => 'INV-2007',
                'bill_date' => now(),
                'due_date' => now()->addDays(6),
                'product' => 6,
                'payment_date' => null,
                'discount' => 20,
                'rate_vat' => '10%',
                'value_vat' => 20,
                'total' => 220,
                'collection_amount' => 100,
                'commission_amount' => 22,
                'status' => 'مدفوع جزئيا',
                'value_status' => 3,
                'note' => 'Chair partial payment',
                'user' => 'Admin',
                'file_name' => null,
                'section_id' => 4,
            ],
            [
                'bill_number' => 'INV-2008',
                'bill_date' => now(),
                'due_date' => now()->addDays(3),
                'product' => 7,
                'payment_date' => null,
                'discount' => 0,
                'rate_vat' => '10%',
                'value_vat' => 10,
                'total' => 110,
                'collection_amount' => 0,
                'commission_amount' => 11,
                'status' => 'غير مدفوع',
                'value_status' => 2,
                'note' => 'Football not paid',
                'user' => 'Admin',
                'file_name' => null,
                'section_id' => 6,
            ],
            [
                'bill_number' => 'INV-2009',
                'bill_date' => now(),
                'due_date' => now()->addDays(5),
                'product' => 8,
                'payment_date' => now(),
                'discount' => 5,
                'rate_vat' => '5%',
                'value_vat' => 2,
                'total' => 52,
                'collection_amount' => 52,
                'commission_amount' => 5,
                'status' => 'مدفوع',
                'value_status' => 1,
                'note' => 'Lipstick paid',
                'user' => 'Admin',
                'file_name' => null,
                'section_id' => 7,
            ],
            [
                'bill_number' => 'INV-2010',
                'bill_date' => now(),
                'due_date' => now()->addDays(7),
                'product' => 9,
                'payment_date' => null,
                'discount' => 10,
                'rate_vat' => '10%',
                'value_vat' => 15,
                'total' => 165,
                'collection_amount' => 0,
                'commission_amount' => 16,
                'status' => 'غير مدفوع',
                'value_status' => 2,
                'note' => 'Car cover pending',
                'user' => 'Admin',
                'file_name' => null,
                'section_id' => 8,
            ],
            [
                'bill_number' => 'INV-2011',
                'bill_date' => now(),
                'due_date' => now()->addDays(4),
                'product' => 10,
                'payment_date' => now(),
                'discount' => 0,
                'rate_vat' => '5%',
                'value_vat' => 5,
                'total' => 105,
                'collection_amount' => 105,
                'commission_amount' => 10,
                'status' => 'مدفوع',
                'value_status' => 1,
                'note' => 'Vitamins paid',
                'user' => 'Admin',
                'file_name' => null,
                'section_id' => 10,
            ],
            [
                'bill_number' => 'INV-2012',
                'bill_date' => now(),
                'due_date' => now()->addDays(8),
                'product' => 1,
                'payment_date' => null,
                'discount' => 50,
                'rate_vat' => '10%',
                'value_vat' => 120,
                'total' => 1270,
                'collection_amount' => 600,
                'commission_amount' => 127,
                'status' => 'مدفوع جزئيا',
                'value_status' => 3,
                'note' => 'iPhone partial payment',
                'user' => 'Admin',
                'file_name' => null,
                'section_id' => 1,
            ],
            [
                'bill_number' => 'INV-2013',
                'bill_date' => now(),
                'due_date' => now()->addDays(6),
                'product' => 4,
                'payment_date' => null,
                'discount' => 10,
                'rate_vat' => '5%',
                'value_vat' => 5,
                'total' => 95,
                'collection_amount' => 0,
                'commission_amount' => 9,
                'status' => 'غير مدفوع',
                'value_status' => 2,
                'note' => 'Jeans not paid',
                'user' => 'Admin',
                'file_name' => null,
                'section_id' => 2,
            ],
        ]);
    }
}
