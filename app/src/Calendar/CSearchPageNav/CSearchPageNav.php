<?php
/**
 * 
 * 
 * @author Rikard Karlsson
 * @version 14-04-25
 */
class CSearchPageNav {
    private $db;
    private $radioHitsPerPageMenu;
    private $sql;
    private $params;
    private $radioSelectPageMenu;
    private $countColumnName;
    
    public function __construct($db, $arrayNoHitsPerPage, 
            $tableSql, $arrayParams, $countColumnName) {
        $this->db = $db;
        $this->countColumnName = $countColumnName;
        $this->radioHitsPerPageMenu = new CFormRadioNav();
        foreach ($arrayNoHitsPerPage as $noHitsPerPage) {
            $this->radioHitsPerPageMenu->addItem(array($noHitsPerPage, $noHitsPerPage, true));
        }
        $this->sql = $tableSql;
        $this->params = $arrayParams;
        $totalNoHits = $this->getTotalNoHits();
        $noHitsPerPage = $this->getNoHitsPerPage();
        $lastPageNo = ceil($totalNoHits / $noHitsPerPage);        
        $this->radioSelectPageMenu = new CFormRadioNav();
        
        for ( $i = 1; $i <= $lastPageNo; ++$i){
            $this->radioSelectPageMenu->addItem(array($i));
        }
        
    }
    public function getHtmlSelectNoHitsPerPage() {
        $html = "" . $this->getTotalNoHits() . " träffar ";
        $html .= $this->radioHitsPerPageMenu->getHtml();
        return $html;
    }
    public function getHtmlSelectPageNo() {
        return $this->radioSelectPageMenu->getNavHtml();
    }
    /**
     * Number of rows to display.
     */
    private function getNoHitsPerPage() {
        return $this->radioHitsPerPageMenu->getCheckedLabelValue();
    }
    private function getTotalNoHits() {
        $sql = "SELECT COUNT(" . $this->countColumnName . ") AS noRows FROM (" . 
                $this->sql . ") ThisTable"; 
        $res3 = $this->db->ExecuteSelectQueryAndFetchAll($sql, $this->params);
        //dump($res3);
        // Max pages in the table: SELECT COUNT(id) AS rows FROM VSeed
        $totalNoHits = $res3[0]->noRows;
        return $totalNoHits;
    }
    private function getCurrentPageNo() {
        return $this->radioSelectPageMenu->getCheckedLabelValue();
    }
    public function getDbPageObject() {
        $noHitsPerPage = $this->getNoHitsPerPage();
        //dump($noHitsPerPage, "noHitsPerPage");
        $currentPageNo = $this->getCurrentPageNo();
        //dump($currentPageNo, "currentPageNo");
        $sql = $this->sql;
        $sql.= " LIMIT {$noHitsPerPage} OFFSET " . 
        (($currentPageNo -1) * $noHitsPerPage) .";"; 
        //dump($sql);
        //dump($this->params);
        return $this->db->ExecuteSelectQueryAndFetchAll($sql,$this->params);
    }
}
