<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

function tableNameFromModel(string|Model $model): string
{
    return Str::snake(Str::pluralStudly(class_basename($model)));
}
