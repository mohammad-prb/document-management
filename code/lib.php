<?php
/*      انگلیسی بودن    */
function englisiAst($str)
{
    if (preg_match("/[^A-Za-z0-9\:\(\)\-\@\.\?\!\#\%\*\_\+\\n\=\;\,\:\ ]/", $str))
    {
        return false;
    }
    return true;
}


/*      فارسی بودن    */
function farsiAst($str)
{
    if (preg_match("/[^ا-ی0-9\:\(\)\-\_\@\.\؟\!\#\%\\n\*\+\=\«\»\ء\ئ\آ\ً\ٌ\ٍ\؛\َ\ُ\ِ\ّ\ۀ\ؤ\ة\،\:\پ\ل\ک\ژ\گ\چ\م\و\ه\ق\ف\ ]/", $str))
    {
        return false;
    }
    return true;
}


/*      تست عددی بودن رشته   */
function adadiAst($str)
{
    if(preg_match("/^([0-9]*)$/",$str))
    {
        return true;
    }
    return false;
}


/*        معتبر بودن جی سان          */
function jsonMotabarASt($strJson)
{
    $arrTemp=json_decode($strJson,true);
    if(json_last_error()===JSON_ERROR_NONE) return $arrTemp; else return false;
}

/*  اعتبار سنجی کد ملی  */
function codeMelliMotabarAst($code)
{
    if(!preg_match('/^[0-9]{10}$/',$code))
        return false;
    for($i=0;$i<10;$i++)
        if(preg_match('/^'.$i.'{10}$/',$code))
            return false;
    for($i=0,$sum=0;$i<9;$i++)
        $sum+=((10-$i)*intval(substr($code, $i,1)));
    $ret=$sum%11;
    $parity=intval(substr($code, 9,1));
    if(($ret<2 && $ret==$parity) || ($ret>=2 && $ret==11-$parity))
        return true;
    return false;
}


/*     تایید متن ساده     */
function taeedMatnSadeh($str)       /*      متن فارسی و انگلیسی با علائم    */
{
    if (preg_match("/[^A-Za-z0-9ا-ی\:\(\)\_\-\\n\@\.\?\!\#\%\*\+\=\;\؟\,\:\«\»\ء\ئ\آ\ً\ٌ\ٍ\؛\َ\ُ\ِ\ّ\ۀ\ؤ\ة\،\پ\ل\ک\ژ\گ\و\ه\ق\ف\ي\چ\م\ ]/", $str))
    {
        return false;
    }
    return true;
}

/*    معتبر بودن نام رسمی     */
function namRasmiMotabarAst($str)       /*    متن فارسی و انگلیسی بدون علائم  */
{
    if (preg_match("/[^A-Za-z0-9ا-ی\-\ء\ئ\آ\ؤ\ة\پ\ل\ک\ژ\گ\و\ه\ق\ف\ي\چ\م\ ]/", $str))
    {
        return false;
    }
    return true;
}


/*      تست شماره موبایل بودن عدد   */
function mobileAst($adad, $baSefr = 0)              /*       برای با صفر بودن 1 و برای بدون صفر بودن(پیشفرض) 0      */
{
    $adad = trim($adad);

    if (!adadiAst((float)$adad))
        return false;

    if ($baSefr == 0)
    {
        if (strlen((string)$adad) != 10)
            return false;

        if (substr($adad, 0, 1) == 0)
            return false;
    }
    elseif ($baSefr == 1)
    {
        if (strlen((string)$adad) != 11)
            return false;

        if (substr($adad, 0, 1) != 0)
            return false;
    }

    return true;
}


/*    تایید تلفن همراه  */
function taeedTelHamrah($strTel)
{
    $payam=true;
    $tedad=mb_strlen($strTel);
    if($tedad!=11)
    {
        $payam="errLength";
    }
    for($i=0;$i<$tedad;$i++)
    {
        if(mb_substr($strTel,$i,1)<"0" || mb_substr($strTel,$i,1)>"9") break;
    }
    if($i!=$tedad)
    {
        if($payam===true)
            $payam=":errAdadNist";
        else
            $payam.=":errAdadNist";
    }

    return $payam;
}


/*      تست شماره تلفن بودن عدد   */
function telephoneAst($adad, $pishShomareh = 0)       /*    برای با پیش شماره بودن پیش شماره و برای بدون پیش شماره بودن(پیشفرض) 0      */
{
    $adad = trim($adad);

    if (!adadiAst((float)$adad))
        return false;

    if ($pishShomareh == 0)
    {
        if (strlen((string)$adad) != 8)
            return false;

        if (substr($adad, 0, 1) == 0)
            return false;
    }
    else
    {
        if (strlen((string)$adad) != 11)
            return false;

        if (substr($adad, 0, strlen((string)$pishShomareh)) != $pishShomareh)
            return false;
    }

    return true;
}


/*      ممیز دار کردن عدد    */
function momayezdar($num)
{
    $num = trim($num);
    if ($num >= 0)
    {
        $numJadid = "";
        $barAksNum = strrev($num);
        $shomarandeh3 = 1;

        for ($i = 0; $i < strlen($num); $i++)
        {
            $numJadid .= substr($barAksNum, $i, 1);
            if ($shomarandeh3 == 3 && ($i != strlen($num)-1))
            {
                $numJadid .= ",";
                $shomarandeh3 = 1;
            }
            else
            {
                $shomarandeh3++;
            }
        }

        return strrev($numJadid);
    }
    elseif ($num < 0)
    {
        $numBiManfi = substr($num, 1, strlen($num));
        $numJadid = "";
        $barAksNum = strrev($numBiManfi);
        $shomarandeh3 = 1;

        for ($i = 0; $i < strlen($numBiManfi); $i++)
        {
            $numJadid .= substr($barAksNum, $i, 1);
            if ($shomarandeh3 == 3 && ($i != strlen($numBiManfi)-1))
            {
                $numJadid .= ",";
                $shomarandeh3 = 1;
            }
            else
            {
                $shomarandeh3++;
            }
        }

        return "-" . strrev($numJadid);
    }
}


