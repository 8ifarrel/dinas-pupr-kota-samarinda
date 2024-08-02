<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasiDiagram extends Model
{
    use HasFactory;

    protected $table = 'struktur_organisasi_diagram';

	protected $primaryKey = 'id_struktur_organisasi_diagram';

	protected $fillable = [
		'diagram_struktur_organisasi',
		'id_struktur_organisasi'
	];
}
