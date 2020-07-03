<?php

namespace Autocars\Tours\ViewHelpers;

class SysfileTakerViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @param int $uid
     * @param int $limit
     * @return string
     */
    public function render($uid, $limit = -1)
    {
        if (!is_int($uid)) {
            return '';
        }

        $result = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
            'sf.identifier',
            'sys_file as sf JOIN sys_file_reference as sfr on sfr.uid=' . $uid,
            'sfr.uid_local = sf.uid AND sfr.deleted != 1 ',
            '',
            '',
            $limit == -1 ? '' : $limit
        );
 

        $rows = array();
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)) {
            $rows[] = $row['identifier'];
        }
        $GLOBALS['TYPO3_DB']->sql_free_result($result);


        if ($limit == 1) {
            return $rows[0];
        }
        return $rows;
    }
}
