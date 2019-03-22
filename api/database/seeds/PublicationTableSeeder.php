<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Photo;
use App\Publication;
use App\Publication_Photo;
use App\Publication_Reaction;

class PublicationTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $avatar = new LasseRafn\InitialAvatarGenerator\InitialAvatar();
        $faker = Faker\Factory::create();

        $users = User::get()->toArray();
        if (sizeof($users)) {
            for ($i = 0; $i < sizeof($users); $i++) {
                $user = $users[$i];
                $faker = Faker\Factory::create();
                $Publication = Publication::firstOrCreate([
                            "ids" => sha1(uniqid(rand(), true)),
                            "description" => $faker->text(),
                            "geolocation" => $faker->city,
                            "User_id" => $user["id"]
                ]);
                if ($Publication) {
                    // Generation of images
                    for ($a = 0; $a < 3; $a++) {
                        $file_name = "demo_pics/photos_" . $Publication->ids . ".png";
                        $image = $avatar->name(uniqid() . " " . uniqid())->generate()->save(public_path() . "/" . $file_name);
                        if ($image) {
                            $hash = sha1_file(public_path() . "/" . $file_name);
                            $Photo = Photo::create([
                                        "local_uri" => $file_name,
                                        "fingerprint" => $hash
                            ]);
                            if ($Photo) {
                                try {
                                    Publication_Photo::create([
                                        "Publication_id" => $Publication->id,
                                        "Photo_id" => $Photo->id,
                                        "order" => $a
                                    ]);
                                } catch (Exception $e) {
                                    echo "Failed to link image to publication : " . $e->getMessage() . " .\n";
                                }
                            } else {
                                echo "Failed to generate image.\n";
                            }
                        }
                    }
                } else {
                    echo "Failed to generate publication.\n";
                }
            }
        }
    }

    function random_pic($dir = 'uploads') {
        $files = glob($dir . '/*.*');
        $file = array_rand($files);
        return $files[$file];
    }

}
