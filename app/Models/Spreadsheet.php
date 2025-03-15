<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spreadsheet extends Model
{
  // Desabilitar o uso de timestamps
  public $timestamps = false;
  protected $table = 'spreadsheet';
  protected $fillable = [
    'rm_student',
    'rm_teacher',
    'note1',
    'note2',
    'note3',
    'note4',
    'note5',
    'note6',
    'finalnote'
  ];
}
