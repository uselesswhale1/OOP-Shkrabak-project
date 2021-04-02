<?php
$methods = [
	'submitAmbassador' => [
		'params' => [
			[
				'name' => 'firstname',
				'source' => 'p',
				'pattern' => 'surname',
				'required' => true #обязательный параметр
			],
			[
				'name' => 'secondname',
				'source' => 'p',
				'pattern' => 'surname',
				'required' => true
			],
			[
				'name' => 'position',
				'source' => 'p',
				'default' => '',
				'required' => false 
			],
			[
				'name' => 'phone',
				'source' => 'p',
				'pattern' => 'phone-UA',
				'required' => true 
			],
		]
	]
];