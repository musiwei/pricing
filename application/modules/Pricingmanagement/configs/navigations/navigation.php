<?php
return array(
		array(
				'label' => 'Dashboard',
		        'action' => 'index',
				'controller' => 'index',
		        'module' => 'Pricingmanagement',
		),
		array(
				'label' => 'My Account',
		        'action' => 'event',
				'controller' => 'account',
		        'module' => 'auth',
				'pages' => array(
				        array(
				        		'label' => 'Register',
				        		'action' => 'index',
				        		'controller' => 'register',
				        		'module' => 'auth'
				        ),

						array(
								'label' => 'Log in',
								'action' => 'index',
								'controller' => 'login',
						        'module' => 'auth',
								'class' => 'special-two',
								'title' => 'This element has a special class too'
						),
				        
				        array(
				        		'label' => 'Forgot password',
				        		'action' => 'forgot',
				        		'controller' => 'password',
				        		'module' => 'auth'
				        ),
				        
				        array(
				        		'label' => 'Log out',
				        		'action' => 'index',
				        		'controller' => 'logout',
				        		'module' => 'auth'
				        )
				)
		)
);