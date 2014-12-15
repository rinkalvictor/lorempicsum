<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model {

	protected $fillable = ['name', 'slug', 'description', 'views', 'likes', 'approved', 'allow_download', 'downloads', 'url', 'large_url', 'source_id', 'copyright', 'site', 'width', 'height', 'downloaded_locally', 'type'];


	protected $dates = ['deleted_at'];

	protected $softDelete = true;

	public $autoPurgeRedundantAttributes = true;

}
