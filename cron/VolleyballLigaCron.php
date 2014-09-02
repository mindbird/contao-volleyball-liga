<?php

namespace VolleyballLiga;

class VolleyballLigaCron extends \CronJob {
	public function run() {
		$objModule = \ModuleModel::findBy('type', 'volleyball_liga_tabelle');
		if ($objModule) {
			while ($objModule->next()) {
				$strFileUrl = $objModule->volleyball_liga_liga . 'xml/rankings.xhtml?apiKey=' . $GLOBALS['TL_CONFIG']['volleyball_liga_key'] . '&matchSeriesId=' . $objModule->volleyball_liga_runde;
				$strContent = file_get_contents ( $strFileUrl );
				$objFile = new \File('/system/modules/vVolleyball-liga/assets/cache/' . $objModule->volleyball_liga_runde . '-tabelle.xml');
				$objFile->write($strContent);				
			}
		}
		
		$objModule = \ModuleModel::findBy('type', 'volleyball_liga_spielplan');
		if ($objModule) {
			while ($objModule->next()) {
				print $strFileUrl = $objModule->volleyball_liga_liga . 'xml/matches.xhtml?apiKey=' . $GLOBALS['TL_CONFIG']['volleyball_liga_key'] . '&matchSeriesId=' . $objModule->volleyball_liga_runde;
				$strContent = file_get_contents ( $strFileUrl );
				$objFile = new \File('/system/modules/volleyball-liga/assets/cache/' . $objModule->volleyball_liga_runde . '-spielplan.xml');
				$objFile->write($strContent);
			}
		}
		$this->log('Update der Tabellen und Spielpläne', 'VolleyballLigaCron run()', TL_CRON);
	}
}