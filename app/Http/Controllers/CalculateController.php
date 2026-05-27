<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculateController extends Controller
{
    function add(){
    $a = 1;
    $b = 2;
    $sum = $a + $b;
    return "this is ur sum ".$sum;
    }

    function subtract(){
    $a = 1;
    $b = 2;
    $diff = $a - $b;
    return "this is ur diff ".$diff;
    }

    function divide(){
    $a = 1;
    $b = 2;
    $quo= $a / $b;
    return "this is ur quotient ".$quo;
    }

    function multiply(){
    $a = 1;
    $b = 2;
    $prod = $a * $b;
    return "this is ur product ".$prod;
    }

    function modulo(){
    $a = 1;
    $b = 2;
    $mod = $a % $b;
    return "this is ur modulo ".$mod;
    }
}
