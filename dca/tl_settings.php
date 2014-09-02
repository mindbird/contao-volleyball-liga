<?php

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{volleyball_liga_legend:hide},volleyball_liga_key';

$GLOBALS['TL_DCA']['tl_settings']['fields']['volleyball_liga_key'] = array
(
		'label'     => &$GLOBALS['TL_LANG']['tl_settings']['volleyball_liga_key'],
		'inputType' => 'text',
		'eval'      => array('tl_class' => 'w50'),		
);