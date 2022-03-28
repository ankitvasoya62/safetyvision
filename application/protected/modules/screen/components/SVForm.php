<?php

class SVForm extends CComponent {

    /**
     *************************************************************************** 
     * OnlineInfo Sysyem DropDown List
     * 
     * Create the Dropdown like this:
     * @param:identifier, field name <select name='identifier'></select>
     * @param:pairs, options values array('value'=>'text')
     * @param:firsttentry, default value like 'please selete the types'
     * @param:multiple, open or close multiple, default close
     * @param:class, set the html style for this dropdown list
     * @param:key, create null, update set default value
     * 
     * Author: <lih@shinetechchina.com>
     * Date: 2013-06-06
     * 
     *************************************************************************** 
     **/
    public static function ois_dropdown($identifier = '', $pairs = array(), $firsttentry = '', $key = '1', $class = '', $multiple = '') {
        if (!empty($multiple)) {
            $dropdown = "<select name=\"$identifier\" class=\"$class\" multiple=\"$multiple\" >";
        } else {
            $dropdown = "<select name=\"$identifier\" class=\"$class\" >";
        }
        if ($firsttentry) {
            $dropdown .= "<option value=\"\">$firsttentry</option>";
        }
        foreach ($pairs as $value => $name) {
            if (is_array($key)) {
                if (in_array($value, $key)) {
                    $dropdown .= "<option value=\"$value\" selected=\"selected\">$name</option>";
                } else {
                    $dropdown .= "<option value=\"$value\">$name</option>";
                }
            } else {
                $dropdown .= ($value == $key) ?
                        "<option value=\"$value\" selected=\"selected\">$name</option>" :
                        "<option value=\"$value\">$name</option>";
            }
        }
        $dropdown .= "</select>";
        return $dropdown;
    }

}
