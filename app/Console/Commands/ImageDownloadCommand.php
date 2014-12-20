<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Picture;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ImageDownloadCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:images';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Downloads images to associated folders from web.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$downloadedPictures = array_flatten(Picture::all(array('id','downloaded_locally'))->where('downloaded_locally',1)->lists('id'));

		$pictures = Picture::all(array('id','url','large_url','site','downloaded_locally'))->where('downloaded_locally',1);

		$downloaded = $downloadedPictures;
		$logFile = 'log-picturesDownloaded.txt';
		Log::useDailyFiles(storage_path().'/logs/'.$logFile);
		foreach($pictures as $picture){
			try{
				$filename = public_path().'/images/'.$picture->site.'/'.$picture->id.'.jpg';
				$filename_small = public_path().'/images/'.$picture->site.'/'.$picture->id.'_small.jpg';
				if (!File::exists($filename)){
					echo $picture->id;
					file_put_contents($filename,file_get_contents($picture->large_url));
					echo 'Downloaded'.PHP_EOL;
					$downloaded[]= $picture->id;
					$lastDownloaded = $picture->id;


					Log::info('Picture Downloaded::'.$picture->id,$downloaded);
				}
				if (!File::exists($filename_small)){
					echo $picture->id;
					file_put_contents($filename_small,file_get_contents($picture->url));
					echo 'Downloaded _small'.PHP_EOL;
					$downloaded[]= $picture->id;
					$lastDownloaded = $picture->id;


					Log::info('Picture Downloaded::'.$picture->id,$downloaded);
				}
				$filename = null;
			}catch  (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
				Log::info('Last Picture Downloaded::'.$lastDownloaded,$downloaded);
				Picture::whereIn('id', $downloaded)->update(array('downloaded_locally' => 1));
			}

		}

		Picture::whereIn('id', $downloaded)->update(array('downloaded_locally' => 1));
	}
}
