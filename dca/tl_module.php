<?php
$GLOBALS ['TL_DCA'] ['tl_module'] ['palettes'] ['volleyball_liga_tabelle'] = '{title_legend},name,headline,type;{volleyball_liga_legend},volleyball_liga_liga,volleyball_liga_saison,volleyball_liga_runde,volleyball_liga_mannschaft;{protected_legend:hide},protected;
{expert_legend:hide},guests,cssID,space';

$GLOBALS ['TL_DCA'] ['tl_module'] ['palettes'] ['volleyball_liga_spielplan'] = '{title_legend},name,headline,type;{volleyball_liga_legend},volleyball_liga_liga,volleyball_liga_saison,volleyball_liga_runde,volleyball_liga_mannschaft;{protected_legend:hide},protected;
{expert_legend:hide},guests,cssID,space';

$GLOBALS ['TL_DCA'] ['tl_module'] ['fields'] ['volleyball_liga_liga'] = array (
		'label' => &$GLOBALS ['TL_LANG'] ['tl_module'] ['volleyball_liga_liga'],
		'exclude' => true,
		'inputType' => 'select',
		'eval' => array (
				'mandatory' => true,
				'tl_class' => 'clr',
				'includeBlankOption' => true,
				'submitOnChange' => true 
		),
		'sql' => "varchar(255) NOT NULL default ''",
		'options' => array (
				'https://www.volleyball-bundesliga.de/' => '1./2. Bundesliga',
				'http://dvv.sams-server.de/' => '3. Bundesliga' 
		) 
);

$GLOBALS ['TL_DCA'] ['tl_module'] ['fields'] ['volleyball_liga_saison'] = array (
		'label' => &$GLOBALS ['TL_LANG'] ['tl_module'] ['volleyball_liga_saison'],
		'exclude' => true,
		'inputType' => 'select',
		'eval' => array (
				'mandatory' => true,
				'tl_class' => 'clr',
				'includeBlankOption' => true,
				'submitOnChange' => true 
		),
		'sql' => "varchar(255) NOT NULL default ''",
		'options_callback' => array (
				'tl_module_volleyball_liga',
				'getSaison' 
		) 
)
;
$GLOBALS ['TL_DCA'] ['tl_module'] ['fields'] ['volleyball_liga_runde'] = array (
		'label' => &$GLOBALS ['TL_LANG'] ['tl_module'] ['volleyball_liga_runde'],
		'exclude' => true,
		'inputType' => 'select',
		'eval' => array (
				'mandatory' => true,
				'tl_class' => 'clr',
				'includeBlankOption' => true,
				'submitOnChange' => true 
		),
		'sql' => "varchar(255) NOT NULL default ''",
		'options_callback' => array (
				'tl_module_volleyball_liga',
				'getRunde' 
		) 
)
;

$GLOBALS ['TL_DCA'] ['tl_module'] ['fields'] ['volleyball_liga_mannschaft'] = array (
		'label' => &$GLOBALS ['TL_LANG'] ['tl_module'] ['volleyball_liga_mannschaft'],
		'exclude' => true,
		'inputType' => 'select',
		'eval' => array (
				'mandatory' => true,
				'tl_class' => 'clr',
				'includeBlankOption' => true,
				'submitOnChange' => true
		),
		'sql' => "varchar(255) NOT NULL default ''",
		'options_callback' => array (
				'tl_module_volleyball_liga',
				'getMannschaft'
		)
)
;
class tl_module_volleyball_liga extends Backend {
	public function getSaison($objDC) {
		$strFileUrl = $objDC->activeRecord->volleyball_liga_liga . '/xml/seasons.xhtml?apiKey=' . $GLOBALS['TL_CONFIG']['volleyball_liga_key'];
		$strContent = file_get_contents ( $strFileUrl );
		$objXML = new SimpleXMLElement ( $strContent );
		$arrSeason = array ();
		foreach ( $objXML->season as $objSeason ) {
			$intID = ( int ) $objSeason->id;
			$arrSeason [$intID] = $objSeason->name;
		}
		return $arrSeason;
	}
	public function getRunde($objDC) {
		$strFileUrl = $objDC->activeRecord->volleyball_liga_liga . '/xml/matchSeries.xhtml?apiKey=' . $GLOBALS['TL_CONFIG']['volleyball_liga_key'] . '&seasonId=' . $objDC->activeRecord->volleyball_liga_saison;
		$strContent = file_get_contents ( $strFileUrl );
		$objXML = new SimpleXMLElement ( $strContent );
		if ($objXML != 'Invalid API-Key') {
			$arrRunde = array ();
			foreach ( $objXML->matchSeries as $objMatchSeries ) {
				$intID = ( int ) $objMatchSeries->id;
				$arrRunde [$intID] = $objMatchSeries->name;
			}
		} else {
			$arrRunde = array (
					'Ihr API-Key ist nicht berechtigt für diese Liga.' 
			);
		}
		return $arrRunde;
	}
	
	public function getMannschaft($objDC) {
		$strFileUrl = $objDC->activeRecord->volleyball_liga_liga . '/xml/teams.xhtml?apiKey=' . $GLOBALS['TL_CONFIG']['volleyball_liga_key'] . '&matchSeriesId=' . $objDC->activeRecord->volleyball_liga_runde;
		$strContent = file_get_contents ( $strFileUrl );
		$objXML = new SimpleXMLElement ( $strContent );
		if ($objXML != 'Invalid API-Key') {
			$arrTeam = array ();
			foreach ( $objXML->team as $objTeam ) {
				$intID = ( int ) $objTeam->id;
				$arrTeam [$intID] = $objTeam->name;
			}
		} else {
			$arrTeam = array (
					'Ihr API-Key ist nicht berechtigt für diese Liga.'
			);
		}
		return $arrTeam;
	}
}

?>