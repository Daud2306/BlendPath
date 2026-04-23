<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourcesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('resources')->delete();

        DB::table('resources')->insert(array(
            0 =>
            array(
                'id' => 1,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 1,
                'path' => 'https://www.youtube.com/embed/vaaVF3c-EAg',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-22 16:13:13',
                'updated_at' => '2026-04-22 16:13:13',
            ),
            1 =>
            array(
                'id' => 2,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 2,
                'path' => 'https://www.youtube.com/embed/w67X342uEvE',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-22 16:15:05',
                'updated_at' => '2026-04-22 16:15:05',
            ),
            2 =>
            array(
                'id' => 3,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 3,
                'path' => 'https://www.youtube.com/embed/A_4nbde8Rog',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-22 16:16:37',
                'updated_at' => '2026-04-22 16:16:37',
            ),
            3 =>
            array(
                'id' => 4,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 3,
                'path' => 'https://www.youtube.com/embed/NAwf0Tuuwjw',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-22 16:17:04',
                'updated_at' => '2026-04-22 16:17:04',
            ),
            4 =>
            array(
                'id' => 5,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 4,
                'path' => 'https://www.youtube.com/embed/4HIOVjbb1RQ',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-22 16:18:40',
                'updated_at' => '2026-04-22 16:18:40',
            ),
            5 =>
            array(
                'id' => 6,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 5,
                'path' => 'https://www.youtube.com/embed/jBT6MD7IzHU',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-22 16:21:19',
                'updated_at' => '2026-04-22 16:21:19',
            ),
            6 =>
            array(
                'id' => 7,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 6,
                'path' => 'https://www.youtube.com/embed/dm3bBpZVmnE',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-22 16:25:12',
                'updated_at' => '2026-04-22 16:25:12',
            ),
            7 =>
            array(
                'id' => 8,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 7,
                'path' => 'https://www.youtube.com/embed/uyvCzp_33xU',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-22 16:32:09',
                'updated_at' => '2026-04-22 16:32:09',
            ),
            8 =>
            array(
                'id' => 10,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 8,
                'path' => 'https://www.youtube.com/embed/D2AgCcC1hjs',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-22 16:34:00',
                'updated_at' => '2026-04-22 16:34:00',
            ),
            9 =>
            array(
                'id' => 11,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 8,
                'path' => 'https://www.youtube.com/embed/uFPuYg4QjL4',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-22 16:34:41',
                'updated_at' => '2026-04-22 16:34:41',
            ),
            10 =>
            array(
                'id' => 12,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 9,
                'path' => 'https://www.youtube.com/embed/IZW-VIlCcas',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-22 16:37:59',
                'updated_at' => '2026-04-22 16:37:59',
            ),
            11 =>
            array(
                'id' => 13,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 10,
                'path' => 'https://www.youtube.com/embed/4Uy2SzB-Kuk',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-22 16:39:10',
                'updated_at' => '2026-04-22 16:39:10',
            ),
            12 =>
            array(
                'id' => 14,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 11,
                'path' => 'https://www.youtube.com/embed/ZYk3OOf-gBk',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-22 16:40:19',
                'updated_at' => '2026-04-22 16:40:19',
            ),
            13 =>
            array(
                'id' => 15,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 12,
                'path' => 'https://www.youtube.com/embed/RzoJu8SV5LQ',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-23 00:45:55',
                'updated_at' => '2026-04-23 00:45:55',
            ),
            14 =>
            array(
                'id' => 16,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 13,
                'path' => 'https://www.youtube.com/embed/kIW648Cfo18',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-23 00:47:02',
                'updated_at' => '2026-04-23 00:47:02',
            ),
            15 =>
            array(
                'id' => 17,
                'resourceable_type' => 'App\\Models\\Submodul',
                'resourceable_id' => 15,
                'path' => 'https://www.youtube.com/embed/P09gBP0swlA',
                'type' => 'video_link',
                'mime_type' => NULL,
                'size' => NULL,
                'original_name' => NULL,
                'user_id' => NULL,
                'created_at' => '2026-04-23 00:49:00',
                'updated_at' => '2026-04-23 00:49:00',
            ),
        ));
    }
}
