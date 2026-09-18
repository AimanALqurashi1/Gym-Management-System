<?php
// database/seeders/EquipmentSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EquipmentCategory;
use App\Models\Equipment;
use App\Models\EquipmentMaintenance;
use App\Models\EquipmentAssignment;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class EquipmentSeeder extends Seeder
{
    public function run()
    {
        // Get or create admin user for created_by/updated_by
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );

        // Create Equipment Categories
        $categories = [
            [
                'name' => 'Cardio Machines',
                'slug' => 'cardio-machines',
                'description' => 'Treadmills, ellipticals, stationary bikes, and rowing machines for cardiovascular training.',
                'icon' => 'fa-heart-pulse',
                'status' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Strength Training',
                'slug' => 'strength-training',
                'description' => 'Free weights, barbells, dumbbells, and weight plates for resistance training.',
                'icon' => 'fa-dumbbell',
                'status' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Machines',
                'slug' => 'machines',
                'description' => 'Cable machines, leg press, chest press, and other guided exercise equipment.',
                'icon' => 'fa-gear',
                'status' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Functional Training',
                'slug' => 'functional-training',
                'description' => 'Kettlebells, medicine balls, battle ropes, and suspension trainers.',
                'icon' => 'fa-person-running',
                'status' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Yoga & Pilates',
                'slug' => 'yoga-pilates',
                'description' => 'Yoga mats, blocks, straps, and Pilates reformers.',
                'icon' => 'fa-spa',
                'status' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Resistance bands, foam rollers, massage guns, and workout accessories.',
                'icon' => 'fa-bag-shopping',
                'status' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Recovery',
                'slug' => 'recovery',
                'description' => 'Massage tables, percussion massagers, stretching equipment.',
                'icon' => 'fa-bed',
                'status' => true,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($categories as $categoryData) {
            EquipmentCategory::updateOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        $this->command->info('Equipment categories created successfully!');

        // Get category IDs for reference
        $cardioId = EquipmentCategory::where('slug', 'cardio-machines')->first()->id;
        $strengthId = EquipmentCategory::where('slug', 'strength-training')->first()->id;
        $machinesId = EquipmentCategory::where('slug', 'machines')->first()->id;
        $functionalId = EquipmentCategory::where('slug', 'functional-training')->first()->id;
        $yogaId = EquipmentCategory::where('slug', 'yoga-pilates')->first()->id;
        $accessoriesId = EquipmentCategory::where('slug', 'accessories')->first()->id;
        $recoveryId = EquipmentCategory::where('slug', 'recovery')->first()->id;

        // Create Equipment Items
        $equipmentItems = [
            // Cardio Machines
            [
                'name' => 'Professional Treadmill',
                'code' => 'CARD-001',
                'category_id' => $cardioId,
                'description' => 'High-end commercial treadmill with 22" touchscreen, 15% incline, and heart rate monitoring.',
                'brand' => 'Life Fitness',
                'model' => 'T-9500',
                'serial_number' => 'LF-T9500-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(8),
                'purchase_price' => 4500.00,
                'current_value' => 3800.00,
                'supplier' => 'Fitness Equipment Direct',
                'warranty_until' => Carbon::now()->addYears(2),
                'location' => 'Cardio Area',
                'status' => 'available',
                'quantity' => 3,
                'available_quantity' => 2,
                'specifications' => json_encode([
                    'max_speed' => '12 mph',
                    'incline' => '15%',
                    'motor' => '4.0 HP',
                    'weight_capacity' => '400 lbs'
                ]),
                'maintenance_schedule' => json_encode([
                    'interval_days' => 90,
                    'last_oil_change' => Carbon::now()->subMonths(2)->format('Y-m-d'),
                    'belt_tension_check' => 'quarterly'
                ]),
                'last_maintenance_date' => Carbon::now()->subMonths(2),
                'next_maintenance_date' => Carbon::now()->addMonth(),
            ],
            [
                'name' => 'Elliptical Cross-Trainer',
                'code' => 'CARD-002',
                'category_id' => $cardioId,
                'description' => 'Smooth, low-impact elliptical with adjustable stride length and resistance.',
                'brand' => 'Precor',
                'model' => 'EFX-835',
                'serial_number' => 'PC-EFX835-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subYear(),
                'purchase_price' => 3800.00,
                'current_value' => 3100.00,
                'supplier' => 'Gym Equipment Pro',
                'warranty_until' => Carbon::now()->addYear(),
                'location' => 'Cardio Area',
                'status' => 'in_use',
                'quantity' => 2,
                'available_quantity' => 0,
                'specifications' => json_encode([
                    'stride_length' => '18-22" adjustable',
                    'resistance_levels' => 20,
                    'flywheel_weight' => '30 lbs'
                ]),
                'last_maintenance_date' => Carbon::now()->subMonths(3),
                'next_maintenance_date' => Carbon::now()->addMonths(3),
            ],
            [
                'name' => 'Stationary Bike - Spin',
                'code' => 'CARD-003',
                'category_id' => $cardioId,
                'description' => 'Commercial spin bike with magnetic resistance and LCD display.',
                'brand' => 'Schwinn',
                'model' => 'IC4',
                'serial_number' => 'SW-IC4-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(4),
                'purchase_price' => 1200.00,
                'current_value' => 1100.00,
                'supplier' => 'Fitness Superstore',
                'location' => 'Spin Studio',
                'status' => 'available',
                'quantity' => 10,
                'available_quantity' => 4,
                'specifications' => json_encode([
                    'resistance' => 'Magnetic 100 levels',
                    'flywheel' => '40 lbs',
                    'drive' => 'Belt'
                ]),
                'last_maintenance_date' => Carbon::now()->subMonth(),
                'next_maintenance_date' => Carbon::now()->addMonths(2),
            ],

            // Strength Training
            [
                'name' => 'Olympic Barbell Set',
                'code' => 'STR-001',
                'category_id' => $strengthId,
                'description' => '7ft Olympic barbell with weight plates (2.5kg to 25kg) and collars.',
                'brand' => 'Rogue Fitness',
                'model' => 'OB-86B',
                'serial_number' => 'RG-OB86-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(10),
                'purchase_price' => 850.00,
                'current_value' => 750.00,
                'supplier' => 'Rogue Direct',
                'location' => 'Weight Room',
                'status' => 'available',
                'quantity' => 4,
                'available_quantity' => 2,
                'specifications' => json_encode([
                    'bar_weight' => '20 kg',
                    'length' => '7.2 ft',
                    'weight_capacity' => '1500 lbs',
                    'sleeve_type' => 'Bushing'
                ]),
                'last_maintenance_date' => Carbon::now()->subMonths(2),
                'next_maintenance_date' => Carbon::now()->addMonths(4),
            ],
            [
                'name' => 'Adjustable Dumbbells Set',
                'code' => 'STR-002',
                'category_id' => $strengthId,
                'description' => 'Quick-adjust dumbbells ranging from 5-50 lbs per hand.',
                'brand' => 'Bowflex',
                'model' => '552',
                'serial_number' => 'BF-552-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(6),
                'purchase_price' => 350.00,
                'current_value' => 300.00,
                'supplier' => 'Bowflex',
                'location' => 'Weight Room',
                'status' => 'available',
                'quantity' => 6,
                'available_quantity' => 3,
                'specifications' => json_encode([
                    'weight_range' => '5-52.5 lbs',
                    'increments' => '2.5 lbs',
                    'sets' => 2
                ]),
                'needs_maintenance' => true, // Some need maintenance
            ],
            [
                'name' => 'Power Rack',
                'code' => 'STR-003',
                'category_id' => $strengthId,
                'description' => 'Heavy-duty power rack with safety bars, pull-up bar, and plate storage.',
                'brand' => 'Rogue',
                'model' => 'RML-390F',
                'serial_number' => 'RG-RML390-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subYear(),
                'purchase_price' => 1200.00,
                'current_value' => 1100.00,
                'supplier' => 'Rogue Direct',
                'location' => 'Weight Room',
                'status' => 'in_use',
                'quantity' => 2,
                'available_quantity' => 0,
            ],

            // Machines
            [
                'name' => 'Leg Press Machine',
                'code' => 'MCH-001',
                'category_id' => $machinesId,
                'description' => '45-degree leg press with plate-loaded design and adjustable seat.',
                'brand' => 'Cybex',
                'model' => 'LP-6500',
                'serial_number' => 'CY-LP6500-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(14),
                'purchase_price' => 2800.00,
                'current_value' => 2100.00,
                'supplier' => 'Cybex International',
                'location' => 'Machine Area',
                'status' => 'maintenance',
                'quantity' => 1,
                'available_quantity' => 0,
                'notes' => 'Needs cable replacement',
                'last_maintenance_date' => Carbon::now()->subDays(15),
                'next_maintenance_date' => Carbon::now()->addDays(5),
                'needs_maintenance' => true,
            ],
            [
                'name' => 'Cable Crossover Machine',
                'code' => 'MCH-002',
                'category_id' => $machinesId,
                'description' => 'Dual-adjustable pulley system for versatile cable exercises.',
                'brand' => 'Life Fitness',
                'model' => 'CC-9500',
                'serial_number' => 'LF-CC9500-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(18),
                'purchase_price' => 3200.00,
                'current_value' => 2500.00,
                'supplier' => 'Life Fitness',
                'location' => 'Machine Area',
                'status' => 'available',
                'quantity' => 1,
                'available_quantity' => 1,
            ],

            // Functional Training
            [
                'name' => 'Kettlebell Set',
                'code' => 'FUNC-001',
                'category_id' => $functionalId,
                'description' => 'Complete kettlebell set from 8kg to 32kg.',
                'brand' => 'Rogue',
                'model' => 'KB-PRO',
                'serial_number' => 'RG-KB-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(5),
                'purchase_price' => 600.00,
                'current_value' => 550.00,
                'supplier' => 'Rogue Direct',
                'location' => 'Functional Zone',
                'status' => 'available',
                'quantity' => 8,
                'available_quantity' => 5,
                'specifications' => json_encode([
                    'weights' => '8,12,16,20,24,28,32 kg',
                    'material' => 'Cast iron with powder coat'
                ]),
            ],
            [
                'name' => 'Battle Ropes',
                'code' => 'FUNC-002',
                'category_id' => $functionalId,
                'description' => '50ft heavy-duty battle ropes for高强度 conditioning.',
                'brand' => 'Rage',
                'model' => 'BR-50',
                'serial_number' => 'RG-BR50-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(3),
                'purchase_price' => 150.00,
                'current_value' => 140.00,
                'supplier' => 'Fitness Depot',
                'location' => 'Functional Zone',
                'status' => 'broken',
                'quantity' => 1,
                'available_quantity' => 0,
                'notes' => 'Frayed ends, needs replacement',
                'needs_maintenance' => true,
            ],
            [
                'name' => 'Suspension Trainer',
                'code' => 'FUNC-003',
                'category_id' => $functionalId,
                'description' => 'TRX-style suspension training system for bodyweight exercises.',
                'brand' => 'TRX',
                'model' => 'PRO4',
                'serial_number' => 'TRX-PRO4-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(2),
                'purchase_price' => 200.00,
                'current_value' => 195.00,
                'supplier' => 'TRX Direct',
                'location' => 'Studio 1',
                'status' => 'available',
                'quantity' => 4,
                'available_quantity' => 2,
            ],

            // Yoga & Pilates
            [
                'name' => 'Premium Yoga Mat',
                'code' => 'YOG-001',
                'category_id' => $yogaId,
                'description' => 'Eco-friendly, non-slip yoga mat with carrying strap.',
                'brand' => 'Manduka',
                'model' => 'PRO',
                'serial_number' => 'MK-PRO-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(1),
                'purchase_price' => 100.00,
                'current_value' => 98.00,
                'supplier' => 'Yoga Outfitters',
                'location' => 'Yoga Studio',
                'status' => 'available',
                'quantity' => 20,
                'available_quantity' => 15,
            ],
            [
                'name' => 'Yoga Blocks (Set of 2)',
                'code' => 'YOG-002',
                'category_id' => $yogaId,
                'description' => 'High-density foam yoga blocks for support and alignment.',
                'brand' => 'Gaiam',
                'model' => 'BLK-CORK',
                'purchase_date' => Carbon::now()->subMonths(2),
                'purchase_price' => 25.00,
                'current_value' => 23.00,
                'supplier' => 'Gaiam',
                'location' => 'Yoga Studio',
                'status' => 'available',
                'quantity' => 30,
                'available_quantity' => 22,
            ],
            [
                'name' => 'Pilates Reformer',
                'code' => 'YOG-003',
                'category_id' => $yogaId,
                'description' => 'Professional Pilates reformer with adjustable springs.',
                'brand' => 'Balanced Body',
                'model' => 'Studio Reformer',
                'serial_number' => 'BB-SR-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(9),
                'purchase_price' => 3200.00,
                'current_value' => 2900.00,
                'supplier' => 'Pilates Direct',
                'location' => 'Pilates Studio',
                'status' => 'in_use',
                'quantity' => 2,
                'available_quantity' => 1,
            ],

            // Accessories
            [
                'name' => 'Resistance Bands Set',
                'code' => 'ACC-001',
                'category_id' => $accessoriesId,
                'description' => 'Set of 5 resistance bands with different tension levels.',
                'brand' => 'Fit Simplify',
                'model' => 'RB-5SET',
                'purchase_date' => Carbon::now()->subMonths(3),
                'purchase_price' => 30.00,
                'current_value' => 28.00,
                'supplier' => 'Amazon',
                'location' => 'Accessories Rack',
                'status' => 'available',
                'quantity' => 15,
                'available_quantity' => 10,
            ],
            [
                'name' => 'Foam Rollers',
                'code' => 'ACC-002',
                'category_id' => $accessoriesId,
                'description' => 'High-density foam rollers for myofascial release.',
                'brand' => 'TriggerPoint',
                'model' => 'GRID',
                'serial_number' => 'TP-GRID-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(4),
                'purchase_price' => 45.00,
                'current_value' => 40.00,
                'supplier' => 'TriggerPoint',
                'location' => 'Recovery Area',
                'status' => 'available',
                'quantity' => 8,
                'available_quantity' => 5,
            ],
            [
                'name' => 'Ab Wheel',
                'code' => 'ACC-003',
                'category_id' => $accessoriesId,
                'description' => 'Dual-wheel ab roller with knee pad.',
                'brand' => 'Perfect Fitness',
                'model' => 'AB-WHEEL',
                'serial_number' => 'PF-AW-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(5),
                'purchase_price' => 20.00,
                'current_value' => 18.00,
                'supplier' => 'Perfect Fitness',
                'location' => 'Accessories Rack',
                'status' => 'available',
                'quantity' => 5,
                'available_quantity' => 3,
            ],

            // Recovery
            [
                'name' => 'Massage Gun',
                'code' => 'REC-001',
                'category_id' => $recoveryId,
                'description' => 'Percussion massage gun with multiple attachments.',
                'brand' => 'Theragun',
                'model' => 'Pro 5th Gen',
                'serial_number' => 'TG-PRO5-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(2),
                'purchase_price' => 600.00,
                'current_value' => 580.00,
                'supplier' => 'Theragun',
                'location' => 'Recovery Room',
                'status' => 'available',
                'quantity' => 2,
                'available_quantity' => 1,
            ],
            [
                'name' => 'Massage Table',
                'code' => 'REC-002',
                'category_id' => $recoveryId,
                'description' => 'Portable, adjustable massage table with face cradle.',
                'brand' => 'Master Massage',
                'model' => 'MT-1000',
                'serial_number' => 'MM-MT1000-' . rand(10000, 99999),
                'purchase_date' => Carbon::now()->subMonths(10),
                'purchase_price' => 400.00,
                'current_value' => 350.00,
                'supplier' => 'Massage Supply Co',
                'location' => 'Massage Room',
                'status' => 'available',
                'quantity' => 1,
                'available_quantity' => 1,
            ],
        ];

        $createdEquipment = [];

        foreach ($equipmentItems as $itemData) {
            $equipment = Equipment::updateOrCreate(
                ['code' => $itemData['code']],
                array_merge($itemData, ['created_by' => $admin->id])
            );
            $createdEquipment[] = $equipment;
        }

        $this->command->info('Equipment items created successfully!');

        // Create Maintenance Records
        $maintenanceRecords = [
            [
                'equipment_id' => Equipment::where('code', 'MCH-001')->first()->id,
                'type' => 'repair',
                'maintenance_date' => Carbon::now()->subDays(15),
                'description' => 'Cable frayed and needs replacement',
                'notes' => 'Ordered replacement cables, awaiting delivery',
                'performed_by' => 'Mike Johnson (Technician)',
                'cost' => 150.00,
                'duration_minutes' => 60,
                'parts_replaced' => json_encode(['Cable set', 'Pulleys']),
                'status' => 'in_progress',
                'requires_followup' => true,
                'followup_notes' => 'Check tension after installation',
                'created_by' => $admin->id,
            ],
            [
                'equipment_id' => Equipment::where('code', 'FUNC-002')->first()->id,
                'type' => 'inspection',
                'maintenance_date' => Carbon::now()->subDays(5),
                'description' => 'Battle rope frayed at ends',
                'notes' => 'Rope needs replacement, unsafe for use',
                'performed_by' => 'Sarah Williams (Safety Officer)',
                'status' => 'completed',
                'requires_followup' => true,
                'followup_notes' => 'Order new rope',
                'created_by' => $admin->id,
            ],
            [
                'equipment_id' => Equipment::where('code', 'CARD-001')->first()->id,
                'type' => 'routine',
                'maintenance_date' => Carbon::now()->subMonths(2),
                'next_maintenance_date' => Carbon::now()->addMonth(),
                'description' => 'Monthly treadmill maintenance - belt tension, lubrication',
                'notes' => 'All treadmills serviced, belt tension adjusted',
                'performed_by' => 'Tech Team',
                'cost' => 0.00,
                'duration_minutes' => 120,
                'status' => 'completed',
                'created_by' => $admin->id,
            ],
            [
                'equipment_id' => Equipment::where('code', 'CARD-002')->first()->id,
                'type' => 'routine',
                'maintenance_date' => Carbon::now()->subMonths(3),
                'next_maintenance_date' => Carbon::now()->addMonths(3),
                'description' => 'Quarterly elliptical maintenance',
                'performed_by' => 'Tech Team',
                'status' => 'completed',
                'created_by' => $admin->id,
            ],
            [
                'equipment_id' => Equipment::where('code', 'STR-003')->first()->id,
                'type' => 'inspection',
                'maintenance_date' => Carbon::now()->subMonth(),
                'description' => 'Monthly safety inspection of power racks',
                'notes' => 'All bolts tight, safety bars functioning properly',
                'performed_by' => 'Safety Team',
                'status' => 'completed',
                'created_by' => $admin->id,
            ],
            [
                'equipment_id' => Equipment::where('code', 'YOG-003')->first()->id,
                'type' => 'repair',
                'maintenance_date' => Carbon::now()->subDays(20),
                'description' => 'Spring replacement on Reformer #2',
                'notes' => 'One spring broken, replaced with new set',
                'performed_by' => 'Pilates Equipment Specialist',
                'cost' => 85.00,
                'duration_minutes' => 45,
                'parts_replaced' => json_encode(['Spring set (4)']),
                'status' => 'completed',
                'created_by' => $admin->id,
            ],
        ];

        foreach ($maintenanceRecords as $record) {
            EquipmentMaintenance::create($record);
        }

        $this->command->info('Maintenance records created successfully!');

        // Get some members and trainers for assignments
        $members = Member::where('status', 'active')->take(5)->get();
        $trainers = Trainer::where('status', 1)->take(3)->get();

        // Create Equipment Assignments if members and trainers exist
        if ($members->count() > 0 && $trainers->count() > 0) {
            $assignments = [
                // Member assignments
                [
                    'equipment_id' => Equipment::where('code', 'CARD-002')->first()->id,
                    'assignable_type' => Member::class,
                    'assignable_id' => $members[0]->id,
                    'quantity' => 1,
                    'assigned_at' => Carbon::now()->subHours(2),
                    'expected_return_at' => Carbon::now()->addHours(2),
                    'purpose' => 'Cardio workout session',
                    'status' => 'assigned',
                    'assigned_by' => $admin->id,
                ],
                [
                    'equipment_id' => Equipment::where('code', 'ACC-001')->first()->id,
                    'assignable_type' => Member::class,
                    'assignable_id' => $members[1]->id,
                    'quantity' => 1,
                    'assigned_at' => Carbon::now()->subDay(),
                    'expected_return_at' => Carbon::now()->addDays(2),
                    'purpose' => 'Home workout - resistance band training',
                    'status' => 'assigned',
                    'assigned_by' => $admin->id,
                ],
                [
                    'equipment_id' => Equipment::where('code', 'YOG-001')->first()->id,
                    'assignable_type' => Member::class,
                    'assignable_id' => $members[2]->id,
                    'quantity' => 1,
                    'assigned_at' => Carbon::now()->subDays(2),
                    'expected_return_at' => Carbon::now()->addDays(5),
                    'purpose' => 'Yoga practice at home',
                    'status' => 'assigned',
                    'assigned_by' => $admin->id,
                ],

                // Trainer assignments
                [
                    'equipment_id' => Equipment::where('code', 'FUNC-003')->first()->id,
                    'assignable_type' => Trainer::class,
                    'assignable_id' => $trainers[0]->id,
                    'quantity' => 2,
                    'assigned_at' => Carbon::now()->subDays(3),
                    'expected_return_at' => Carbon::now()->addDays(4),
                    'purpose' => 'Training clients in functional fitness',
                    'status' => 'assigned',
                    'assigned_by' => $admin->id,
                ],
                [
                    'equipment_id' => Equipment::where('code', 'REC-001')->first()->id,
                    'assignable_type' => Trainer::class,
                    'assignable_id' => $trainers[1]->id,
                    'quantity' => 1,
                    'assigned_at' => Carbon::now()->subDays(1),
                    'expected_return_at' => Carbon::now()->addDays(6),
                    'purpose' => 'Post-workout recovery for clients',
                    'status' => 'assigned',
                    'assigned_by' => $admin->id,
                ],
            ];

            foreach ($assignments as $assignmentData) {
                $assignment = EquipmentAssignment::create($assignmentData);

                // Update equipment availability
                $equipment = Equipment::find($assignmentData['equipment_id']);
                $equipment->updateAvailability();
            }

            $this->command->info('Equipment assignments created successfully!');
        } else {
            $this->command->warn('No members or trainers found. Skipping equipment assignments.');
        }

        // Create some completed/returned assignments for history
        if ($members->count() > 0) {
            $returnedAssignments = [
                [
                    'equipment_id' => Equipment::where('code', 'ACC-002')->first()->id,
                    'assignable_type' => Member::class,
                    'assignable_id' => $members[0]->id,
                    'quantity' => 1,
                    'assigned_at' => Carbon::now()->subDays(5),
                    'returned_at' => Carbon::now()->subDays(4),
                    'expected_return_at' => Carbon::now()->subDays(3),
                    'purpose' => 'Recovery session',
                    'status' => 'returned',
                    'assigned_by' => $admin->id,
                    'received_by' => $admin->id,
                ],
                [
                    'equipment_id' => Equipment::where('code', 'STR-002')->first()->id,
                    'assignable_type' => Member::class,
                    'assignable_id' => $members[2]->id,
                    'quantity' => 1,
                    'assigned_at' => Carbon::now()->subWeeks(2),
                    'returned_at' => Carbon::now()->subWeeks(1),
                    'expected_return_at' => Carbon::now()->subWeeks(1)->addDay(),
                    'purpose' => 'Strength training at home',
                    'status' => 'returned',
                    'assigned_by' => $admin->id,
                    'received_by' => $admin->id,
                ],
            ];

            foreach ($returnedAssignments as $assignmentData) {
                EquipmentAssignment::create($assignmentData);
            }

            $this->command->info('Historical assignments created successfully!');
        }

        $this->command->info('====================================');
        $this->command->info('Equipment Seeding Completed!');
        $this->command->info('====================================');
        $this->command->info('Categories: ' . EquipmentCategory::count());
        $this->command->info('Equipment Items: ' . Equipment::count());
        $this->command->info('Maintenance Records: ' . EquipmentMaintenance::count());
        $this->command->info('Assignments: ' . EquipmentAssignment::count());
    }
}
