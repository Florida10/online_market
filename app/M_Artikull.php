<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Artikull extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artikull';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'emer', 'pershkrimi', 'cmimi', 'njesia', 'ne_oferte', 'ulje', 'cmimi_oferte', 'stock', 'sektor'
    ];
}
