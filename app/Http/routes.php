<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

/*
|--------------------------------------------------------------------------
| Authentication & Password Reset Controllers
|--------------------------------------------------------------------------
|
| These two controllers handle the authentication of the users of your
| application, as well as the functions necessary for resetting the
| passwords for your users. You may modify or remove these files.
|
*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

	use App\Picture;

	Route::get('/{width}/{height}/{options?}', function($width = 300, $height = 200, $options = null)
	{
		$params = array();
		if(isset($options)){
			foreach (explode('/',$options) as $pair)
			{
				list ($k,$v) = explode (':',$pair);
				$params[$k] = $v;
			}
		}


		$img = Image::cache(function($image) use ($width,$height,$params) {

			$file = 'foo.jpg';
			if(isset($params['id']) && is_int(intval($params['id']))){
				$picture = Picture::find($params['id']);
				$file = 'images/'.$picture->site.'/'.$picture->id.'_small.jpg';
			}
			$newImg = $image->make($file)->fit($width, $height);

			$newImg->interlace();

			if(isset($params['grey']) && $params['grey']=='yes'){
				$newImg->greyscale();
			}

			if(isset($params['blur'])){
				$blurOptions = explode ('|',$params['blur']);
				if($blurOptions[0]=='yes'){
					if(isset($blurOptions[1]) && is_int(intval($blurOptions[1]))){
						$blur = intval($blurOptions[1]);
					}else{
						$blur = 1;
					}
					$newImg->blur($blur);
				}
			}
			if(isset($params['sharpen'])){
				$sharpenOptions = explode ('|',$params['sharpen']);
				if($sharpenOptions[0]=='yes'){
					if(isset($sharpenOptions[1]) && is_int(intval($sharpenOptions[1]))){
						$sharpen = intval($sharpenOptions[1]);
					}else{
						$sharpen = 10;
					}
					$newImg->sharpen($sharpen);
				}
			}

			if(isset($params['pixelate'])){
				$pixelateOptions = explode ('|',$params['pixelate']);
				if($pixelateOptions[0]=='yes'){
					if(isset($pixelateOptions[1]) && is_int(intval($pixelateOptions[1]))){
						$pixelate = intval($pixelateOptions[1]);
					}else{
						$pixelate = 2;
					}
					$newImg->pixelate($pixelate);
				}
			}

			if(isset($params['invert']) && $params['invert']=='yes'){
				$newImg->invert();
			}
			return $newImg;

		});


		return Response::make($img,200,array('Content-Type'=>'image/jpeg'));

	})->where(['width' => '[0-9]+', 'height' => '[0-9]+', 'options' => '.*']);

	Route::get('/temp',function(){
		$myfile = public_path().'/images/unsplash/1121213.jpg';
		if (File::exists($myfile))
		{
			echo 'exists';
		}else{
			echo 'not';
		}
		//$affectedRows = Picture::whereIn('id', $downloadedPictures)->update(array('downloaded_locally' => 1));
		//print_r($affectedRows);
	});

