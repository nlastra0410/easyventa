<?php

// Devuelve el Id del usuario que ingresa
function userID(){
    return auth()->user()->id;
}

// Número en formato moneda
function money($number){
    // Convertir $number a tipo float si es una cadena de texto
    $number = floatval($number);
    
    // Formatear el número y devolverlo
    return '$' . number_format($number, 0, ',', '.');
}

function moneyN($number){
    // Convertir $number a tipo float si es una cadena de texto
    $number = floatval($number);
    
    // Formatear el número y devolverlo
    return '-$' . number_format($number, 0, ',', '.');
}
function nume($number){
    return number_format($number,0,',','.');
}

// Convertir números a letras 

function numerosLetras($number){
    return App\Models\NumerosEnLetras::convertir($number,'Pesos',false,'Centavos');
}
