<?php

//define("MAJOR", 'pounds');
//define("MINOR", 'p');
class toWords
{
    var $pounds;
    var $pence;
    var $major;
    var $minor;
    var $words = '';
    var $number;
    var $magind;
    var $units = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine');
    var $teens = array('ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');
    var $tens = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety');
    var $mag = array('', 'thousand', 'million', 'billion', 'trillion');

    function toWords($amount, $major, $minor)
    {
        $this->major  = $major;
        $this->minor  = $minor;
        $this->number = number_format($amount, 2);
        list($this->pounds, $this->pence) = explode('.', $this->number);
        //$this->words = " $this->major $this->pence $this->minor";
        $this->words = " $this->major ";
        if ($this->pounds == 0)
            $this->words = "Zero $this->words";
        else {
            $groups = explode(',', $this->pounds);
            $groups = array_reverse($groups);
            for ($this->magind = 0; $this->magind < count($groups); $this->magind++) {
                if (($this->magind == 1) && (strpos($this->words, 'hundred') === false) && ($groups[0] != '000'))
                    $this->words = ' and ' . $this->words;
                $this->words = $this->_build($groups[$this->magind]) . $this->words;
            }
        }
    }

    function _build($n)
    {
        $res = '';
        $na  = str_pad("$n", 3, "0", STR_PAD_LEFT);
        if ($na == '000')
            return '';
        if ($na[0] != 0)
            $res = ' ' . $this->units[$na[0]] . ' hundred';
        if (($na[1] == '0') && ($na[2] == '0'))
            return $res . ' ' . $this->mag[$this->magind];
        $res .= $res == '' ? '' : ' and';
        $t = (int) $na[1];
        $u = (int) $na[2];
        switch ($t) {
            case 0:
                $res .= ' ' . $this->units[$u];
                break;
            case 1:
                $res .= ' ' . $this->teens[$u];
                break;
            default:
                $res .= ' ' . $this->tens[$t] . ' ' . $this->units[$u];
                break;
        }
        $res .= ' ' . $this->mag[$this->magind];
        return $res;
    }
}

/*$amount = 6559350.45;
$obj    = new toWords(intval($amount), "Naira", "Kobo");
echo $obj->words; // gives Twelve thousand three hundred forty five pounds 67p
echo '<br/>';
echo $obj->number; // gives 12,345.67*/

?>