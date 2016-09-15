<?php

namespace VolleyballLiga;

use Contao\Module;

class ModuleVolleyballLigaSpielplan extends Module
{

    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'mod_volleyball_liga_spielplan';

    /**
     * Template Tabellenzeile
     *
     * @var string
     */
    protected $strTemplateTabellenzeile = 'volleyball_liga_spielplan_tabellenzeile';

    /**
     * (non-PHPdoc)
     *
     * @see \Contao\Module::generate()
     */
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            
            $objTemplate->wildcard = '### VOLLEYBALL LIGA - SPIELPLAN ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
            
            return $objTemplate->parse();
        }
        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $strFile = 'system/modules/volleyball-liga/assets/cache/' . $this->volleyball_liga_runde . '-spielplan.xml';
        $objXML = new \SimpleXmlElement(file_get_contents($strFile));
        $strHTML = '';
        foreach ($objXML->match as $objMatch) {
            if ($objMatch->team[0]->id == $this->volleyball_liga_mannschaft || $objMatch->team[1]->id == $this->volleyball_liga_mannschaft) {
                $objTemplate = new \FrontendTemplate($this->strTemplateTabellenzeile);
                $objTemplate->strDatum = $objMatch->date;
                $objTemplate->strUhrzeit = $objMatch->time;
                $objTemplate->strHeim = $objMatch->team[0]->name;
                $objTemplate->strGast = $objMatch->team[1]->name;
                $objTemplate->strHalle = $objMatch->location->name;
                $objTemplate->strHalleInfo = $objMatch->location->name . ',  ' . $objMatch->location->street . ', ' . $objMatch->location->postalCode . ' ' . $objMatch->location->city;
                if ($objMatch->results) {
                    $objTemplate->strErgebnis = $objMatch->results->setPoints . ' (' . $this->getSetPoints($objMatch->results->sets) . ')';
                    $objTemplate->strZuschauer = $objMatch->spectators;
                    $objTemplate->strDauer = $objMatch->netDuration;
                    if ($objMatch->results->winner == $this->volleyball_liga_mannschaft) {
                        $objTemplate->strClass = 'gewonnen';
                    }
                }
                $strHTML .= $objTemplate->parse();
            }
        }
        $this->Template->strHTML = $strHTML;
    }

    private function getSetPoints($objSets)
    {
        $arrPoints = array();
        foreach ($objSets->set as $objSet) {
            $arrPoints[] = $objSet->points;
        }
        return implode(', ', $arrPoints);
    }
}