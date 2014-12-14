<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {

	protected $fillable = ['url', 'large_url', 'source_id', 'copyright', 'site', 'width', 'height'];


}
