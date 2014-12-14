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

use \App\Picture;

	Route::get('/test/{width?}/{height?}', function($width = 300, $height = 200)
	{
		$img = Image::cache(function($image) use ($width,$height) {
			return $image->make('foo.jpg')->fit($width, $height);
		});

		return Response::make($img,200,array('Content-Type'=>'image/jpeg'));

	})->where(['width' => '[0-9]+', 'height' => '[0-9]+']);

	Route::get('/downloadpics',function(){
		$base_url      = 'http://www.splashbase.co/api/v1/images/';
		foreach (range(1, 3) as $number) {
			$response = Buzz::get($base_url.$number);
			$responseArr = json_decode($response->getContent());
//			echo '<pre>';
//			print_r($responseArr);
//			echo '</pre>';
			if($responseArr->large_url!="")
				$imageUrl = $responseArr->large_url;
			else
				$imageUrl = $responseArr->url;
			if (!File::exists(public_path().'/images/'.$responseArr->site))
			{
				File::makeDirectory(public_path().'/images/'.$responseArr->site, 0775);
			}
			if (!File::exists(public_path().'/images/unsplash/'.$number.'.jpeg'))
			{
				copy($imageUrl, public_path().'/images/unsplash/'.$number.'.jpeg');
			}
			$width = Image::make(public_path().'/images/unsplash/'.$number.'.jpeg')->width();
			$height = Image::make(public_path().'/images/unsplash/'.$number.'.jpeg')->height();
			echo $width.'X'.$height.'<br/>';
			//copy($responseArr->large_url, public_path().'/images/unsplash/'.$number.'.jpeg');
			if(isset($responseArr->message))
				echo '<br/>'.$responseArr->message.'<br/>';
		}
	});