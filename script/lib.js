function mobileAst(px = 767)
{
    if (document.getElementsByTagName("body")[0].offsetWidth < px)
        return true;
    else
        return false;
}

/*      گرفتن کوکی      */
function getCookie(name)
{
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}

/*      ست کردن کوکی      */
function setCookie(namC, meghdarC, taChandRooz, masir)
{
    var datEx = new Date();
    datEx.setDate(datEx.getDate()+taChandRooz);
    document.cookie = namC + "=" + encodeURIComponent(meghdarC) + ((taChandRooz!=undefined)?(";expires=" + datEx.toUTCString()):"") + ";path=" + ((masir!=undefined)?masir:"/");
}

/*      حذف کردن کوکی      */
function delCookie(namC, masir)
{
    var datSefr = new Date();
    datSefr.setTime(0);
    setCookie(namC, "", -1, masir);
}


//      بررسی زبانها
function farsiAst(strVoroodi)
{
    var arrHarFarsi = ["آ", "ا", "ب", "پ", "ت", "ث", "ج", "چ", "ح", "خ", "د", "ذ", "ر", "ز", "ژ", "س",
        "ش", "ص", "ض", "ط", "ظ", "ع", "غ", "ف", "ق", "ک", "گ", "ل", "م", "ن", "و", "ه", "ی", "ئ", "ء", " ",
        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];

    for (i = 0; i < strVoroodi.length; i++)
    {
        var mojoodAst = false;
        for (j = 0; j < arrHarFarsi.length; j++)
        {
            if (strVoroodi.charAt(i) == arrHarFarsi[j])
                mojoodAst = true;

        }
        if (mojoodAst != true) return false;
    }
    return true;
}


function englisiAst(strVoroodi)
{
    var arrHarEnglisi = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m",
        "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", " ",
        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
    for (i = 0; i < strVoroodi.length; i++)
    {
        var mojoodAst = false;
        for (j = 0; j < arrHarEnglisi.length; j++)
        {
            if ((strVoroodi.charAt(i)).toLowerCase() == arrHarEnglisi[j])
                mojoodAst = true;

        }
        if (mojoodAst != true) return false;
    }
    return true;
}

//      بررسی نام کاربری
function isValidUsername(strVoroodi)
{
    var arrHarEnglisiVaAdad = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m",
        "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "."];
    for (i = 0; i < strVoroodi.length; i++)
    {
        var mojoodAst = false;
        for (j = 0; j < arrHarEnglisiVaAdad.length; j++)
        {
            if ((strVoroodi.charAt(i)).toLowerCase() == arrHarEnglisiVaAdad[j])
                mojoodAst = true;

        }
        if (mojoodAst != true) return false;
    }
    return true;
}


//  معتبر بودن جی سان
function jsonMotabarAst(json)
{
    try {
        JSON.parse(json);
        return true;
    } catch (e) {
        return false;
    }
}