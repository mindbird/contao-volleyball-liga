<?php

/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'VolleyballLiga',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'VolleyballLiga\VolleyballLigaCron'       		=> 'system/modules/volleyball-liga/cron/VolleyballLigaCron.php',
	'VolleyballLiga\ModuleVolleyballLigaSpielplan'	=> 'system/modules/volleyball-liga/modules/ModuleVolleyballLigaSpielplan.php',
	'VolleyballLiga\ModuleVolleyballLigaTabelle'	=> 'system/modules/volleyball-liga/modules/ModuleVolleyballLigaTabelle.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_volleyball_liga_spielplan' => 'system/modules/volleyball-liga/templates',
	'volleyball_liga_spielplan_tabellenzeile' => 'system/modules/volleyball-liga/templates',
	'mod_volleyball_liga_tabelle' => 'system/modules/volleyball-liga/templates',
	'volleyball_liga_tabelle_tabellenzeile' => 'system/modules/volleyball-liga/templates',
));
