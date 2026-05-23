<?php

     //Formatear fecha getFecha() - me devuelve una fecha en formato dd/mm/aaaa

use Carbon\Carbon;

    if(!function_exists('getFecha')){
        function getFecha($date){
            //Carbon libreria para formatear fechas
            return Carbon::parse($date)->format('d/m/y');
        }
    }

      //Formatear monedas getMoney() - me pone la cifra en formato euros 
     if(!function_exists('getMoney')){
        function getMoney($value){
            return number_format($value,2,',','.').' EUR';
        }
    }

    

   


   

  

 


