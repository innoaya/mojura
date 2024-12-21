<?php

namespace InnoAya\Mojura\Core;

use InnoAya\Mojura\Bus\ServesFeature;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller
{
    use ServesFeature, ValidatesRequests;
}