/*      حذف ممیز عدد    */
function hazfMomayez($adad)
{
    $adad = trim($adad);
    return (integer)str_replace(",", "", $adad);
}


/*      فاصله دار کردن شماره کارت   */
function faselehdar($num)
{
    $num = trim($num);
    $numJadid = "";
    $shomarandeh4 = 1;

    for ($i = 0; $i < strlen($num); $i++)
    {
        $numJadid .= substr($num,$i,1);
        if ($shomarandeh4 == 4 && ($i != strlen($num)-1))
        {
            $numJadid .= " ";
            $shomarandeh4 = 1;
        }
        else
        {
            $shomarandeh4++;
        }
    }

    return $numJadid;
}


/*      تبدیل روز و ماه و سال به رشته تاریخ   */
function tarikhKon($sal, $mah, $rooz)
{
    if ($rooz < 10 && strlen((string)$rooz) == 1) $rooz = "0" . $rooz;
    if ($mah < 10 && strlen((string)$mah) == 1) $mah = "0" . $mah;
    return $sal . "/" . $mah . "/" . $rooz;
}

/*  حجم پوشه به مگابایت  */
function folderSize($dir)
{
    $count_size = 0;
    $count = 0;
    $dir_array = scandir($dir);
    foreach($dir_array as $key=>$filename)
    {
        if($filename!=".." && $filename!="."){
            if(is_dir($dir."/".$filename)){
                $new_foldersize = foldersize($dir."/".$filename);
                $count_size = $count_size+ $new_foldersize;
            }else if(is_file($dir."/".$filename)){
                $count_size = $count_size + filesize($dir."/".$filename);
                $count++;
            }
        }
    }
    return round($count_size/1024/1024);
}

/*        تولید آیدی فیک برای ردیابی نشدن آیدی       */
function tolidIdFake($id)
{
    $strID=(string)$id;
    $tikeh1=substr($strID,0,floor(mb_strlen($strID)/2));
    $tikeh2=substr($strID,floor(mb_strlen($strID)/2));
    return ((string)mt_rand(10,99)).$tikeh1.((string)mt_rand(1000,9999)).$tikeh2.((string)mt_rand(100,999));
}

/*        بازیابی آیدی از آیدی فیک برای ردیابی نشدن آیدی       */
function tolidIdVagheeeAzFake($idFake)
{
    $strID=(string)$idFake;
    $tikeh1=substr($strID,2,floor((mb_strlen($strID)-9)/2));
    $tikeh2=substr($strID,floor((mb_strlen($strID)-9)/2)+6,(mb_strlen($strID)-(floor((mb_strlen($strID)-9)/2)+6))-3);
    return $tikeh1.$tikeh2;
}

function getPassword($tedadRagham = 8)
{
    if ($tedadRagham < 4) return false;

    $neoHa = "";
    $arrHoroof = array("abcdefghijkmnpqrstuvwxyz", "ABCDEFGHJKLMNPQRSTUVWXYZ", "123456789", "-!@#$%&*_+=/?");
    $pass = "";
    for ($i=0; $i < $tedadRagham; $i++)
    {
        $adadRanbdom = mt_rand(0, 3);
        $pass .= substr($arrHoroof[$adadRanbdom], mt_rand(0, strlen($arrHoroof[$adadRanbdom])-1), 1);
        $neoHa .= $adadRanbdom;
    }

    if (strpos($neoHa,"0") === false || strpos($neoHa,"1") === false || strpos($neoHa,"2") === false || strpos($neoHa,"3") === false)
        return getPassword($tedadRagham);
    else
        return $pass;
}

/*        انکود رشته عددی 12 رقمی (4 رقم سال 2 رقم ماه 2 رقم روز 2 رقم ساعت 2 رقم دقیقه)         */
function encodeTarikhVaSaatVaCode($reshteh, $code)
{
    $arrAdad = array();
    for ($i=0; $i<12; $i++)
    {
        array_push($arrAdad, (string)substr($reshteh, $i, 1));
    }

    return (string)$arrAdad[5] . (string)$arrAdad[8] . (string)$arrAdad[0] . (string)$arrAdad[3] . (string)$arrAdad[11] . (string)$arrAdad[1] . (string)$arrAdad[6] . (string)$arrAdad[2] . (string)$arrAdad[10] . (string)$arrAdad[4] . (string)$arrAdad[9] . (string)$arrAdad[7] . (string)$code;
}

/*        دیکود تابع بالا         */
function decodeTarikhVaSaatVaCode($reshteh)
{
    $arrAdad = array();
    for ($i=0; $i<12; $i++)
    {
        array_push($arrAdad, (string)substr($reshteh, $i, 1));
    }

    return "t:" . (string)$arrAdad[2] . (string)$arrAdad[5] . (string)$arrAdad[7] . (string)$arrAdad[3] . "/" . (string)$arrAdad[9] . (string)$arrAdad[0] . "/" . (string)$arrAdad[6] . (string)$arrAdad[11] . " - z:". (string)$arrAdad[1] . (string)$arrAdad[10] . ":" . (string)$arrAdad[8] . (string)$arrAdad[4] . " - c:" . substr((string)$reshteh, 12, strlen((string)$reshteh) - 12);
}