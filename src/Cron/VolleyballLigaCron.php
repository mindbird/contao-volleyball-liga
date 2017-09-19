<?php

namespace VolleyballLiga\Cron;

use Contao\File;
use Contao\ModuleModel;
use Contao\System;

class VolleyballLigaCron
{
    public function run()
    {
        $modules = ModuleModel::findBy('type', 'volleyball_liga_tabelle');
        if ($modules) {
            while ($modules->next()) {
                $fileUrl = $modules->volleyball_liga_liga . 'xml/rankings.xhtml?apiKey=' . $GLOBALS['TL_CONFIG']['volleyball_liga_key'] . '&matchSeriesId=' . $modules->volleyball_liga_runde;
                $content = file_get_contents($fileUrl);
                if (!preg_match('/\<\!DOCTYPE HTML PUBLIC/', $content)) {
                    File::putContent('/system/modules/volleyball-liga/assets/cache/' . $modules->volleyball_liga_runde . '-tabelle.xml', $content);
                }
            }
        }

        $modules = ModuleModel::findBy('type', 'volleyball_liga_spielplan');
        if ($modules) {
            while ($modules->next()) {
                $fileUrl = $modules->volleyball_liga_liga . 'xml/matches.xhtml?apiKey=' . $GLOBALS['TL_CONFIG']['volleyball_liga_key'] . '&matchSeriesId=' . $modules->volleyball_liga_runde;
                $content = file_get_contents($fileUrl);
                if (!preg_match('/\<\!DOCTYPE HTML PUBLIC/', $content)) {
                    File::putContent('/system/modules/volleyball-liga/assets/cache/' . $modules->volleyball_liga_runde . '-spielplan.xml', $content);
                }
            }
        }
        System::log('Update der Tabellen und Spielpläne', 'VolleyballLigaCron run()', TL_CRON);
    }
}