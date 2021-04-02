<?php
$patterns = [ 

    'phone-UA' => [ 
        'regex' =>  '/^[5-9][0-9]{8}$/', # [5-9] X XXX-XX-XX 
        'callback' => function($matches) {
            printme($matches);
            return '+380'.$matches[0]; # +380[5-9] X XXX-XX-XX 
        }
    ],

    'surname' => [
        'regex' => '/^([A-Z]{1}[a-z]{1,23})$/'
    ]
    
];



    
        
        


    