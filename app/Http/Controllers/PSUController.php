<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PSUController extends Controller
{
    function welcome(){
        return "WElCOME<br>
        Welcome to PSU!   ".date("y-m-d");
    }

    function mission(){
        return "MISSION <br>
        The Pangasinan State University shall provide  a human-centric ,<br>
         resilient and sustainable academic environment to produce dynamic,<br>
         responsive and future-ready individuals capable of meeting the <br>
         requirements of he local and global communities and industries  ".date("y-m-d");
    }

    function vision(){
        return "VISION <br>
        To be a leading industry driven State University in ASEAN region by 2030   ".date("y-m-d");
    }

    function EOMSPolicy(){
        return "EOMS Policy <br>
        The Pangasinan State University shall be recognized as <br> 
        an ASEAN premier state university that provides quality education <br>
        and satisfactory service delivery through instruction, research, extension and production.<br> <br>
        We commit our expertise and resources to produce professionals <br>
        who meet the expectations of the industry and other interested <br>
        parties in the national and international community.

        We shall continuously improve our operations in response <br>
        to the changing environment and in support of the institution’s strategic direction.   ".date("y-m-d");
    }   

    public function student($name, $course){
        return "Student: " . $name . " | Course: " . $course;
    }
}
