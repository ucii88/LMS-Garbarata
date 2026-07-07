<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('modules')
            ->where('title', '1. Rotunda (Pangkal Garbarata)')
            ->update(['image_path' => 'images/modules/rotunda.png']);

        DB::table('modules')
            ->where('title', '2. Telescopic Tunnel (Terowongan)')
            ->update(['image_path' => 'images/modules/telescoping_tunnels.png']);

        DB::table('modules')
            ->where('title', '3. Cabin & Control Console (Kabin Kemudi)')
            ->update(['image_path' => 'images/modules/cabin.png']);

        DB::table('modules')
            ->where('title', '4. Drive Column & Wheels (Kolom Penggerak)')
            ->update(['image_path' => 'images/modules/wheel_boogie.png']);
    }

    public function down(): void
    {
        DB::table('modules')
            ->where('title', '1. Rotunda (Pangkal Garbarata)')
            ->update(['image_path' => null]);

        DB::table('modules')
            ->where('title', '2. Telescopic Tunnel (Terowongan)')
            ->update(['image_path' => null]);

        DB::table('modules')
            ->where('title', '3. Cabin & Control Console (Kabin Kemudi)')
            ->update(['image_path' => null]);

        DB::table('modules')
            ->where('title', '4. Drive Column & Wheels (Kolom Penggerak)')
            ->update(['image_path' => null]);
    }
};
