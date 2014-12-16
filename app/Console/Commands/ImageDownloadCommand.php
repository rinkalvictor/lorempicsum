<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Picture;

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
		$pictures = Picture::all(array('id','large_url','site'))->where('downloaded_locally',0);
		foreach($pictures as $picture){
			$filename = public_path().'/images/'.$picture->site.'/'.$picture->id.'.jpg';
			file_put_contents($filename,file_get_contents($picture->large_url));
			$filename = null;
		}
	}
}
