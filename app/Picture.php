<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model {

	protected $fillable = ['url', 'large_url', 'source_id', 'copyright', 'site', 'width', 'height', 'downloaded'];

	protected $dates = ['deleted_at'];

	protected $softDelete = true;

	public $autoPurgeRedundantAttributes = true;

}
