<?php

namespace VolleyballLiga;

use Contao\Module;

class ModuleVolleyballLigaTabelle extends Module {
	
	/**
	 * Template
	 *
	 * @var string
	 */
	protected $strTemplate = 'mod_volleyball_liga_tabelle';
	
	/**
	 * Template Tabellenzeile
	 *
	 * @var string
	 */
	protected $strTemplateTabellenzeile = 'volleyball_liga_tabelle_tabellenzeile';
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \Contao\Module::generate()
	 */
	public function generate() {
		if (TL_MODE == 'BE') {
			$objTemplate = new \BackendTemplate ( 'be_wildcard' );
				
			$objTemplate->wildcard = '### VOLLEYBALL LIGA - TABELLE ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
				
			return $objTemplate->parse ();
		}
		$GLOBALS['TL_CSS'][] = '/system/modules/volleyball-liga/assets/css/volleyball-liga.css|all';
		
		return parent::generate ();
	}
	
	/**
	 * Generate the module
	 */
	protected function compile() {
		$strFile = 'system/modules/volleyball-liga/assets/cache/' . $this->volleyball_liga_runde . '-tabelle.xml';
		$objXML = new \SimpleXmlElement(file_get_contents($strFile));
		$strHTML = '';
		foreach ($objXML->ranking as $objRanking) {
				$objTemplate = new \FrontendTemplate($this->strTemplateTabellenzeile);
				$objTemplate->strName = $objRanking->team->name;
				$objTemplate->strPlatz = $objRanking->place;
				$objTemplate->strSpiele = $objRanking->matchesPlayed;
				$objTemplate->str3031 = $objRanking->resultTypes->matchResult[0]->count + $objRanking->resultTypes->matchResult[1]->count;
				$objTemplate->str32 = $objRanking->resultTypes->matchResult[2]->count;
				$objTemplate->str23 = $objRanking->resultTypes->matchResult[3]->count;
				$objTemplate->str1303 = $objRanking->resultTypes->matchResult[4]->count + $objRanking->resultTypes->matchResult[5]->count;
				$objTemplate->strSaetze = $objRanking->setPoints;
				$objTemplate->strBaelle = $objRanking->ballPoints;
				$objTemplate->strPunkte = $objRanking->points;
				if ($objRanking->team->id == $this->volleyball_liga_mannschaft) {
					$objTemplate->strClass = 'heimmannschaft';
				}
				$strHTML .= $objTemplate->parse();
		}
		$this->Template->strHTML = $strHTML;
	}
}