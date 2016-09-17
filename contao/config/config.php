<?php

/**
 * FRONT END MODULES
 *
 * Front end modules are stored in a global array called "FE_MOD". You can add
 * your own modules by adding them to the array.
 */
array_insert ( $GLOBALS ['FE_MOD'] ['volleyball_liga'], 1, array (
		'volleyball_liga_tabelle' => 'VolleyballLiga\ModuleVolleyballLigaTabelle',
		'volleyball_liga_spielplan' => 'VolleyballLiga\ModuleVolleyballLigaSpielplan'
) );

/**
 * CRON JOBS
 *
 * Cron jobs are stored in a global array called "TL_CRON". You can add your own
 * cron jobs by adding them to the array.
 *
 * $GLOBALS['TL_CRON'] = array
 * (
 * 'monthly' => array
 * (
 * array('Automator', 'purgeImageCache')
 * ),
 * 'weekly' => array(),
 * 'daily' => array(),
 * 'hourly' => array(),
 * 'minutely' => array()
 * );
 *
 * Note that this is rather a command scheduler than a cron job, which does not
 * guarantee an exact execution time. You can replace the command scheduler with
 * a real cron job though.
 */
$GLOBALS['TL_CRON']['hourly'][] = array('VolleyballLiga\Cron\VolleyballLigaCron', 'run');
