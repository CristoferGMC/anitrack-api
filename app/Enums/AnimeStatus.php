<?php

namespace App\Enums;

enum AnimeStatus: string
{
    case SIGUIENDO = 'siguiendo';
    case PENDIENTE = 'pendiente';
    case FINALIZADO = 'finalizado';
    case FAVORITO = 'favorito';
    //como es una api no nesesito los metodos de label o values
}
