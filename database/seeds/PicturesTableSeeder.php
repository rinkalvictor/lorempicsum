<?php

	use Illuminate\Database\Seeder;
	use \App\Picture;
	use Buzz\Buzz;
	use Illuminate\Support\Facades\File;
	use Intervention\Image\Facades\Image;

	class PicturesTableSeeder extends Seeder {

		public function run()
		{
			$base_url = 'http://www.splashbase.co/api/v1/images/';
			$pictureCount = Picture::all()->count();
			$continue = true;
			$number = $pictureCount + 1;
			while ($continue) {
				$response = Buzz::get($base_url . $number);
				$responseArr = json_decode($response->getContent());

				if (!isset($responseArr->message)) {

//					if ($responseArr->large_url != "")
//						$imageUrl = $responseArr->large_url;
//					else
//						$imageUrl = $responseArr->url;
//					if(!in_array($responseArr->site, $directories)){
//						if (!File::exists(public_path() . '/images/' . $responseArr->site)) {
//							File::makeDirectory(public_path() . '/images/' . $responseArr->site, 0775);
//							$directories[] = $responseArr->site;
//						}
//					}
//					$imagePath = public_path() . '/images/unsplash/' . $number . '.jpeg';
//					if (!File::exists($imagePath)) {
//						copy($imageUrl,$imagePath);
//					}
//
//					$width = Image::make($imagePath)->width();
//					$height = Image::make($imagePath)->height();
					$width = null;
					$height = null;
					$picture = array(
						'url'       => $responseArr->url,
						'large_url' => $responseArr->large_url,
						'source_id' => $number,
						'copyright' => $responseArr->copyright,
						'site'      => $responseArr->site,
						'width'     => $width,
						'height'    => $height
					);
					Picture::create($picture);

				} else {
					$continue = false;
				}
				$response = null;
				$responseArr = null;
				$number ++;
			}
		}

	}