<?php

namespace VolleyballLiga\Cron;

use Contao\File;
use Contao\ModuleModel;
use Contao\System;

class VolleyballLigaCron
{
    public function run()
    {
        $objModule = ModuleModel::findBy('type', 'volleyball_liga_tabelle');
        if ($objModule) {
            while ($objModule->next()) {
                $strFileUrl = $objModule->volleyball_liga_liga . 'xml/rankings.xhtml?apiKey=' . $GLOBALS['TL_CONFIG']['volleyball_liga_key'] . '&matchSeriesId=' . $objModule->volleyball_liga_runde;
                $strContent = file_get_contents($strFileUrl);
                if (!preg_match('/\<\!DOCTYPE HTML PUBLIC/', $strContent)) {
                    $objFile = new File('/system/modules/volleyball-liga/assets/cache/' . $objModule->volleyball_liga_runde . '-tabelle.xml');
                    $objFile->write($strContent);
                }
            }
        }

        $objModule = ModuleModel::findBy('type', 'volleyball_liga_spielplan');
        if ($objModule) {
            while ($objModule->next()) {
                $strFileUrl = $objModule->volleyball_liga_liga . 'xml/matches.xhtml?apiKey=' . $GLOBALS['TL_CONFIG']['volleyball_liga_key'] . '&matchSeriesId=' . $objModule->volleyball_liga_runde;
                $strContent = file_get_contents($strFileUrl);
                if (!preg_match('/\<\!DOCTYPE HTML PUBLIC/', $strContent)) {
                    $objFile = new File('/system/modules/volleyball-liga/assets/cache/' . $objModule->volleyball_liga_runde . '-spielplan.xml');
                    $objFile->write($strContent);
                }
            }
        }
        System::log('Update der Tabellen und Spielpläne', 'VolleyballLigaCron run()', TL_CRON);
    }
}