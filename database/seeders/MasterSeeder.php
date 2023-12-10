<?php

namespace Database\Seeders;

use App\Models\Activities;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Staff']);
        Role::create(['name' => 'Coordinator']);
        Role::create(['name' => 'Chief']);
        Role::create(['name' => 'Admin']);

        $admin = User::create(['name' => 'Administrator', 'email' => 'admin@bps.go.id', 'password' => bcrypt('123456'), 'phone_number' => '82236981385',]);
        $user1 = User::create(['name' => 'Ir. Firman Bastian M.Si', 'email' => 'firmanbstn@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $admin->id, 'phone_number' => '82236981385',]);
        $user1->assignRole('Chief');
        $user2 = User::create(['name' => 'Oni Sanimanto SE', 'email' => 'onisani@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user1->id, 'phone_number' => '82236981385',]);
        $user2->assignRole('Coordinator');
        $user3 = User::create(['name' => 'Achmad Nurochman SE', 'email' => 'nurochman@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user1->id, 'phone_number' => '82236981385',]);
        $user3->assignRole('Coordinator');
        $user4 = User::create(['name' => 'Budi Septiyono S.Si', 'email' => 'budisept@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user1->id, 'phone_number' => '82236981385',]);
        $user4->assignRole('Coordinator');
        $user5 = User::create(['name' => 'Rahmadanie Sapta Irevanie SST, M.Si', 'email' => 'rahmadanie@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user1->id, 'phone_number' => '82236981385',]);
        $user5->assignRole('Coordinator');
        $user6 = User::create(['name' => 'Dicky Dita Firmansyah S.ST, M.Ec.Dev', 'email' => 'ditaf@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user1->id, 'phone_number' => '82236981385',]);
        $user6->assignRole('Coordinator');
        $user7 = User::create(['name' => 'Endro Tri Sustono SE', 'email' => 'endrotris@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user1->id, 'phone_number' => '82236981385',]);
        $user7->assignRole('Coordinator');
        $user8 = User::create(['name' => 'Atmasari S.Si.', 'email' => 'atmasari@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user7->id, 'phone_number' => '82236981385',]);
        $user8->assignRole('Staff');
        $user9 = User::create(['name' => 'Syamsuddin ', 'email' => 'syamsud@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user6->id, 'phone_number' => '82236981385',]);
        $user9->assignRole('Staff');
        $user10 = User::create(['name' => 'Agus Tonowijaya ', 'email' => 'agustono@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user6->id, 'phone_number' => '82236981385',]);
        $user10->assignRole('Staff');
        $user11 = User::create(['name' => 'Yuliatin S.E', 'email' => 'yuliatin@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user5->id, 'phone_number' => '82236981385',]);
        $user11->assignRole('Staff');
        $user12 = User::create(['name' => 'Nur Rachmad Safari', 'email' => 'nursafari@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user7->id, 'phone_number' => '82236981385',]);
        $user12->assignRole('Staff');
        $user13 = User::create(['name' => 'Bambang Herwanto', 'email' => 'bambangher@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user6->id, 'phone_number' => '82236981385',]);
        $user13->assignRole('Staff');
        $user14 = User::create(['name' => 'Heru Hardanto S.Si, M.E', 'email' => 'harda@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user4->id, 'phone_number' => '82236981385',]);
        $user14->assignRole('Staff');
        $user15 = User::create(['name' => 'Zepri Ageng Pamuji S.Si', 'email' => 'zepri_ap@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user4->id, 'phone_number' => '82236981385',]);
        $user15->assignRole('Staff');
        $user16 = User::create(['name' => 'Sri Yogorini SST', 'email' => 'yogorini@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user7->id, 'phone_number' => '82236981385',]);
        $user16->assignRole('Staff');
        $user17 = User::create(['name' => 'Mokhamad Haris S.Si, M.AP', 'email' => 'mharis@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user3->id, 'phone_number' => '82236981385',]);
        $user17->assignRole('Staff');
        $user18 = User::create(['name' => 'Bambang Winarno A.Md', 'email' => 'bambangwinarno@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user2->id, 'phone_number' => '82236981385',]);
        $user18->assignRole('Staff');
        $user19 = User::create(['name' => 'Nova Dewi Oktasari SST, M.E', 'email' => 'novaoktasari@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user4->id, 'phone_number' => '82236981385',]);
        $user19->assignRole('Staff');
        $user20 = User::create(['name' => 'Dwi Agus Wijayanto S.Si', 'email' => 'da.wijayanto@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user4->id, 'phone_number' => '82236981385',]);
        $user20->assignRole('Staff');
        $user21 = User::create(['name' => 'Oktar Sander SST', 'email' => 'oktar.sander@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user5->id, 'phone_number' => '82236981385',]);
        $user21->assignRole('Staff');
        $user22 = User::create(['name' => 'Wisnu Ramadhan SST', 'email' => 'wisnu.ramadhan@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user6->id, 'phone_number' => '82236981385',]);
        $user22->assignRole('Staff');
        $user23 = User::create(['name' => 'Dita Rizky Pratama S.Tr.Stat.', 'email' => 'dita.rizky@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user6->id, 'phone_number' => '82236981385',]);
        $user23->assignRole('Staff');
        $user24 = User::create(['name' => 'Bagus Wicaksono Arianto A.Md', 'email' => 'bagus.arianto@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user7->id, 'phone_number' => '82236981385',]);
        $user24->assignRole('Staff');
        $user25 = User::create(['name' => 'Wesy Legiana A.Md.Stat.', 'email' => 'wesy.legiana@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user2->id, 'phone_number' => '82236981385',]);
        $user25->assignRole('Staff');
        $user26 = User::create(['name' => 'Puteri Ardhya Pramesti A.Md.Stat.', 'email' => 'ardhya.pramesti@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user5->id, 'phone_number' => '82236981385',]);
        $user26->assignRole('Staff');
        $user27 = User::create(['name' => 'Endro Dwi Budi Prasetyo', 'email' => 'endrodwi@bps.go.id', 'password' => bcrypt('123456'), 'supervisor_id' => $user6->id, 'phone_number' => '82236981385',]);
        $user27->assignRole('Staff');



        // $sp1 = User::create([
        //     'name' => 'sp1',
        //     'email' => 'sp1@gmail.com',
        //     'password' => bcrypt('123456'),
        //     'phone_number' => '82236981385',
        // ]);
        // $sp1->assignRole('Coordinator');
        // $sp2 = User::create([
        //     'name' => 'sp2',
        //     'email' => 'sp2@gmail.com',
        //     'password' => bcrypt('123456'),
        //     'phone_number' => '82236981385',
        // ]);
        // $sp2->assignRole('Coordinator');
        // $user1 = User::create([
        //     'name' => 'user1',
        //     'email' => 'user1@gmail.com',
        //     'password' => bcrypt('123456'),
        //     'phone_number' => '82236981385',
        //     'supervisor_id' => $sp1->id,
        // ]);
        // $user1->assignRole('Staff');

        // $user2 = User::create([
        //     'name' => 'user2',
        //     'email' => 'user2@gmail.com',
        //     'password' => bcrypt('123456'),
        //     'phone_number' => '82236981385',
        //     'supervisor_id' => $sp1->id,
        // ]);
        // $user2->assignRole('Staff');

        // Activities::factory()->count(100)->create();
    }
}
