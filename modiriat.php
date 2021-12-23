<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("code/config.php");
if (!isset($_SESSION["modir"]) || $_SESSION["modir"] !== "loginAst" || !isset($_SESSION["sathFard"]) || $_SESSION["sathFard"] !== 1 || !isset($_SERVER["HTTP_REFERER"]) || parse_url($_SERVER["HTTP_REFERER"], PHP_URL_HOST) != parse_url(ADDRESS_SITE, PHP_URL_HOST))
{
    header("HTTP/1.0 404 Not Found");
    die();
}

include ("code/jdf.php");
include ("code/lib.php");

if (!isset($_SESSION["tokenA"]))
{
    if (function_exists('random_bytes'))
        $_SESSION["tokenA"] = bin2hex(random_bytes(32));
    else
        $_SESSION["tokenA"] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
}
$tokenA = $_SESSION["tokenA"];
?>
<!DOCTYPE html>
<html lang="fa-ir">
<head>
    <title>مدیریت مستندات صفا رایحه</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="pic/logo-kochik.png"/>
    <link rel="stylesheet" href="style/main.css"/>
    <link rel="stylesheet" href="style/modiriat.css"/>
    <script src="script/lib.js"></script>
    <script src="script/main.js"></script>
    <script>
        var tkA = "<?php echo $tokenA;?>";
        var tedadNamayesh = <?php echo TEDAD_NAMAYESH_MODIRIAT;?>;
    </script>
</head>
<body dir="rtl">

<div id="CountainerKadrNamayeshPeygham" style="display: none">
    <div id="kadrNamayeshPeygham"></div>
    <div class="kadrSiah" onclick="bastanPeygham()"></div>
</div>

<div id="fullCountainer">

    <div id="header">
        <img src="pic/logo-s.png" id="aksHeader"/>
        <h1 id="titrKol">مدیریت مستندات صفا رایحه</h1>
        <a href="index.php?khM" class="btnEmkanat" title="خروج"></a>
        <a href="index.php?ho" class=" btnEmkanat btnHome" title="بازگشت به سامانه"></a>
        <a href="javascript: void (0);" class=" btnEmkanat btnHome" id="btnAmar" onclick="entekhabAmarVaModiriat();" title="آمار سامانه"></a>
    </div>

    <div id="kadrModiriat" style="display: block">
        <div id="kadrMenu">
            <a href="javascript: void (0);" onclick="entekhabListAza();" class="itemMenu" data-enekhabi><span class="icon"></span>لیست اعضاء</a>
            <a href="javascript: void (0);" onclick="entekhabListDasehBandi();" class="itemMenu"><span class="icon"></span>موضوعات</a>
            <a href="javascript: void (0);" onclick="entekhabListFileha();" class="itemMenu"><span class="icon"></span>فایل ها</a>
            <a href="javascript: void (0);" onclick="entekhabListBarchasbha();" class="itemMenu"><span class="icon"></span>برچسب ها</a>
        </div>

        <div id="kadrListAza" class="kadrListha" style='display: block;'>
            <div class="kadrKolLoading" style="display: none">
                <div class="kadrLoading">
                    <img src="pic/loading.png" class="loading">
    <!--                <a href="javasCript: void (0);" onclick="bastanLoading('kadrListAza');" class="zabdarLoading"></a>-->
                </div>
            </div>

            <h2 class="titrKadrListha"></h2>
            <a href="javascript: void (0);" onclick="afzoodanOzv();" class="emkanatLST" title="افزودن"><span class="icon"></span></a>
            <a href="javascript: void (0);" onclick="entekhabListAza(0);" class="emkanatLST" title="لیست حذف شده ها"><span class="icon"></span></a>
            <a href="javascript: void (0);" onclick="entekhabListAza();" class="emkanatLST" title="لیست اعضاء" style="display: none"><span class="icon"></span></a>
            <div class="kadrSearch">
                <input type="text" class="txtSearch" name="txtSearch" placeholder="جستجو" maxlength="50" autocomplete="off"/>
                <a href="javascript: void (0);" onclick="searchAza();" class="emkanatLST btnSearch" title="جستجو"><span class="icon"></span></a>
                <a href="javascript: void (0);" onclick="entekhabListAza(vaziatSaf, 'hameh', '', 1);" class="zabdarSearchShodeh"></a>
            </div>

            <div class="kadrDorListha">
                <div class="listha rahnama">
                    <span class="etelaatFard icon"></span>
                    <span class="etelaatFard codePerseneli">کد پرسنلی</span>
                    <span class="etelaatFard familFard">نام خانوادگی</span>
                    <span class="etelaatFard namFard">نام</span>
                    <span class="etelaatFard sathFard">سطح فرد</span>
                </div>
                <div class="kadrDorList"></div>
            </div>

            <div class="kadrAfzoodan" style="display: none">
                <div class="kadrDorEtelaat">
                    <div class="iconEtelaatAfzoodan"></div>
                    <div class="titrEtelaatAfzoodan">کد پرسنلی :</div>
                    <div class="meghdarEtelaatAfzoodan"><input type="text" name="codePerseneli" maxlength="6" autocomplete="off" style="direction: ltr"/></div>
                </div>
                <div class="kadrDorEtelaat">
                    <div class="iconEtelaatAfzoodan"></div>
                    <div class="titrEtelaatAfzoodan">نام :</div>
                    <div class="meghdarEtelaatAfzoodan"><input type="text" name="nam" maxlength="30" autocomplete="off"/></div>
                </div>
                <div class="kadrDorEtelaat">
                    <div class="iconEtelaatAfzoodan"></div>
                    <div class="titrEtelaatAfzoodan">نام خانوادگی :</div>
                    <div class="meghdarEtelaatAfzoodan"><input type="text" name="famil" maxlength="40" autocomplete="off"/></div>
                </div>
                <div class="kadrDorEtelaat">
                    <div class="iconEtelaatAfzoodan"></div>
                    <div class="titrEtelaatAfzoodan">سطح دسترسی :</div>
                    <div class="meghdarEtelaatAfzoodan">
                        <select name="sath">
                            <option value="2">هیئت مدیره</option>
                            <option value="3">مدیران میانی</option>
                            <option value="4">پرسنل عادی</option>
                        </select>
                    </div>
                </div>
                <a href="javascript:void (0);" onclick="sabtOzv();" class="btnAfzoodan"><span class="icon"></span>ثبت اطلاعات</a>
            </div>

            <div class="kadrPaging">
                <table>
                    <tr>
                        <td><a href="javascript: void (0);" title="صفحه اول"></a></td>
                        <td><a href="javascript: void (0);" title="صفحه قبل"></a></td>
                        <td class="kadrShomSaf"></td>
                        <td><a href="javascript: void (0);" title="صفحه بعد"></a></td>
                        <td><a href="javascript: void (0);" title="صفحه آخر"></a></td>
                    </tr>
                </table>
            </div>
        </div>

        <div id="kadrListDasteh" class="kadrListha" style="display: none">
            <div class="kadrKolLoading" style="display: none">
                <div class="kadrLoading">
                    <img src="pic/loading.png" class="loading">
    <!--                <a href="javasCript: void (0);" onclick="bastanLoading('kadrListDasteh');" class="zabdarLoading"></a>-->
                </div>
            </div>

            <h2 class="titrKadrListha"><span class="icon"></span>موضوعات</h2>
            <a href="javascript: void (0);" onclick="afzoodanDasteh();" class="emkanatLST" title="افزودن"><span class="icon"></span></a>
            <a href="javascript: void (0);" onclick="entekhabListDasehBandi(0);" class="emkanatLST" title="لیست حذف شده ها"><span class="icon"></span></a>
            <a href="javascript: void (0);" onclick="entekhabListDasehBandi();" class="emkanatLST" title="لیست موضوعات" style="display: none"><span class="icon"></span></a>
            <div class="kadrSearch">
                <input type="text" class="txtSearch" name="txtSearch" placeholder="جستجو" maxlength="50" autocomplete="off"/>
                <a href="javascript: void (0);" onclick="searchDasteh();" class="emkanatLST btnSearch" title="جستجو"><span class="icon"></span></a>
                <a href="javascript: void (0);" onclick="entekhabListDasehBandi(vaziatSaf, 'hameh', '', 1);" class="zabdarSearchShodeh"></a>
            </div>

            <div class="kadrDorListha">
                <div class="dastehha rahnama">
                    <span class="etelaatFard icon"></span>
                    <span class="dasteh">موضوع</span>
                    <span class="sathDasteh">سطح</span>
                </div>
                <div class="kadrDorList"></div>
            </div>

            <div class="kadrAfzoodan" style="display: none">
                <div class="kadrDorEtelaat">
                    <div class="iconEtelaatAfzoodan"></div>
                    <div class="titrEtelaatAfzoodan">نام موضوع :</div>
                    <div class="meghdarEtelaatAfzoodan"><input type="text" name="dasteh" autocomplete="off"/></div>
                </div>
                <div class="kadrDorEtelaat">
                    <div class="iconEtelaatAfzoodan"></div>
                    <div class="titrEtelaatAfzoodan">سطح دسترسی :</div>
                    <div class="meghdarEtelaatAfzoodan">
                        <select name="sath">
                            <option value="2">هیئت مدیره</option>
                            <option value="3">مدیران میانی</option>
                            <option value="4">پرسنل عادی</option>
                        </select>
                    </div>
                </div>
                <a href="javascript:void (0);" onclick="sabtDasteh()" class="btnAfzoodan"><span class="icon"></span>ثبت موضوع</a>

                <div class="kadrJoziat">
                    <h3 class="titrKadrJoziat"><span class="icon"></span>برچسب های این موضوع :</h3>
                    <div class="kadrDorJoziat"></div>
                </div>
            </div>

            <div class="kadrPaging">
                <table>
                    <tr>
                        <td><a href="javascript: void (0);" title="صفحه اول"></a></td>
                        <td><a href="javascript: void (0);" title="صفحه قبل"></a></td>
                        <td class="kadrShomSaf"></td>
                        <td><a href="javascript: void (0);" title="صفحه بعد"></a></td>
                        <td><a href="javascript: void (0);" title="صفحه آخر"></a></td>
                    </tr>
                </table>
            </div>
        </div>

        <div id="kadrListPDF" class="kadrListha" style="display: none">
            <div class="kadrKolLoading" style="display: none">
                <div class="kadrLoading">
                    <img src="pic/loading.png" class="loading">
    <!--                <a href="javasCript: void (0);" onclick="bastanLoading('kadrListPDF');" class="zabdarLoading"></a>-->
                </div>
            </div>

            <h2 class="titrKadrListha"><span class="icon"></span>فایل ها</h2>
            <a href="javascript: void (0);" onclick="afzoodanFile();" class="emkanatLST" title="افزودن"><span class="icon"></span></a>
            <a href="javascript: void (0);" onclick="entekhabListFileha(0);" class="emkanatLST" title="لیست حذف شده ها"><span class="icon"></span></a>
            <a href="javascript: void (0);" onclick="entekhabListFileha();" class="emkanatLST" title="لیست فایل ها" style="display: none"><span class="icon"></span></a>
            <div class="kadrSearch">
                <input type="text" class="txtSearch" name="txtSearch" placeholder="جستجوی تاریخ" maxlength="10" autocomplete="off"/>
                <a href="javascript: void (0);" onclick="searchFile();" class="emkanatLST btnSearch" title="جستجو"><span class="icon"></span></a>
                <a href="javascript: void (0);" onclick="entekhabListFileha(vaziatSaf, 'hameh', '', 1);" class="zabdarSearchShodeh"></a>
            </div>

            <div class="kadrDorListha">
                <div class="pdfha rahnama">
                    <span class="etelaatFard icon"></span>
                    <span class="dasteh">دسته بندی</span>
                    <span class="tarikhErsal">تاریخ ارسال</span>
                    <span class="zamanErsal">زمان ارسال</span>
                </div>
                <div class="kadrDorList"></div>
            </div>

            <div class="kadrAfzoodan" style="display: none">
                <form action="modiriat.php" method="post" enctype="multipart/form-data">
                    <div class="kadrDorEtelaat">
                        <div class="iconEtelaatAfzoodan"></div>
                        <div class="titrEtelaatAfzoodan">دسته بندی :</div>
                        <div class="meghdarEtelaatAfzoodan">
                            <select name="dasteh"></select>
                        </div>
                    </div>
                    <div class="kadrDorEtelaat">
                        <div class="iconEtelaatAfzoodan"></div>
                        <div class="titrEtelaatAfzoodan">انتخاب فایل :</div>
                        <div class="meghdarEtelaatAfzoodan">
                            <input type="file" name="myfile"/>
                        </div>
                    </div>
                    <a href="javascript:void (0);" onclick="this.parentElement.submit();" class="btnAfzoodan"><span class="icon"></span>ثبت فایل</a>
                </form>
            </div>

            <div class="kadrPaging">
                <table>
                    <tr>
                        <td><a href="javascript: void (0);" title="صفحه اول"></a></td>
                        <td><a href="javascript: void (0);" title="صفحه قبل"></a></td>
                        <td class="kadrShomSaf"></td>
                        <td><a href="javascript: void (0);" title="صفحه بعد"></a></td>
                        <td><a href="javascript: void (0);" title="صفحه آخر"></a></td>
                    </tr>
                </table>
            </div>
        </div>

        <div id="kadrListBarchasb" class="kadrListha" style="display: none">
            <div class="kadrKolLoading" style="display: none">
                <div class="kadrLoading">
                    <img src="pic/loading.png" class="loading">
    <!--                <a href="javasCript: void (0);" onclick="bastanLoading('kadrListBarchasb');" class="zabdarLoading"></a>-->
                </div>
            </div>

            <h2 class="titrKadrListha"><span class="icon"></span>برچسب ها</h2>
            <a href="javascript: void (0);" onclick="afzoodanBarchasb();" class="emkanatLST" title="افزودن"><span class="icon"></span></a>
            <a href="javascript: void (0);" onclick="entekhabListBarchasbha();" class="emkanatLST" title="لیست برچسب ها" style="display: none"><span class="icon"></span></a>
            <div class="kadrSearch">
                <input type="text" class="txtSearch" name="txtSearch" placeholder="جستجو" maxlength="10" autocomplete="off"/>
                <a href="javascript: void (0);" onclick="searchBarchasb();" class="emkanatLST btnSearch" title="جستجو"><span class="icon"></span></a>
                <a href="javascript: void (0);" onclick="entekhabListBarchasbha();" class="zabdarSearchShodeh"></a>
            </div>

            <div class="kadrDorListha">
                <div class="kadrDorList"></div>
            </div>

            <div class="kadrAfzoodan" style="display: none">
                <div class="kadrDorEtelaat">
                    <div class="iconEtelaatAfzoodan"></div>
                    <div class="titrEtelaatAfzoodan">نام برچسب :</div>
                    <div class="meghdarEtelaatAfzoodan"><input type="text" name="barchasb" autocomplete="off"/></div>
                </div>
                <a href="javascript:void (0);" onclick="sabtBarchasb();" class="btnAfzoodan"><span class="icon"></span>ثبت برچسب</a>

                <div class="kadrJoziat">
                    <h3 class="titrKadrJoziat"><span class="icon"></span>موضوعات این برچسب :</h3>
                    <div class="kadrDorJoziat"></div>
                </div>
            </div>

            <div class="kadrPaging">
                <table>
                    <tr>
                        <td><a href="javascript: void (0);" title="صفحه اول"></a></td>
                        <td><a href="javascript: void (0);" title="صفحه قبل"></a></td>
                        <td class="kadrShomSaf"></td>
                        <td><a href="javascript: void (0);" title="صفحه بعد"></a></td>
                        <td><a href="javascript: void (0);" title="صفحه آخر"></a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div id="kadrKolAmar" style="display: none">
        <div class="kadrKolLoading" style="display: none">
            <div class="kadrLoading">
                <img src="pic/loading.png" class="loading">
            </div>
        </div>
        <div class="kadrAmar" id="kadrAmarAza">
            <h3 class="titrKadrAmar"><span class="icon"></span>آمار اعضاء</h3>
            <div class="kadrDorAmar">
                <div class="amar">
                    <div class="titrAmar"><span class="icon"></span>تعداد اعضاء :</div>
                    <div class="meghdarAmar amarAdadi" id="tedadAzaAMR"></div>
                </div>
                <div class="amar">
                    <div class="titrAmar"><span class="icon"></span>تعداد هیئت مدیره :</div>
                    <div class="meghdarAmar amarAdadi" id="tedadSath2AMR"></div>
                </div>
                <div class="amar">
                    <div class="titrAmar"><span class="icon"></span>تعداد مدیران میانی :</div>
                    <div class="meghdarAmar amarAdadi" id="tedadSath3AMR"></div>
                </div>
                <div class="amar">
                    <div class="titrAmar"><span class="icon"></span>تعداد پرسنل عادی :</div>
                    <div class="meghdarAmar amarAdadi" id="tedadSath4AMR"></div>
                </div>
            </div>
        </div>

        <div class="kadrAmar" id="kadrAmarDasteh">
            <div class="kadrAmar" id="kadrAmarAza">
                <h3 class="titrKadrAmar"><span class="icon"></span>آمار موضوعات</h3>
                <div class="amar">
                    <div class="titrAmar"><span class="icon"></span>تعداد کل موضوعات :</div>
                    <div class="meghdarAmar amarAdadi" id="tedadDasteh"></div>
                </div>
                <div class="amar">
                    <div class="titrAmar"><span class="icon"></span>موضوعات هیئت مدیره :</div>
                    <div class="meghdarAmar amarAdadi" id="dastehSath2AMR"></div>
                </div>
                <div class="amar">
                    <div class="titrAmar"><span class="icon"></span>موضوعات مدیران میانی :</div>
                    <div class="meghdarAmar amarAdadi" id="dastehSath3AMR"></div>
                </div>
                <div class="amar">
                    <div class="titrAmar"><span class="icon"></span>موضوعات پرسنل عادی :</div>
                    <div class="meghdarAmar amarAdadi" id="dastehSath4AMR"></div>
                </div>
            </div>
        </div>

        <div class="kadrAmar" id="kadrAmarFile">
            <div class="kadrAmar" id="kadrAmarAza">
                <h3 class="titrKadrAmar"><span class="icon"></span>آمار فایل ها</h3>
                <div class="amar">
                    <div class="titrAmar"><span class="icon"></span>تعداد کل فایل ها :</div>
                    <div class="meghdarAmar amarAdadi" id="tedadFile"></div>
                </div>
            </div>
        </div>

        <div class="kadrAmar" id="kadrAmarBarchasb">
            <div class="kadrAmar" id="kadrAmarAza">
                <h3 class="titrKadrAmar"><span class="icon"></span>آمار برچسب ها</h3>
            </div>
            <div class="amar">
                <div class="titrAmar"><span class="icon"></span>تعداد کل برچسب ها :</div>
                <div class="meghdarAmar amarAdadi" id="tedadBarchasb"></div>
            </div>
            <div class="amar">
                <div class="titrAmar"><span class="icon"></span>پر استفاده ترین برچسب :</div>
                <div class="meghdarAmar" id="barchasbPorEsefadeh"></div>
            </div>
        </div>
    </div>

</div>
<script>

var vaziatSaf = 1;
var noeSaf = "hameh";
var meghdarSearchSaf = "";
var shomSaf = 1;

/*    چک کردن وجود اینپوت روی صفحه برای مجاز بودن به انجام کار    */
function mojazBeAnjamKarAst()
{
    if (document.querySelector(".kadrDorList input") || document.querySelector("#kadrListDasteh .kadrBarchasbhaDasteh[data-baz-ast]"))
    {
        namayeshPeygham("پیام سیستم!", "ابتدا کار قبلی خود را به اتمام برسانید");
        return false;
    }
    else
    {
        return true;
    }
}

/*  سوییچ بین صفحه آمار و مدیریت */
function entekhabAmarVaModiriat()
{
    if (document.getElementById("kadrModiriat").style.display == "block")
    {
        document.getElementById("kadrModiriat").style.display = "none";
        document.getElementById("kadrKolAmar").style.display = "block";
        document.getElementById("btnAmar").innerHTML = "";
        document.getElementById("btnAmar").title = "مدیریت سامانه";

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function ()
        {
            if (this.readyState === 4 && this.status === 200)
            {
                if (!jsonMotabarAst(this.responseText)) return;
                var arrNatijeh = JSON.parse(this.responseText);

                if (arrNatijeh[0] == "ok")
                {
                    document.getElementById("tedadAzaAMR").innerHTML = arrNatijeh[1][0];
                    document.getElementById("tedadSath2AMR").innerHTML = arrNatijeh[1][1];
                    document.getElementById("tedadSath3AMR").innerHTML = arrNatijeh[1][2];
                    document.getElementById("tedadSath4AMR").innerHTML = arrNatijeh[1][3];
                    document.getElementById("tedadDasteh").innerHTML = arrNatijeh[1][4];
                    document.getElementById("dastehSath2AMR").innerHTML = arrNatijeh[1][5];
                    document.getElementById("dastehSath3AMR").innerHTML = arrNatijeh[1][6];
                    document.getElementById("dastehSath4AMR").innerHTML = arrNatijeh[1][7];
                    document.getElementById("tedadFile").innerHTML = arrNatijeh[1][8];
                    document.getElementById("tedadBarchasb").innerHTML = arrNatijeh[1][9];
                    document.getElementById("barchasbPorEsefadeh").innerHTML = arrNatijeh[1][10];
                }
                else
                {
                    namayeshPeygham("خطای سیستم!", "لطفا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
                }

                document.querySelectorAll("#kadrKolAmar>.kadrKolLoading")[0].style.display = "none";
            }
        };
        xhttp.open("POST","ajax/mod/amar-samaneh.php?sid="+Math.random(),true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxJari = xhttp;
        xhttp.send("tkA="+tkA);
        document.querySelectorAll("#kadrKolAmar>.kadrKolLoading")[0].style.display = "block";
    }
    else
    {
        document.getElementById("kadrModiriat").style.display = "block";
        document.getElementById("kadrKolAmar").style.display = "none";
        document.getElementById("btnAmar").innerHTML = "";
        document.getElementById("btnAmar").title = "آمار سامانه";
    }
}

/*      برسی زدن کلید اسکیپ و اینتر     */
function barresiEnterVaEsc(noe)
{
    var shomLmn;
    var idLmn;

    if (noe == "searchAza")
    {
        document.querySelector("#kadrListAza input.txtSearch").onkeydown = function (e) {if (e.keyCode == 13) searchAza();};
    }
    else if (noe == "virayeshAza")
    {
        shomLmn = document.querySelector("#kadrListAza input.txtVirayeshOzv").parentElement.parentElement.dataset.shom;
        idLmn = document.querySelector("#kadrListAza input.txtVirayeshOzv").parentElement.parentElement.dataset.id;

        document.querySelectorAll("#kadrListAza input.txtVirayeshOzv")[0].onkeydown = function (e)
        {
            if (e.keyCode == 13) taeedVirayeshOzv(shomLmn, idLmn);
            else if (e.keyCode == 27) laghvVirayeshOzv(shomLmn);
        };
        document.querySelectorAll("#kadrListAza input.txtVirayeshOzv")[1].onkeydown = function (e)
        {
            if (e.keyCode == 13) taeedVirayeshOzv(shomLmn, idLmn);
            else if (e.keyCode == 27) laghvVirayeshOzv(shomLmn);
        };
        document.querySelectorAll("#kadrListAza input.txtVirayeshOzv")[2].onkeydown = function (e)
        {
            if (e.keyCode == 13) taeedVirayeshOzv(shomLmn, idLmn);
            else if (e.keyCode == 27) laghvVirayeshOzv(shomLmn);
        };
        document.querySelectorAll("#kadrListAza select.txtVirayeshOzv")[0].onkeydown = function (e)
        {
            if (e.keyCode == 13) taeedVirayeshOzv(shomLmn, idLmn);
            else if (e.keyCode == 27) laghvVirayeshOzv(shomLmn);
        };
    }
    else if (noe == "sabtAza")
    {
        document.querySelectorAll("#kadrListAza .kadrAfzoodan .meghdarEtelaatAfzoodan>input")[0].onkeydown = function (e) {if (e.keyCode == 13) sabtOzv();};
        document.querySelectorAll("#kadrListAza .kadrAfzoodan .meghdarEtelaatAfzoodan>input")[1].onkeydown = function (e) {if (e.keyCode == 13) sabtOzv();};
        document.querySelectorAll("#kadrListAza .kadrAfzoodan .meghdarEtelaatAfzoodan>input")[2].onkeydown = function (e) {if (e.keyCode == 13) sabtOzv();};
        document.querySelectorAll("#kadrListAza .kadrAfzoodan .meghdarEtelaatAfzoodan>select")[0].onkeydown = function (e) {if (e.keyCode == 13) sabtOzv();};
    }
    else if (noe == "searchDasteh")
    {
        document.querySelector("#kadrListDasteh input.txtSearch").onkeydown = function (e) {if (e.keyCode == 13) searchDasteh();};
    }
    else if (noe == "virayeshDasteh")
    {
        shomLmn = document.querySelector("#kadrListDasteh input.txtVirayeshDasteh").parentElement.parentElement.dataset.shom;
        idLmn = document.querySelector("#kadrListDasteh input.txtVirayeshDasteh").parentElement.parentElement.dataset.id;

        document.querySelectorAll("#kadrListDasteh input.txtVirayeshDasteh")[0].onkeydown = function (e)
        {
            if (e.keyCode == 13) taeedVirayeshDasteh(shomLmn, idLmn);
            else if (e.keyCode == 27) laghvVirayeshDasteh(shomLmn);
        };
        document.querySelectorAll("#kadrListDasteh select.txtVirayeshDasteh")[0].onkeydown = function (e)
        {
            if (e.keyCode == 13) taeedVirayeshDasteh(shomLmn, idLmn);
            else if (e.keyCode == 27) laghvVirayeshDasteh(shomLmn);
        };
    }
    else if (noe == "sabtDasteh")
    {
        document.querySelectorAll("#kadrListDasteh .kadrAfzoodan .meghdarEtelaatAfzoodan>input")[0].onkeydown = function (e) {if (e.keyCode == 13) sabtDasteh();};
        document.querySelectorAll("#kadrListDasteh .kadrAfzoodan .meghdarEtelaatAfzoodan>select")[0].onkeydown = function (e) {if (e.keyCode == 13) sabtDasteh();};
    }
    else if (noe == "searchFile")
    {
        document.querySelector("#kadrListPDF input.txtSearch").onkeydown = function (e) {if (e.keyCode == 13) searchFile();};
    }
    else if (noe == "searchBarchasb")
    {
        document.querySelector("#kadrListBarchasb input.txtSearch").onkeydown = function (e) {if (e.keyCode == 13) searchBarchasb();};
    }
    else if (noe == "virayeshBarchasb")
    {
        shomLmn = document.querySelector("#kadrListBarchasb input.txtVirayeshBarchasb").parentElement.parentElement.dataset.shom;
        idLmn = document.querySelector("#kadrListBarchasb input.txtVirayeshBarchasb").parentElement.parentElement.dataset.id;

        document.querySelectorAll("#kadrListBarchasb input.txtVirayeshBarchasb")[0].onkeydown = function (e)
        {
            if (e.keyCode == 13) taeedVirayeshBarchasb(shomLmn, idLmn);
            else if (e.keyCode == 27) laghvVirayeshBarchasb(shomLmn);
        };
    }
    else if (noe == "sabtBarchasb")
    {
        document.querySelectorAll("#kadrListBarchasb .kadrAfzoodan .meghdarEtelaatAfzoodan>input")[0].onkeydown = function (e) {if (e.keyCode == 13) sabtBarchasb();};
    }
}




/*      قسمت لیست اعضاء       */
function entekhabListAza(vaziat, noe, meghdarSearch, shomSafEntekhabi)
{
    if (vaziat === undefined) vaziat = 1;
    if (noe === undefined) noe = "hameh";
    if (meghdarSearch === undefined) meghdarSearch = "";
    if (shomSafEntekhabi === undefined) shomSafEntekhabi = 1;
    if (!mojazBeAnjamKarAst()) return;

    barresiEnterVaEsc("searchAza");

    document.querySelector(".itemMenu[data-enekhabi]").removeAttribute("data-enekhabi");
    document.querySelectorAll(".itemMenu")[0].dataset.enekhabi = "";
    document.querySelector(".kadrListha[style='display: block;']").style.display = "none";
    document.getElementById("kadrListAza").style.display = "block";
    document.querySelectorAll(".kadrAfzoodan")[0].style.display = "none";
    document.querySelectorAll(".kadrDorListha")[0].style.display = "block";
    document.getElementsByClassName("kadrDorList")[0].innerHTML = "";
    document.querySelectorAll(".kadrKolLoading")[0].style.display = "block";
    document.querySelector("#kadrListAza>.kadrPaging").style.display = "none";

    if (noe == "hameh")
    {
        document.querySelectorAll(".kadrSearch>input")[0].value = "";
        document.querySelectorAll("a.zabdarSearchShodeh")[0].style.display = "none";
    }
    else if (noe == "search")
    {
        document.querySelectorAll("a.zabdarSearchShodeh")[0].style.display = "block";
    }

    if (vaziat == 1)
    {
        document.querySelector("#kadrListAza>h2.titrKadrListha").innerHTML = "<span class='icon'></span>لیست اعضاء";
        document.querySelectorAll("#kadrListAza>a.emkanatLST")[0].style.display = "inline-block";
        document.querySelectorAll("#kadrListAza>a.emkanatLST")[1].style.display = "inline-block";
        document.querySelectorAll("#kadrListAza>a.emkanatLST")[2].style.display = "none";
        document.querySelectorAll(".kadrSearch")[0].style.display = "inline-block";
    }
    else if (vaziat == 0)
    {
        document.querySelector("#kadrListAza>h2.titrKadrListha").innerHTML = "<span class='icon'></span>لیست اعضاء حذف شده";
        document.querySelectorAll("#kadrListAza>a.emkanatLST")[0].style.display = "none";
        document.querySelectorAll("#kadrListAza>a.emkanatLST")[1].style.display = "none";
        document.querySelectorAll("#kadrListAza>a.emkanatLST")[2].style.display = "inline-block";
        document.querySelectorAll(".kadrSearch")[0].style.display = "inline-block";
    }

    var arrNoe = [vaziat, noe, meghdarSearch, shomSafEntekhabi];

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrNatijeh = JSON.parse(this.responseText);
            var tedadKolNatayej = arrNatijeh[2];
            var maxShom = Math.ceil(tedadKolNatayej / tedadNamayesh);

            if (arrNatijeh[0][0] == "ok" && arrNatijeh[0][1] == "ok")
            {
                vaziatSaf = vaziat;
                noeSaf = noe;
                meghdarSearchSaf = meghdarSearch;
                shomSaf = shomSafEntekhabi;

                var arrEtelaat = arrNatijeh[1];
                var lmnList;
                var i;

                for (i=0; i<arrEtelaat.length; i++)
                {
                    lmnList = document.createElement("div");
                    lmnList.setAttribute("class", "listha");
                    lmnList.dataset.shom = i+1;
                    lmnList.dataset.id = arrEtelaat[i]["id"];
                    lmnList.innerHTML = '' +
                        '<div class="kadrBtnEmkanatFard">' +
                            (arrEtelaat[i]["sath"]>1 && vaziat == 1 ? '<a href="javascript: void (0);" onclick="namayeshPeygham(\'پیام سیستم!\', \'آیا برای حذف اطمینان دارید؟\', 1, \'taghirVaziatOzv(' + arrEtelaat[i]["id"] + ', 0)\');" class="emkanatFard" title="حذف""><span class="icon"></span></a>' +
                                                        '<a href="javascript: void (0);" onclick="virayeshOzv(' + (i+1) + ',' + arrEtelaat[i]["id"] + ');" class="emkanatFard" title="ویرایش"><span class="icon"></span></a>' :
                                (arrEtelaat[i]["sath"]>1 && vaziat == 0 ? '<a href="javascript: void (0);" onclick="namayeshPeygham(\'پیام سیستم!\', \'آیا برای بازگرداندن عضو اطمینان دارید؟\', 1, \'taghirVaziatOzv(' + arrEtelaat[i]["id"] + ', 1)\');" class="emkanatFard" title="بازگرداندن عضو""><span class="icon"></span></a>' +
                                    '<a href="javascript: void (0);" onclick="virayeshOzv(' + (i+1) + ');" class="emkanatFard" title="ویرایش"><span class="icon"></span></a>' : '')) +
                            '<a href="javascript: void (0);" onclick="namayeshPeygham(\'پیام سیستم!\', \'آیا برای تغییر رمز عبور این کاربر اطمینان دارید؟\', 1, \'taghirPassword(' + arrEtelaat[i]["id"] + ')\');" class="emkanatFard" title="تغییر رمز عبور"><span class="icon"></span></a>' +
                            '</div>' +
                            '<div class="kadrBtnEmkanatFard kadrBtnTaeedVaLaghv" style="display: none">\n' +
                                '<a href="javascript: void (0);" onclick="taeedVirayeshOzv(' + (i+1) + ', ' + arrEtelaat[i]["id"] + ');" class="emkanatFard" title="تایید"><span class="icon"></span></a>\n' +
                                '<a href="javascript: void (0);" onclick="laghvVirayeshOzv(' + (i+1) + ');" class="emkanatFard" title="لغو"><span class="icon"></span></a>\n' +
                            '</div>\n' +
                            '<span class="etelaatFard icon"></span>\n' +
                            '<span class="etelaatFard codePerseneli">' + arrEtelaat[i]["codePerseneli"] + '</span>\n' +
                            '<span class="etelaatFard familFard">' + arrEtelaat[i]["famil"] + '</span>\n' +
                            '<span class="etelaatFard namFard">' + arrEtelaat[i]["nam"] + '</span>\n' +
                            '<span class="etelaatFard sathFard" data-sath="' + arrEtelaat[i]["sath"] + '">' + arrEtelaat[i]["namSath"] + '</span>\n' +
                        '</div>';

                    document.getElementsByClassName("kadrDorList")[0].appendChild(lmnList);
                }

                var arrBtnPaging = document.querySelectorAll("#kadrListAza>.kadrPaging a");

                if (tedadKolNatayej > tedadNamayesh)
                {
                    document.querySelector("#kadrListAza>.kadrPaging").style.display = "block";
                    arrBtnPaging[1].parentElement.parentElement.getElementsByClassName("kadrShomSaf")[0].style.borderRadius = "0px";

                    if (shomSaf > 1)
                    {
                        arrBtnPaging[0].parentElement.style.display = "table-cell";
                        arrBtnPaging[1].parentElement.style.display = "table-cell";
                        arrBtnPaging[0].setAttribute("onclick", "entekhabListAza("+ vaziatSaf +", '"+ noeSaf +"', '"+ meghdarSearchSaf +"', 1);");
                        arrBtnPaging[1].setAttribute("onclick", "entekhabListAza("+ vaziatSaf +", '"+ noeSaf +"', '"+ meghdarSearchSaf +"', "+ (shomSaf-1) +");");
                    }
                    else
                    {
                        arrBtnPaging[0].parentElement.style.display = "none";
                        arrBtnPaging[1].parentElement.style.display = "none";
                        arrBtnPaging[1].parentElement.parentElement.getElementsByClassName("kadrShomSaf")[0].style.borderRadius = "0px 10px 10px 0px";
                    }

                    if (shomSaf < maxShom)
                    {
                        arrBtnPaging[2].parentElement.style.display = "table-cell";
                        arrBtnPaging[3].parentElement.style.display = "table-cell";
                        arrBtnPaging[2].setAttribute("onclick", "entekhabListAza("+ vaziatSaf +", '"+ noeSaf +"', '"+ meghdarSearchSaf +"', "+ (shomSaf+1) +");");
                        arrBtnPaging[3].setAttribute("onclick", "entekhabListAza("+ vaziatSaf +", '"+ noeSaf +"', '"+ meghdarSearchSaf +"', "+ maxShom +");");
                    }
                    else
                    {
                        arrBtnPaging[2].parentElement.style.display = "none";
                        arrBtnPaging[3].parentElement.style.display = "none";
                        arrBtnPaging[1].parentElement.parentElement.getElementsByClassName("kadrShomSaf")[0].style.borderRadius = "10px 0px 0px 10px";
                    }

                    document.querySelector("#kadrListAza>.kadrPaging td.kadrShomSaf").innerHTML = "صفحه " + shomSaf + " از " + maxShom;
                }
            }
            else if (arrNatijeh[0][0] == "n0")
            {
                vaziatSaf = vaziat;
                noeSaf = noe;
                meghdarSearchSaf = meghdarSearch;
                shomSaf = shomSafEntekhabi;

                if (shomSafEntekhabi > maxShom) entekhabListAza(vaziat, noe, meghdarSearch, maxShom);
            }
            else
            {
                namayeshPeygham("خطای سیستم!", "لطفا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[0].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/entekhab-list-aza.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("q="+JSON.stringify(arrNoe)+"&tkA="+tkA);
}

/*    تغییر وضعیت یک عضو (حذف و برگرداندن)    */
function taghirVaziatOzv(id, vaziat)
{
    bastanPeygham();

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;

            if (JSON.parse(this.responseText)[0] == "ok")
            {
                entekhabListAza(vaziatSaf, noeSaf, meghdarSearchSaf, shomSaf);
                if (vaziat==0)
                    namayeshPeygham("حذف موفقیت آمیز بود", "از این لحظه این فرد دیگر نمیتواند به سامانه وارد شود" , 0, "", "hsl(117,100%,71%)");
                else if (vaziat==1)
                    namayeshPeygham("برگشت موفقیت آمیز بود", "این فرد میتواند به سامانه وارد شود" , 0, "", "hsl(117,100%,71%)");
            }
            else
            {
                namayeshPeygham("خطای سیستم!", "لطفا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[0].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/vaziat-ozv.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("id="+id+"&v="+vaziat+"&tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[0].style.display = "block";
}

/*    ویرایش یک عضو    */
function virayeshOzv(shom)
{
    if (!mojazBeAnjamKarAst()) return;

    codePerseneliVO = Number(document.querySelector(".listha[data-shom='"+shom+"']>.codePerseneli").innerHTML.trim());
    namVO = document.querySelector(".listha[data-shom='"+shom+"']>.namFard").innerHTML.trim();
    familVO = document.querySelector(".listha[data-shom='"+shom+"']>.familFard").innerHTML.trim();
    sathVO = Number(document.querySelector(".listha[data-shom='"+shom+"']>.sathFard").dataset.sath);

    document.querySelector(".listha[data-shom='"+shom+"']>.codePerseneli").innerHTML = '<input type="text" class="txtVirayeshOzv" name="codePerseneli" value="' + codePerseneliVO + '" placeholder="کد پرسنلی" maxlength="6" autocomplete="off"/>';
    document.querySelector(".listha[data-shom='"+shom+"']>.namFard").innerHTML = '<input type="text" class="txtVirayeshOzv" name="nam" value="' + namVO + '" placeholder="نام" maxlength="30" autocomplete="off"/>';
    document.querySelector(".listha[data-shom='"+shom+"']>.familFard").innerHTML = '<input type="text" class="txtVirayeshOzv" name="famil" value="' + familVO + '" placeholder="نام خانوادگی" maxlength="40" autocomplete="off"/>';
    document.querySelector(".listha[data-shom='"+shom+"']>.sathFard").innerHTML = '<select name="sathOzv" class="txtVirayeshOzv">' +
            '<option value="2"'+ (sathVO==2?" selected":"") +'>هیئت مدیره</option>' +
            '<option value="3"'+ (sathVO==3?" selected":"") +'>مدیران میانی</option>' +
            '<option value="4"'+ (sathVO==4?" selected":"") +'>پرسنل عادی</option>' +
        '</select>';

    document.querySelector(".listha[data-shom='"+shom+"']>.codePerseneli>input").select();

    document.querySelector(".listha[data-shom='"+shom+"']>.kadrBtnEmkanatFard").style.display = "none";
    document.querySelector(".listha[data-shom='"+shom+"']>.kadrBtnTaeedVaLaghv").style.display = "block";

    barresiEnterVaEsc("virayeshAza");
}

/*    تایید ویرایش یک عضو    */
function taeedVirayeshOzv(shom, id)
{
    var codePerseneliJadid = document.querySelector(".listha[data-shom='"+shom+"']>.codePerseneli>input").value;
    var sathJadid = document.querySelector(".listha[data-shom='"+shom+"']>.sathFard>select").value;
    var namJadid = document.querySelector(".listha[data-shom='"+shom+"']>.namFard>input").value;
    var familJadid = document.querySelector(".listha[data-shom='"+shom+"']>.familFard>input").value;

    if (isNaN(codePerseneliJadid) || codePerseneliJadid == "" || codePerseneliJadid < 100 || codePerseneliJadid > 999999)
    {
        namayeshPeygham("خطای ویرایش!", "کد پرسنلی اشتباه است", 0, "", "hsl(0,100%,68%)");
        return;
    }

    if (namJadid == "" || !farsiAst(namJadid))
    {
        namayeshPeygham("خطای ویرایش!", "نام اشتباه است (نام باید فارسی باشد)", 0, "", "hsl(0,100%,68%)");
        return;
    }

    if (familJadid == "" || !farsiAst(familJadid))
    {
        namayeshPeygham("خطای ویرایش!", "نام خانوادگی اشتباه است (نام خانوادگی باید فارسی باشد)", 0, "", "hsl(0,100%,68%)");
        return;
    }

    if (isNaN(sathJadid) || sathJadid == "" || sathJadid < 2 || sathJadid > 4)
    {
        namayeshPeygham("خطای ویرایش!", "سطح اشتباه است", 0, "", "hsl(0,100%,68%)");
        return;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrEtelaat = JSON.parse(this.responseText);

            if (arrEtelaat[0] == "er:code")
            {
                namayeshPeygham("خطای ویرایش!", "کد پرسنلی اشتباه است", 0, "", "hsl(0,100%,68%)");
            }
            else if (arrEtelaat[0] == "er:nam")
            {
                namayeshPeygham("خطای ویرایش!", "نام اشتباه است (نام باید فارسی باشد)", 0, "", "hsl(0,100%,68%)");
            }
            else if (arrEtelaat[0] == "er:famil")
            {
                namayeshPeygham("خطای ویرایش!", "نام خانوادگی اشتباه است (نام خانوادگی باید فارسی باشد)", 0, "", "hsl(0,100%,68%)");
            }
            else if (arrEtelaat[0] == "ok")
            {
                var lmnFard = document.querySelector(".listha[data-shom='"+shom+"']>.namFard>input").parentElement.parentElement;

                lmnFard.getElementsByClassName("codePerseneli")[0].innerHTML = "";
                lmnFard.getElementsByClassName("codePerseneli")[0].innerText = arrEtelaat[1];
                lmnFard.getElementsByClassName("namFard")[0].innerHTML = "";
                lmnFard.getElementsByClassName("namFard")[0].innerText = arrEtelaat[2];
                lmnFard.getElementsByClassName("familFard")[0].innerHTML = "";
                lmnFard.getElementsByClassName("familFard")[0].innerText = arrEtelaat[3];
                lmnFard.getElementsByClassName("sathFard")[0].innerHTML = "";
                if (arrEtelaat[4] == 2) lmnFard.getElementsByClassName("sathFard")[0].innerText = "هیئت مدیره";
                else if (arrEtelaat[4] == 3) lmnFard.getElementsByClassName("sathFard")[0].innerText = "مدیران میانی";
                else if (arrEtelaat[4] == 4) lmnFard.getElementsByClassName("sathFard")[0].innerText = "پرسنل عادی";

                document.querySelector(".listha[data-shom='"+shom+"']>.kadrBtnEmkanatFard").style.display = "block";
                document.querySelector(".listha[data-shom='"+shom+"']>.kadrBtnTaeedVaLaghv").style.display = "none";
            }
            else
            {
                namayeshPeygham("خطای ویرایش!", "پس از برسی مجدد اطلاعات، دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[0].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/virayesh-ozv.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("id="+id+"&cp="+codePerseneliJadid+"&na="+namJadid+"&fa="+familJadid+"&st="+sathJadid+"&tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[0].style.display = "block";
}

/*    انصراف از ویرایش یک عضو    */
function laghvVirayeshOzv(shom)
{
    document.querySelector(".listha[data-shom='"+shom+"']>.codePerseneli").innerHTML = codePerseneliVO;
    document.querySelector(".listha[data-shom='"+shom+"']>.namFard").innerHTML = namVO;
    document.querySelector(".listha[data-shom='"+shom+"']>.familFard").innerHTML = familVO;
    if (sathVO == 2) document.querySelector(".listha[data-shom='"+shom+"']>.sathFard").innerHTML = "هیئت مدیره";
    else if (sathVO == 3) document.querySelector(".listha[data-shom='"+shom+"']>.sathFard").innerHTML = "مدیران میانی";
    else if (sathVO == 4) document.querySelector(".listha[data-shom='"+shom+"']>.sathFard").innerHTML = "پرسنل عادی";

    document.querySelector(".listha[data-shom='"+shom+"']>.kadrBtnEmkanatFard").style.display = "block";
    document.querySelector(".listha[data-shom='"+shom+"']>.kadrBtnTaeedVaLaghv").style.display = "none";
}

/*    تغییر رمز عبور یک عضو    */
function taghirPassword(id)
{
    bastanPeygham();

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrEtelaat = JSON.parse(this.responseText);

            if (arrEtelaat[0] == "ok")
            {
                namayeshPeygham("تغییر رمز موفقیت آمیز بود", arrEtelaat[1] + "&nbsp&nbsp&nbsp&nbsp:رمز جدید" , 0, "", "hsl(117,100%,71%)");
            }

            document.querySelectorAll(".kadrKolLoading")[0].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/taghir-ramz.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("id="+id+"&tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[0].style.display = "block";
}

/*      باز شدن کادر افزودن عضو      */
function afzoodanOzv()
{
    document.querySelector("#kadrListAza>h2.titrKadrListha").innerHTML = "<span class='icon'></span>افزودن عضو";
    document.querySelectorAll("#kadrListAza>a.emkanatLST")[0].style.display = "none";
    document.querySelectorAll("#kadrListAza>a.emkanatLST")[1].style.display = "none";
    document.querySelectorAll("#kadrListAza>a.emkanatLST")[2].style.display = "inline-block";
    document.querySelectorAll(".kadrSearch")[0].style.display = "none";
    document.querySelectorAll(".kadrDorListha")[0].style.display = "none";
    document.querySelectorAll(".kadrPaging")[0].style.display = "none";
    document.querySelectorAll(".kadrAfzoodan")[0].style.display = "block";

    barresiEnterVaEsc("sabtAza");
}

/*  اضافه کردن عضو  */
function sabtOzv()
{
    var codePerseneli = Number(document.querySelectorAll("#kadrListAza .kadrAfzoodan input")[0].value.trim());
    var nam = document.querySelectorAll("#kadrListAza .kadrAfzoodan input")[1].value.trim();
    var famil = document.querySelectorAll("#kadrListAza .kadrAfzoodan input")[2].value.trim();
    var sath = Number(document.querySelectorAll("#kadrListAza .kadrAfzoodan select")[0].value.trim());

    if (isNaN(codePerseneli) || codePerseneli == "" || codePerseneli < 100 || codePerseneli > 999999)
    {
        namayeshPeygham("خطای ثبت!", "کد پرسنلی اشتباه است", 0, "", "hsl(0,100%,68%)");
        return;
    }

    if (nam == "" || !farsiAst(nam))
    {
        namayeshPeygham("خطای ثبت!", "نام اشتباه است (نام باید فارسی باشد)", 0, "", "hsl(0,100%,68%)");
        return;
    }

    if (famil == "" || !farsiAst(famil))
    {
        namayeshPeygham("خطای ثبت!", "نام خانوادگی اشتباه است (نام خانوادگی باید فارسی باشد)", 0, "", "hsl(0,100%,68%)");
        return;
    }

    if (isNaN(sath) || sath == "" || sath < 2 || sath > 4)
    {
        namayeshPeygham("خطای ثبت!", "سطح اشتباه است", 0, "", "hsl(0,100%,68%)");
        return;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrEtelaat = JSON.parse(this.responseText);

            if (arrEtelaat[0] == "er:code")
            {
                namayeshPeygham("خطای ثبت!", "کد پرسنلی اشتباه است", 0, "", "hsl(0,100%,68%)");
            }
            else if (arrEtelaat[0] == "er:nam")
            {
                namayeshPeygham("خطای ثبت!", "نام اشتباه است(نام باید فارسی باشد)", 0, "", "hsl(0,100%,68%)");
            }
            else if (arrEtelaat[0] == "er:famil")
            {
                namayeshPeygham("خطای ثبت!", "نام خانوادگی اشتباه است(نام خانوادگی باید فارسی باشد)", 0, "", "hsl(0,100%,68%)");
            }
            else if (arrEtelaat[0] == "ok")
            {
                namayeshPeygham("ثبت عضو موفقیت آمیز بود", arrEtelaat[1] + "&nbsp&nbsp&nbsp&nbsp:رمز این عضو" , 0, "", "hsl(117,100%,71%)");
                document.querySelectorAll("#kadrListAza .kadrAfzoodan input")[0].value = "";
                document.querySelectorAll("#kadrListAza .kadrAfzoodan input")[1].value = "";
                document.querySelectorAll("#kadrListAza .kadrAfzoodan input")[2].value = "";
            }
            else
            {
                namayeshPeygham("خطای ثبت!", "پس از برسی مجدد اطلاعات، دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[0].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/sabt-ozv.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("cp="+codePerseneli+"&na="+nam+"&fa="+famil+"&st="+sath+"&tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[0].style.display = "block";
}

/*  سرچ کردن بین اعضا   */
function searchAza()
{
    var matnJostojoo = document.querySelectorAll(".kadrSearch>input")[0].value.trim();
    if (matnJostojoo == "") return;
    if (!farsiAst(matnJostojoo))
    {
        namayeshPeygham("خطای جستجو!", "لطفا متن فارسی وارد کنید", 0, "", "hsl(0,100%,68%)");
        return;
    }

    noeSaf = "search";
    meghdarSearchSaf = matnJostojoo;
    shomSaf = 1;
    entekhabListAza(vaziatSaf, noeSaf, meghdarSearchSaf, shomSaf);
}




/*      قسمت دسته بندی ها       */
function entekhabListDasehBandi(vaziat, noe, meghdarSearch, shomSafEntekhabi)
{
    if (vaziat === undefined) vaziat = 1;
    if (noe === undefined) noe = "hameh";
    if (meghdarSearch === undefined) meghdarSearch = "";
    if (shomSafEntekhabi === undefined) shomSafEntekhabi = 1;
    if (!mojazBeAnjamKarAst()) return;

    barresiEnterVaEsc("searchDasteh");

    document.querySelector(".itemMenu[data-enekhabi]").removeAttribute("data-enekhabi");
    document.querySelectorAll(".itemMenu")[1].dataset.enekhabi = "";
    document.querySelector(".kadrListha[style='display: block;']").style.display = "none";
    document.getElementById("kadrListDasteh").style.display = "block";
    document.querySelectorAll(".kadrAfzoodan")[1].style.display = "none";
    document.querySelectorAll(".kadrDorListha")[1].style.display = "block";
    document.getElementsByClassName("kadrDorList")[1].innerHTML = "";
    document.querySelectorAll(".kadrKolLoading")[1].style.display = "block";
    document.querySelector("#kadrListDasteh>.kadrPaging").style.display = "none";

    if (noe == "hameh")
    {
        document.querySelectorAll(".kadrSearch>input")[1].value = "";
        document.querySelectorAll("a.zabdarSearchShodeh")[1].style.display = "none";
    }
    else if (noe == "search")
    {
        document.querySelectorAll("a.zabdarSearchShodeh")[1].style.display = "block";
    }

    if (vaziat == 1)
    {
        document.querySelector("#kadrListDasteh>h2.titrKadrListha").innerHTML = "<span class='icon'></span>موضوعات";
        document.querySelectorAll("#kadrListDasteh>a.emkanatLST")[0].style.display = "inline-block";
        document.querySelectorAll("#kadrListDasteh>a.emkanatLST")[1].style.display = "inline-block";
        document.querySelectorAll("#kadrListDasteh>a.emkanatLST")[2].style.display = "none";
        document.querySelectorAll(".kadrSearch")[1].style.display = "inline-block";
    }
    else if (vaziat == 0)
    {
        document.querySelector("#kadrListDasteh>h2.titrKadrListha").innerHTML = "<span class='icon'></span>موضوعات حذف شده";
        document.querySelectorAll("#kadrListDasteh>a.emkanatLST")[0].style.display = "none";
        document.querySelectorAll("#kadrListDasteh>a.emkanatLST")[1].style.display = "none";
        document.querySelectorAll("#kadrListDasteh>a.emkanatLST")[2].style.display = "inline-block";
        document.querySelectorAll(".kadrSearch")[1].style.display = "inline-block";
    }

    var arrNoe = [vaziat, noe, meghdarSearch, shomSafEntekhabi];

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrNatijeh = JSON.parse(this.responseText);
            var tedadKolNatayej = arrNatijeh[2];
            var maxShom = Math.ceil(tedadKolNatayej / tedadNamayesh);

            if (arrNatijeh[0][0] == "ok" && arrNatijeh[0][1] == "ok")
            {
                vaziatSaf = vaziat;
                noeSaf = noe;
                meghdarSearchSaf = meghdarSearch;
                shomSaf = shomSafEntekhabi;

                var arrEtelaat = arrNatijeh[1];
                var lmnList;
                var i;

                for (i=0; i<arrEtelaat.length; i++)
                {
                    lmnList = document.createElement("div");
                    lmnList.setAttribute("class", "dastehha");
                    lmnList.dataset.shom = i+1;
                    lmnList.dataset.id = arrEtelaat[i]["id"];
                    lmnList.innerHTML = '' +
                        '<div class="kadrBtnEmkanatFard">\n' +
                            (vaziat == 1 ? '<a href="javascript: void (0);" onclick="namayeshPeygham(\'پیام سیستم!\', \'آیا برای حذف اطمینان دارید؟\', 1, \'taghirVaziatDasteh(' + arrEtelaat[i]["id"] + ', 0)\');" class="emkanatFard" title="حذف""><span class="icon"></span></a>' :
                                (vaziat == 0 ? '<a href="javascript: void (0);" onclick="namayeshPeygham(\'پیام سیستم!\', \'آیا برای بازگرداندن موضوع اطمینان دارید؟\', 1, \'taghirVaziatDasteh(' + arrEtelaat[i]["id"] + ', 1)\');" class="emkanatFard" title="بازگرداندن موضوع""><span class="icon"></span></a>' : '')) +
                            '<a href="javascript: void (0);" onclick="virayeshDasteh(' + (i+1) + ');" class="emkanatFard" title="ویرایش"><span class="icon"></span></a>\n' +
                            '<a href="javascript: void (0);" onclick="entekhabListFileha(1,\'dasteh\',' + arrEtelaat[i]["id"] + ',1)" class="emkanatFard" title="فایل های این موضوع"><span class="icon"></span></a>\n' +
                            '<a href="javascript: void (0);" onclick="namayeshBarchasbhaDasteh(' + (i+1) + ',' + arrEtelaat[i]["id"] + ');" class="emkanatFard" title="برچسب های این موضوع"><span class="icon"></span></a>\n' +
                        '</div>\n' +
                        '<div class="kadrBtnEmkanatFard kadrBtnTaeedVaLaghv" style="display: none">\n' +
                            '<a href="javascript: void (0);" onclick="taeedVirayeshDasteh(' + (i+1) + ', ' + arrEtelaat[i]["id"] + ');" class="emkanatFard" title="تایید"><span class="icon"></span></a>\n' +
                            '<a href="javascript: void (0);" onclick="laghvVirayeshDasteh(' + (i+1) + ');" class="emkanatFard" title="لغو"><span class="icon"></span></a>\n' +
                        '</div>\n' +
                        '<div class="kadrBtnEmkanatFard kadrBtnTaeedVaLaghvBarchasbDasteh" style="display: none">\n' +
                            '<a href="javascript: void (0);" onclick="taeedVirayeshBarchasbDasteh(' + (i+1) + ', ' + arrEtelaat[i]["id"] + ');" class="emkanatFard" title="تایید"><span class="icon"></span></a>\n' +
                            '<a href="javascript: void (0);" onclick="laghvVirayeshBarchasbDasteh(' + (i+1) + ');" class="emkanatFard" title="لغو"><span class="icon"></span></a>\n' +
                        '</div>\n' +
                        '<span class="etelaatFard icon"></span>\n' +
                        '<span class="dasteh">' + arrEtelaat[i]["dasteh"] + '</span>\n' +
                        '<span class="sathDasteh" data-sath="' + arrEtelaat[i]["sath"] + '">' + arrEtelaat[i]["namSath"] + '</span>\n' +
                        '<div class="kadrBarchasbhaDasteh"></div>';

                    document.getElementsByClassName("kadrDorList")[1].appendChild(lmnList);
                }

                var arrBtnPaging = document.querySelectorAll("#kadrListDasteh>.kadrPaging a");

                if (tedadKolNatayej > tedadNamayesh)
                {
                    document.querySelector("#kadrListDasteh>.kadrPaging").style.display = "block";
                    arrBtnPaging[1].parentElement.parentElement.getElementsByClassName("kadrShomSaf")[0].style.borderRadius = "0px";

                    if (shomSaf > 1)
                    {
                        arrBtnPaging[0].parentElement.style.display = "table-cell";
                        arrBtnPaging[1].parentElement.style.display = "table-cell";
                        arrBtnPaging[0].setAttribute("onclick", "entekhabListDasehBandi("+ vaziatSaf +", '"+ noeSaf +"', '"+ meghdarSearchSaf +"', 1);");
                        arrBtnPaging[1].setAttribute("onclick", "entekhabListDasehBandi("+ vaziatSaf +", '"+ noeSaf +"', '"+ meghdarSearchSaf +"', "+ (shomSaf-1) +");");
                    }
                    else
                    {
                        arrBtnPaging[0].parentElement.style.display = "none";
                        arrBtnPaging[1].parentElement.style.display = "none";
                        arrBtnPaging[1].parentElement.parentElement.getElementsByClassName("kadrShomSaf")[0].style.borderRadius = "0px 10px 10px 0px";
                    }

                    if (shomSaf < maxShom)
                    {
                        arrBtnPaging[2].parentElement.style.display = "table-cell";
                        arrBtnPaging[3].parentElement.style.display = "table-cell";
                        arrBtnPaging[2].setAttribute("onclick", "entekhabListDasehBandi("+ vaziatSaf +", '"+ noeSaf +"', '"+ meghdarSearchSaf +"', "+ (shomSaf+1) +");");
                        arrBtnPaging[3].setAttribute("onclick", "entekhabListDasehBandi("+ vaziatSaf +", '"+ noeSaf +"', '"+ meghdarSearchSaf +"', "+ maxShom +");");
                    }
                    else
                    {
                        arrBtnPaging[2].parentElement.style.display = "none";
                        arrBtnPaging[3].parentElement.style.display = "none";
                        arrBtnPaging[1].parentElement.parentElement.getElementsByClassName("kadrShomSaf")[0].style.borderRadius = "10px 0px 0px 10px";
                    }

                    document.querySelector("#kadrListDasteh>.kadrPaging td.kadrShomSaf").innerHTML = "صفحه " + shomSaf + " از " + maxShom;
                }
            }
            else if (arrNatijeh[0][0] == "n0")
            {
                vaziatSaf = vaziat;
                noeSaf = noe;
                meghdarSearchSaf = meghdarSearch;
                shomSaf = shomSafEntekhabi;

                if (shomSafEntekhabi > maxShom) entekhabListDasehBandi(vaziat, noe, meghdarSearch, maxShom);
            }
            else
            {
                namayeshPeygham("خطای سیستم!", "لطفا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[1].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/entekhab-dasteh-bandi.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("q="+JSON.stringify(arrNoe)+"&tkA="+tkA);
}

/*    تغییر وضعیت یک دسته (حذف و برگرداندن)    */
function taghirVaziatDasteh(id, vaziat)
{
    bastanPeygham();

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;

            if (JSON.parse(this.responseText)[0] == "ok")
            {
                entekhabListDasehBandi(vaziatSaf, noeSaf, meghdarSearchSaf, shomSaf);
                if (vaziat==0)
                    namayeshPeygham("حذف موفقیت آمیز بود", "فایل های این موضوع دیگر قابل رویت توسط اعضا نیستند" , 0, "", "hsl(117,100%,71%)");
                else if (vaziat==1)
                    namayeshPeygham("برگشت موفقیت آمیز بود", "فایل های این موضوع قابل رویت توسط اعضا شد" , 0, "", "hsl(117,100%,71%)");
            }
            else
            {
                namayeshPeygham("خطای سیستم!", "لطفا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[1].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/vaziat-dsteh.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("id="+id+"&v="+vaziat+"&tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[1].style.display = "block";
}

/*  دیدن برچسب ها و ویرایش برچسب های دسته   */
function namayeshBarchasbhaDasteh(shom, idDasteh)
{
    if (!mojazBeAnjamKarAst()) return;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;

            var arrNatijeh = JSON.parse(this.responseText);
            var arrKolBarchasbha = arrNatijeh[1];
            var arrBarchasbhaDasteh = arrNatijeh[2];
            var i;

            if (arrNatijeh[0] == "ok")
            {
                document.querySelectorAll("#kadrListDasteh .dastehha[data-shom='"+shom+"'] .kadrBtnEmkanatFard")[0].style.display = "none";
                document.querySelector("#kadrListDasteh .dastehha[data-shom='"+shom+"'] .kadrBtnTaeedVaLaghvBarchasbDasteh").style.display = "block";
                document.querySelector("#kadrListDasteh .dastehha[data-shom='"+shom+"'] .kadrBarchasbhaDasteh").style.display = "block";
                document.querySelector("#kadrListDasteh .dastehha[data-shom='"+shom+"'] .kadrBarchasbhaDasteh").innerHTML = "";
                document.querySelector("#kadrListDasteh .dastehha[data-shom='"+shom+"'] .kadrBarchasbhaDasteh").dataset.bazAst = "";
                for (i=0; i<arrKolBarchasbha.length; i++)
                {
                    document.querySelector("#kadrListDasteh .dastehha[data-shom='"+shom+"'] .kadrBarchasbhaDasteh").innerHTML += "<a href='javascript:void (0)' class='joziat' onclick='entekhabBarchasbDasteh(this)' data-id='"+arrKolBarchasbha[i]["id"]+"'><span class='icon'></span>"+arrKolBarchasbha[i]["barchasb"]+"</a>";
                }

                for (i=0; i<arrBarchasbhaDasteh.length; i++)
                {
                    document.querySelector("#kadrListDasteh a.joziat[data-id='"+arrBarchasbhaDasteh[i]["id"]+"']").dataset.entekhabi = "";
                    document.querySelector("#kadrListDasteh a.joziat[data-id='"+arrBarchasbhaDasteh[i]["id"]+"'] span.icon").innerHTML = "";
                }
            }
            else
            {
                namayeshPeygham("خطای سیستم!", "لطفا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[1].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/barchasbha-dasteh.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("id="+idDasteh+"&tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[1].style.display = "block";
}

/*    تایید ویرایش برچسب های یک دسته    */
function taeedVirayeshBarchasbDasteh(shom, id)
{
    var i;
    var arrBarchasbha = document.querySelectorAll("#kadrListDasteh .dastehha[data-shom='"+shom+"'] a.joziat[data-entekhabi]");
    var arrIdBarchasbha = [];
    for (i=0; i<arrBarchasbha.length; i++)
    {
        arrIdBarchasbha.push(arrBarchasbha[i].dataset.id)
    }

    var etelaat = [id, arrIdBarchasbha];

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrEtelaat = JSON.parse(this.responseText);

            if (arrEtelaat[0] == "ok")
            {
                laghvVirayeshBarchasbDasteh(shom);
                namayeshPeygham("ویرایش موفقیت آمیز بود", "برچسب های این موضوع بروز شد", 0, "", "hsl(117,100%,71%)");
            }
            else
            {
                namayeshPeygham("خطای ثبت!", "پس از برسی مجدد اطلاعات، دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[1].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/virayesh-barchasbha-dasteh.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("q="+JSON.stringify(etelaat)+"&tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[1].style.display = "block";
}

/*    انصراف از ویرایش برچسب های یک دسته    */
function laghvVirayeshBarchasbDasteh(shom)
{
    document.querySelectorAll("#kadrListDasteh .dastehha[data-shom='"+shom+"'] .kadrBtnEmkanatFard")[0].style.display = "block";
    document.querySelector("#kadrListDasteh .dastehha[data-shom='"+shom+"'] .kadrBtnTaeedVaLaghvBarchasbDasteh").style.display = "none";
    document.querySelector("#kadrListDasteh .dastehha[data-shom='"+shom+"'] .kadrBarchasbhaDasteh").style.display = "none";
    document.querySelector("#kadrListDasteh .dastehha[data-shom='"+shom+"'] .kadrBarchasbhaDasteh").innerHTML = "";
    delete document.querySelector("#kadrListDasteh .dastehha[data-shom='"+shom+"'] .kadrBarchasbhaDasteh").dataset.bazAst;
}

/*    ویرایش یک دسته    */
function virayeshDasteh(shom)
{
    if (!mojazBeAnjamKarAst()) return;

    dastehVD = document.querySelector(".dastehha[data-shom='"+shom+"']>.dasteh").innerHTML.trim();
    sathVD = Number(document.querySelector(".dastehha[data-shom='"+shom+"']>.sathDasteh").dataset.sath);

    document.querySelector(".dastehha[data-shom='"+shom+"']>.dasteh").innerHTML = '<input type="text" class="txtVirayeshDasteh" name="daseh" value="' + dastehVD + '" placeholder="نام موضوع" autocomplete="off"/>';
    document.querySelector(".dastehha[data-shom='"+shom+"']>.sathDasteh").innerHTML = '<select name="sathOzv" class="txtVirayeshDasteh">' +
        '<option value="2"'+ (sathVD==2?" selected":"") +'>هیئت مدیره</option>' +
        '<option value="3"'+ (sathVD==3?" selected":"") +'>مدیران میانی</option>' +
        '<option value="4"'+ (sathVD==4?" selected":"") +'>پرسنل عادی</option>' +
        '</select>';

    document.querySelector(".dastehha[data-shom='"+shom+"']>.dasteh>input").select();

    document.querySelector(".dastehha[data-shom='"+shom+"']>.kadrBtnEmkanatFard").style.display = "none";
    document.querySelector(".dastehha[data-shom='"+shom+"']>.kadrBtnTaeedVaLaghv").style.display = "block";

    barresiEnterVaEsc("virayeshDasteh");
}

/*    تایید ویرایش یک دسته    */
function taeedVirayeshDasteh(shom, id)
{
    var dasehJadid = document.querySelector(".dastehha[data-shom='"+shom+"']>.dasteh>input").value;
    var sathJadid = document.querySelector(".dastehha[data-shom='"+shom+"']>.sathDasteh>select").value;

    if (dasehJadid == "")
    {
        namayeshPeygham("خطای ویرایش!", "نام موضوع اشتباه است", 0, "", "hsl(0,100%,68%)");
        return;
    }

    if (isNaN(sathJadid) || sathJadid == "" || sathJadid < 2 || sathJadid > 4)
    {
        namayeshPeygham("خطای ویرایش!", "سطح اشتباه است", 0, "", "hsl(0,100%,68%)");
        return;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrEtelaat = JSON.parse(this.responseText);

            if (arrEtelaat[0] == "er:dasteh")
            {
                namayeshPeygham("خطای ویرایش!", "نام موضوع اشتباه است", 0, "", "hsl(0,100%,68%)");
            }
            else if (arrEtelaat[0] == "ok")
            {
                var lmnDasteh = document.querySelector(".dastehha[data-shom='"+shom+"']>.dasteh>input").parentElement.parentElement;

                lmnDasteh.getElementsByClassName("dasteh")[0].innerHTML = "";
                lmnDasteh.getElementsByClassName("dasteh")[0].innerText = arrEtelaat[1];
                lmnDasteh.getElementsByClassName("sathDasteh")[0].innerHTML = "";
                if (arrEtelaat[2] == 2) lmnDasteh.getElementsByClassName("sathDasteh")[0].innerText = "هیئت مدیره";
                else if (arrEtelaat[2] == 3) lmnDasteh.getElementsByClassName("sathDasteh")[0].innerText = "مدیران میانی";
                else if (arrEtelaat[2] == 4) lmnDasteh.getElementsByClassName("sathDasteh")[0].innerText = "پرسنل عادی";

                document.querySelector(".dastehha[data-shom='"+shom+"']>.kadrBtnEmkanatFard").style.display = "block";
                document.querySelector(".dastehha[data-shom='"+shom+"']>.kadrBtnTaeedVaLaghv").style.display = "none";
            }
            else
            {
                namayeshPeygham("خطای ویرایش!", "پس از برسی مجدد اطلاعات، دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[1].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/virayesh-dasteh.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("id="+id+"&ds="+dasehJadid+"&st="+sathJadid+"&tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[1].style.display = "block";
}

/*    انصراف از ویرایش یک دسته    */
function laghvVirayeshDasteh(shom)
{
    document.querySelector(".dastehha[data-shom='"+shom+"']>.dasteh").innerHTML = dastehVD;
    if (sathVD == 2) document.querySelector(".dastehha[data-shom='"+shom+"']>.sathDasteh").innerHTML = "هیئت مدیره";
    else if (sathVD == 3) document.querySelector(".dastehha[data-shom='"+shom+"']>.sathDasteh").innerHTML = "مدیران میانی";
    else if (sathVD == 4) document.querySelector(".dastehha[data-shom='"+shom+"']>.sathDasteh").innerHTML = "پرسنل عادی";

    document.querySelector(".dastehha[data-shom='"+shom+"']>.kadrBtnEmkanatFard").style.display = "block";
    document.querySelector(".dastehha[data-shom='"+shom+"']>.kadrBtnTaeedVaLaghv").style.display = "none";
}

/*      باز شدن کادر افزودن یک دسته بندی     */
function afzoodanDasteh()
{
    document.querySelector("#kadrListDasteh>h2.titrKadrListha").innerHTML = "<span class='icon'></span>افزودن موضوع";
    document.querySelectorAll("#kadrListDasteh>a.emkanatLST")[0].style.display = "none";
    document.querySelectorAll("#kadrListDasteh>a.emkanatLST")[1].style.display = "none";
    document.querySelectorAll("#kadrListDasteh>a.emkanatLST")[2].style.display = "inline-block";
    document.querySelectorAll(".kadrSearch")[1].style.display = "none";
    document.querySelectorAll(".kadrDorListha")[1].style.display = "none";
    document.querySelectorAll(".kadrPaging")[1].style.display = "none";
    document.querySelectorAll(".kadrAfzoodan")[1].style.display = "block";

    barresiEnterVaEsc("sabtDasteh");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrEtelaat = JSON.parse(this.responseText);

            if (arrEtelaat[0][0] == "ok")
            {
                var lmnJoziat = document.querySelector("#kadrListDasteh .kadrDorJoziat");
                lmnJoziat.innerHTML = "";
                for (var i=0; i<arrEtelaat[1].length; i++)
                {
                    lmnJoziat.innerHTML += "<a href='javascript:void (0);' onclick='entekhabBarchasbDasteh(this);' class='joziat' data-id='" + arrEtelaat[1][i]['id'] + "'><span class='icon'></span>" + arrEtelaat[1][i]['barchasb'] + "</a>";
                }
            }
            else
            {
                entekhabListDasehBandi();
                namayeshPeygham("خطای سیستم!", "لطفا بعدا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[1].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/gereftan-barchasbha.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[1].style.display = "block";
}

/*   انتخاب کردن برچسب برای دسته بندی جدید    */
function entekhabBarchasbDasteh(lmn)
{
    if (lmn.dataset.entekhabi === undefined)
    {
        lmn.dataset.entekhabi = "";
        lmn.getElementsByClassName("icon")[0].innerHTML = "";
    }
    else
    {
        delete lmn.dataset.entekhabi;
        lmn.getElementsByClassName("icon")[0].innerHTML = "";
    }
}

/*    ثبت یک دسته جدید    */
function sabtDasteh()
{
    var i;
    var dasteh = document.querySelectorAll("#kadrListDasteh .kadrAfzoodan input")[0].value.trim();
    var sath = Number(document.querySelectorAll("#kadrListDasteh .kadrAfzoodan select")[0].value.trim());

    var arrBarchasbha = document.querySelectorAll("#kadrListDasteh .kadrAfzoodan a.joziat[data-entekhabi]");
    var arrIdBarchasbha = [];
    for (i=0; i<arrBarchasbha.length; i++)
    {
        arrIdBarchasbha.push(arrBarchasbha[i].dataset.id)
    }

    if (dasteh == "")
    {
        namayeshPeygham("خطای ثبت!", "نام موضوع اشتباه است", 0, "", "hsl(0,100%,68%)");
        return;
    }

    if (isNaN(sath) || sath == "" || sath < 2 || sath > 4)
    {
        namayeshPeygham("خطای ثبت!", "سطح اشتباه است", 0, "", "hsl(0,100%,68%)");
        return;
    }

    var etelaat = [dasteh, sath, arrIdBarchasbha];

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrEtelaat = JSON.parse(this.responseText);

            if (arrEtelaat[0] == "er:dasteh")
            {
                namayeshPeygham("خطای ثبت!", "نام موضوع اشتباه است", 0, "", "hsl(0,100%,68%)");
            }
            else if (arrEtelaat[0] == "ok")
            {
                namayeshPeygham("ثبت دسته موفقیت آمیز بود", "اکنون می توانید به این موضوع فایل اضافه کنید", 0, "", "hsl(117,100%,71%)");
                document.querySelectorAll("#kadrListDasteh .kadrAfzoodan input")[0].value = "";

                var arrBarchasbhayeEntekhabi = document.querySelectorAll("#kadrListBarchasb a.joziat[data-entekhabi]");
                for (i=0; i<arrBarchasbhayeEntekhabi.length; i++)
                {
                    delete arrBarchasbhayeEntekhabi[i].dataset.entekhabi;
                    arrBarchasbhayeEntekhabi[i].getElementsByClassName("icon")[0].innerHTML = "";
                }
            }
            else
            {
                namayeshPeygham("خطای ثبت!", "پس از برسی مجدد اطلاعات، دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[1].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/sabt-dasteh.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("q="+JSON.stringify(etelaat)+"&tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[1].style.display = "block";
}

/*  جستجو بین دسته بندی ها  */
function searchDasteh()
{
    var matnJostojoo = document.querySelectorAll(".kadrSearch>input")[1].value.trim();
    if (matnJostojoo == "") return;

    noeSaf = "search";
    meghdarSearchSaf = matnJostojoo;
    shomSaf = 1;
    entekhabListDasehBandi(vaziatSaf, noeSaf, meghdarSearchSaf, shomSaf);
}




/*      قسمت فایل ها       */
function entekhabListFileha(vaziat, noe, meghdarSearch, shomSafEntekhabi)
{
    if (vaziat === undefined) vaziat = 1;
    if (noe === undefined) noe = "hameh";
    if (meghdarSearch === undefined) meghdarSearch = "";
    if (shomSafEntekhabi === undefined) shomSafEntekhabi = 1;
    if (!mojazBeAnjamKarAst()) return;

    barresiEnterVaEsc("searchFile");

    document.querySelector(".itemMenu[data-enekhabi]").removeAttribute("data-enekhabi");
    document.querySelectorAll(".itemMenu")[2].dataset.enekhabi = "";
    document.querySelector(".kadrListha[style='display: block;']").style.display = "none";
    document.getElementById("kadrListPDF").style.display = "block";
    document.querySelectorAll(".kadrAfzoodan")[2].style.display = "none";
    document.querySelectorAll(".kadrDorListha")[2].style.display = "block";
    document.getElementsByClassName("kadrDorList")[2].innerHTML = "";
    document.querySelectorAll(".kadrKolLoading")[2].style.display = "block";
    document.querySelector("#kadrListPDF>.kadrPaging").style.display = "none";

    if (noe == "hameh")
    {
        document.querySelectorAll(".kadrSearch>input")[2].value = "";
        document.querySelectorAll("a.zabdarSearchShodeh")[2].style.display = "none";
    }
    else if (noe == "search")
    {
        document.querySelectorAll("a.zabdarSearchShodeh")[2].style.display = "block";
    }

    if (vaziat == 1)
    {
        document.querySelector("#kadrListPDF>h2.titrKadrListha").innerHTML = "<span class='icon'></span>فایل ها";
        document.querySelectorAll("#kadrListPDF>a.emkanatLST")[0].style.display = "inline-block";
        document.querySelectorAll("#kadrListPDF>a.emkanatLST")[1].style.display = "inline-block";
        document.querySelectorAll("#kadrListPDF>a.emkanatLST")[2].style.display = "none";
        document.querySelectorAll(".kadrSearch")[2].style.display = "inline-block";
    }
    else if (vaziat == 0)
    {
        document.querySelector("#kadrListPDF>h2.titrKadrListha").innerHTML = "<span class='icon'></span>فایل های حذف شده";
        document.querySelectorAll("#kadrListPDF>a.emkanatLST")[0].style.display = "none";
        document.querySelectorAll("#kadrListPDF>a.emkanatLST")[1].style.display = "none";
        document.querySelectorAll("#kadrListPDF>a.emkanatLST")[2].style.display = "inline-block";
        document.querySelectorAll(".kadrSearch")[2].style.display = "inline-block";
    }

    if (noe == "dasteh")
    {
        document.querySelector("#kadrListPDF>h2.titrKadrListha").innerHTML = "<span class='icon'></span>فایل های دسته انتخابی";
        document.querySelectorAll("#kadrListPDF>a.emkanatLST")[1].style.display = "none";
        document.querySelectorAll(".kadrSearch")[2].style.display = "none";
    }

    var arrNoe = [vaziat, noe, meghdarSearch, shomSafEntekhabi];

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrNatijeh = JSON.parse(this.responseText);
            var tedadKolNatayej = arrNatijeh[2];
            var maxShom = Math.ceil(tedadKolNatayej / tedadNamayesh);

            if (arrNatijeh[0][0] == "ok" && arrNatijeh[0][1] == "ok")
            {
                vaziatSaf = vaziat;
                noeSaf = noe;
                meghdarSearchSaf = meghdarSearch;
                shomSaf = shomSafEntekhabi;

                var arrEtelaat = arrNatijeh[1];
                var lmnList;
                var i;

                for (i=0; i<arrEtelaat.length; i++)
                {
                    lmnList = document.createElement("div");
                    lmnList.setAttribute("class", "pdfha");
                    lmnList.dataset.shom = i+1;
                    lmnList.innerHTML = '' +
                        '<div class="kadrBtnEmkanatFard">\n' +
                        (vaziat == 1 ? '<a href="javascript: void (0);" onclick="namayeshPeygham(\'پیام سیستم!\', \'آیا برای حذف اطمینان دارید؟\', 1, \'taghirVaziatFile(' + arrEtelaat[i]["id"] + ', 0)\');" class="emkanatFard" title="حذف""><span class="icon"></span></a>' :
                            (vaziat == 0 ? '<a href="javascript: void (0);" onclick="namayeshPeygham(\'پیام سیستم!\', \'آیا برای بازگرداندن فایل اطمینان دارید؟\', 1, \'taghirVaziatFile(' + arrEtelaat[i]["id"] + ', 1)\');" class="emkanatFard" title="بازگرداندن فایل""><span class="icon"></span></a>' : '')) +
                            '<a href="javascript: void (0);" onclick="namayeshPDF(' + arrEtelaat[i]["id"] + ');" class="emkanatFard" title="مشاهده"><span class="icon"></span></a>\n' +
                        '</div>\n' +
                        '<span class="etelaatFard icon"></span>\n' +
                        '<span class="dasteh">' + arrEtelaat[i]["dasteh"] + '</span>\n' +
                        '<span class="tarikhErsal">' + arrEtelaat[i]["tarikhErsal"] + '</span>\n' +
                        '<span class="zamanErsal">' + arrEtelaat[i]["zamanErsal"] + '</span>';

                    document.getElementsByClassName("kadrDorList")[2].appendChild(lmnList);
                }

                var arrBtnPaging = document.querySelectorAll("#kadrListPDF>.kadrPaging a");

                if (tedadKolNatayej > tedadNamayesh)
                {
                    document.querySelector("#kadrListPDF>.kadrPaging").style.display = "block";
                    arrBtnPaging[1].parentElement.parentElement.getElementsByClassName("kadrShomSaf")[0].style.borderRadius = "0px";

                    if (shomSaf > 1)
                    {
                        arrBtnPaging[0].parentElement.style.display = "table-cell";
                        arrBtnPaging[1].parentElement.style.display = "table-cell";
                        arrBtnPaging[0].setAttribute("onclick", "entekhabListFileha("+ vaziatSaf +", '"+ noeSaf +"', '"+ meghdarSearchSaf +"', 1);");
                        arrBtnPaging[1].setAttribute("onclick", "entekhabListFileha("+ vaziatSaf +", '"+ noeSaf +"', '"+ meghdarSearchSaf +"', "+ (shomSaf-1) +");");
                    }
                    else
                    {
                        arrBtnPaging[0].parentElement.style.display = "none";
                        arrBtnPaging[1].parentElement.style.display = "none";
                        arrBtnPaging[1].parentElement.parentElement.getElementsByClassName("kadrShomSaf")[0].style.borderRadius = "0px 10px 10px 0px";
                    }

                    if (shomSaf < maxShom)
                    {
                        arrBtnPaging[2].parentElement.style.display = "table-cell";
                        arrBtnPaging[3].parentElement.style.display = "table-cell";
                        arrBtnPaging[2].setAttribute("onclick", "entekhabListFileha("+ vaziatSaf +", '"+ noeSaf +"', '"+ meghdarSearchSaf +"', "+ (shomSaf+1) +");");
                        arrBtnPaging[3].setAttribute("onclick", "entekhabListFileha("+ vaziatSaf +", '"+ noeSaf +"', '"+ meghdarSearchSaf +"', "+ maxShom +");");
                    }
                    else
                    {
                        arrBtnPaging[2].parentElement.style.display = "none";
                        arrBtnPaging[3].parentElement.style.display = "none";
                        arrBtnPaging[1].parentElement.parentElement.getElementsByClassName("kadrShomSaf")[0].style.borderRadius = "10px 0px 0px 10px";
                    }

                    document.querySelector("#kadrListPDF>.kadrPaging td.kadrShomSaf").innerHTML = "صفحه " + shomSaf + " از " + maxShom;
                }
            }
            else if (arrNatijeh[0][0] == "n0")
            {
                vaziatSaf = vaziat;
                noeSaf = noe;
                meghdarSearchSaf = meghdarSearch;
                shomSaf = shomSafEntekhabi;

                if (shomSafEntekhabi > maxShom) entekhabListFileha(vaziat, noe, meghdarSearch, maxShom);
            }
            else
            {
                namayeshPeygham("خطای سیستم!", "لطفا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[2].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/entekhab-fileha.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("q="+JSON.stringify(arrNoe)+"&tkA="+tkA);
}

/*    تغییر وضعیت یک فایل (حذف و برگرداندن)    */
function taghirVaziatFile(id, vaziat)
{
    bastanPeygham();

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;

            if (JSON.parse(this.responseText)[0] == "ok")
            {
                entekhabListFileha(vaziatSaf, noeSaf, meghdarSearchSaf, shomSaf);
                if (vaziat==0)
                    namayeshPeygham("حذف موفقیت آمیز بود", "این فایل دیگر قابل رویت توسط اعضا نیستند" , 0, "", "hsl(117,100%,71%)");
                else if (vaziat==1)
                    namayeshPeygham("برگشت موفقیت آمیز بود", "این فایل قابل رویت توسط اعضا شد" , 0, "", "hsl(117,100%,71%)");
            }
            else
            {
                namayeshPeygham("خطای سیستم!", "لطفا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[2].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/vaziat-file.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("id="+id+"&v="+vaziat+"&tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[2].style.display = "block";
}

/*  جستجو بین فایل ها  */
function searchFile()
{
    var matnJostojoo = document.querySelectorAll(".kadrSearch>input")[2].value.trim();
    if (matnJostojoo == "") return;

    noeSaf = "search";
    meghdarSearchSaf = matnJostojoo;
    shomSaf = 1;
    entekhabListFileha(vaziatSaf, noeSaf, meghdarSearchSaf, shomSaf);
}

/*      باز شدن کادر افزودن یک فایل     */
function afzoodanFile()
{
    document.querySelector("#kadrListPDF>h2.titrKadrListha").innerHTML = "<span class='icon'></span>افزودن فایل";
    document.querySelectorAll("#kadrListPDF>a.emkanatLST")[0].style.display = "none";
    document.querySelectorAll("#kadrListPDF>a.emkanatLST")[1].style.display = "none";
    document.querySelectorAll("#kadrListPDF>a.emkanatLST")[2].style.display = "inline-block";
    document.querySelectorAll(".kadrSearch")[2].style.display = "none";
    document.querySelectorAll(".kadrDorListha")[2].style.display = "none";
    document.querySelectorAll(".kadrPaging")[2].style.display = "none";
    document.querySelectorAll(".kadrAfzoodan")[2].style.display = "block";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrEtelaat = JSON.parse(this.responseText);

            if (arrEtelaat[0][0] == "ok")
            {
                document.querySelector("#kadrListPDF>.kadrAfzoodan select").innerHTML = "";
                var i;
                for (i=0; i<arrEtelaat[1].length; i++)
                {
                    document.querySelector("#kadrListPDF>.kadrAfzoodan select").innerHTML += "<option value='" + arrEtelaat[1][i]['id'] + "'>" + arrEtelaat[1][i]['dasteh'] + "</option>";
                }
            }
            else
            {
                entekhabListFileha();
                namayeshPeygham("خطای سیستم!", "لطفا بعدا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[2].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/gereftan-dastehha.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[2].style.display = "block";
}

/*  باز کردن فایل   */
function namayeshPDF(id)
{
    window.open('load-pdf-modir.php?tkA='+tkA+'&id='+id, '_blank');
}




/*      قسمت برچسب ها       */
function entekhabListBarchasbha(noe, meghdarSearch, shomSafEntekhabi)
{
    if (noe === undefined) noe = "hameh";
    if (meghdarSearch === undefined) meghdarSearch = "";
    if (shomSafEntekhabi === undefined) shomSafEntekhabi = 1;
    if (!mojazBeAnjamKarAst()) return;

    barresiEnterVaEsc("searchBarchasb");

    document.querySelector(".itemMenu[data-enekhabi]").removeAttribute("data-enekhabi");
    document.querySelectorAll(".itemMenu")[3].dataset.enekhabi = "";
    document.querySelector(".kadrListha[style='display: block;']").style.display = "none";
    document.getElementById("kadrListBarchasb").style.display = "block";
    document.querySelectorAll(".kadrAfzoodan")[3].style.display = "none";
    document.querySelectorAll(".kadrDorListha")[3].style.display = "block";
    document.getElementsByClassName("kadrDorList")[3].innerHTML = "";
    document.querySelectorAll(".kadrKolLoading")[3].style.display = "block";
    document.querySelector("#kadrListBarchasb>.kadrPaging").style.display = "none";

    if (noe == "hameh")
    {
        document.querySelectorAll("#kadrListBarchasb>a.emkanatLST")[0].style.display = "inline-block";
        document.querySelectorAll("#kadrListBarchasb>a.emkanatLST")[1].style.display = "none";
        document.querySelector("#kadrListBarchasb>h2.titrKadrListha").innerHTML = "<span class='icon'></span>برچسب ها";
        document.querySelectorAll(".kadrSearch>input")[3].value = "";
        document.querySelectorAll("a.zabdarSearchShodeh")[3].style.display = "none";
        document.querySelectorAll(".kadrSearch")[3].style.display = "inline-block";
    }
    else if (noe == "search")
    {
        document.querySelectorAll("#kadrListBarchasb>a.emkanatLST")[0].style.display = "none";
        document.querySelectorAll("#kadrListBarchasb>a.emkanatLST")[1].style.display = "inline-block";
        document.querySelectorAll("a.zabdarSearchShodeh")[3].style.display = "block";
        document.querySelectorAll(".kadrSearch")[3].style.display = "inline-block";
    }
    else if (noe == "dasteh")
    {
        document.querySelectorAll("#kadrListBarchasb>a.emkanatLST")[0].style.display = "inline-block";
        document.querySelectorAll("#kadrListBarchasb>a.emkanatLST")[1].style.display = "none";
        document.querySelector("#kadrListBarchasb>h2.titrKadrListha").innerHTML = "<span class='icon'></span>برچسب های موضوع انتخابی";
        document.querySelectorAll(".kadrSearch")[3].style.display = "none";
    }

    var arrNoe = [noe, meghdarSearch, shomSafEntekhabi];

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrNatijeh = JSON.parse(this.responseText);
            var tedadKolNatayej = arrNatijeh[2];
            var maxShom = Math.ceil(tedadKolNatayej / 15);

            if (arrNatijeh[0][0] == "ok" && arrNatijeh[0][1] == "ok")
            {
                noeSaf = noe;
                meghdarSearchSaf = meghdarSearch;
                shomSaf = shomSafEntekhabi;

                var arrEtelaat = arrNatijeh[1];
                var lmnList;
                var i;

                for (i = 0; i < arrEtelaat.length; i++)
                {
                    lmnList = document.createElement("div");
                    lmnList.setAttribute("class", "barchasbha");
                    lmnList.setAttribute("title", arrEtelaat[i]["barchasb"]);
                    lmnList.dataset.shom = i + 1;
                    lmnList.dataset.id = arrEtelaat[i]["id"];
                    lmnList.innerHTML = '' +
                        '<div class="kadrBtnEmkanatFard">\n' +
                        '<a href="javascript: void (0);" onclick="namayeshPeygham(\'پیام سیستم!\', \'آیا برای حذف اطمینان دارید؟\', 1, \'hazfBarchasb(' + arrEtelaat[i]["id"] + ')\');" class="emkanatFard" title="حذف"><span class="icon"></span></a>\n' +
                        '<a href="javascript: void (0);" onclick="virayeshBarchasb(' + (i + 1) + ');" class="emkanatFard" title="ویرایش"><span class="icon"></span></a>\n' +
                        '</div>\n' +
                        '<div class="kadrBtnEmkanatFard kadrBtnTaeedVaLaghv" style="display: none">\n' +
                        '<a href="javascript: void (0);" onclick="taeedVirayeshBarchasb(' + (i + 1) + ', ' + arrEtelaat[i]["id"] + ');" class="emkanatFard" title="تایید"><span class="icon"></span></a>\n' +
                        '<a href="javascript: void (0);" onclick="laghvVirayeshBarchasb(' + (i + 1) + ');" class="emkanatFard" title="لغو"><span class="icon"></span></a>\n' +
                        '</div>\n' +
                        '<span class="etelaatFard icon"></span>\n' +
                        '<span class="barchasb">' + arrEtelaat[i]["barchasb"] + '</span>';

                    document.getElementsByClassName("kadrDorList")[3].appendChild(lmnList);
                }

                var arrBtnPaging = document.querySelectorAll("#kadrListBarchasb>.kadrPaging a");

                if (tedadKolNatayej > 15)
                {
                    document.querySelector("#kadrListBarchasb>.kadrPaging").style.display = "block";
                    arrBtnPaging[1].parentElement.parentElement.getElementsByClassName("kadrShomSaf")[0].style.borderRadius = "0px";

                    if (shomSaf > 1)
                    {
                        arrBtnPaging[0].parentElement.style.display = "table-cell";
                        arrBtnPaging[1].parentElement.style.display = "table-cell";
                        arrBtnPaging[0].setAttribute("onclick", "entekhabListBarchasbha('" + noeSaf + "', '" + meghdarSearchSaf + "', 1);");
                        arrBtnPaging[1].setAttribute("onclick", "entekhabListBarchasbha('" + noeSaf + "', '" + meghdarSearchSaf + "', " + (shomSaf - 1) + ");");
                    } else
                    {
                        arrBtnPaging[0].parentElement.style.display = "none";
                        arrBtnPaging[1].parentElement.style.display = "none";
                        arrBtnPaging[1].parentElement.parentElement.getElementsByClassName("kadrShomSaf")[0].style.borderRadius = "0px 10px 10px 0px";
                    }

                    if (shomSaf < maxShom)
                    {
                        arrBtnPaging[2].parentElement.style.display = "table-cell";
                        arrBtnPaging[3].parentElement.style.display = "table-cell";
                        arrBtnPaging[2].setAttribute("onclick", "entekhabListBarchasbha('" + noeSaf + "', '" + meghdarSearchSaf + "', " + (shomSaf + 1) + ");");
                        arrBtnPaging[3].setAttribute("onclick", "entekhabListBarchasbha('" + noeSaf + "', '" + meghdarSearchSaf + "', " + maxShom + ");");
                    } else
                    {
                        arrBtnPaging[2].parentElement.style.display = "none";
                        arrBtnPaging[3].parentElement.style.display = "none";
                        arrBtnPaging[1].parentElement.parentElement.getElementsByClassName("kadrShomSaf")[0].style.borderRadius = "10px 0px 0px 10px";
                    }

                    document.querySelector("#kadrListBarchasb>.kadrPaging td.kadrShomSaf").innerHTML = "صفحه " + shomSaf + " از " + maxShom;
                }
                else
                {
                    document.querySelector("#kadrListBarchasb>.kadrPaging").style.display = "none";
                }
            }
            else if (arrNatijeh[0][0] == "n0")
            {
                noeSaf = noe;
                meghdarSearchSaf = meghdarSearch;
                shomSaf = shomSafEntekhabi;

                if (shomSafEntekhabi > maxShom) entekhabListBarchasbha(noe, meghdarSearch, maxShom);
            }
            else
            {
                namayeshPeygham("خطای سیستم!", "لطفا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[3].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/entekhab-barchasbha.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("q="+JSON.stringify(arrNoe)+"&tkA="+tkA);
}

/*    حذف یک برچسب    */
function hazfBarchasb(id)
{
    bastanPeygham();

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;

            if (JSON.parse(this.responseText)[0] == "ok")
            {
                entekhabListBarchasbha(noeSaf, meghdarSearchSaf, shomSaf);
                namayeshPeygham("حذف موفقیت آمیز بود", "این برچسب دیگر قابل استفاده نیست" , 0, "", "hsl(117,100%,71%)");
            }
            else
            {
                namayeshPeygham("خطای سیستم!", "لطفا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[3].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/hazf-barchasb.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("id="+id+"&tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[3].style.display = "block";
}

/*    ویرایش یک برچسب    */
function virayeshBarchasb(shom)
{
    if (!mojazBeAnjamKarAst()) return;

    barchasbVB = document.querySelector(".barchasbha[data-shom='"+shom+"']>.barchasb").innerHTML.trim();

    document.querySelector(".barchasbha[data-shom='"+shom+"']>.barchasb").innerHTML = '<input type="text" class="txtVirayeshBarchasb" name="barchasb" value="' + barchasbVB + '" placeholder="نام برچسب" autocomplete="off"/>';
    document.querySelector(".barchasbha[data-shom='"+shom+"']>.kadrBtnEmkanatFard").style.display = "none";
    document.querySelector(".barchasbha[data-shom='"+shom+"']>.kadrBtnTaeedVaLaghv").style.display = "block";

    document.querySelector(".barchasbha[data-shom='"+shom+"']>.barchasb>input").select();

    barresiEnterVaEsc("virayeshBarchasb");
}

/*    تایید ویرایش یک برچسب    */
function taeedVirayeshBarchasb(shom, id)
{
    var barchasbJadid = document.querySelector(".barchasbha[data-shom='"+shom+"']>.barchasb>input").value;

    if (barchasbJadid == "" || !farsiAst(barchasbJadid))
    {
        namayeshPeygham("خطای ویرایش!", "نام برچسب اشتباه است (نام برچسب باید فارسی باشد)", 0, "", "hsl(0,100%,68%)");
        return;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrEtelaat = JSON.parse(this.responseText);

            if (arrEtelaat[0] == "er:barchasb")
            {
                namayeshPeygham("خطای ویرایش!", "نام برچسب اشتباه است (نام برچسب باید فارسی باشد)", 0, "", "hsl(0,100%,68%)");
            }
            else if (arrEtelaat[0] == "ok")
            {
                var lmnDasteh = document.querySelector(".barchasbha[data-shom='"+shom+"']>.barchasb>input").parentElement.parentElement;

                lmnDasteh.getElementsByClassName("barchasb")[0].innerHTML = "";
                lmnDasteh.getElementsByClassName("barchasb")[0].innerText = arrEtelaat[1];
                document.querySelector(".barchasbha[data-shom='"+shom+"']>.kadrBtnEmkanatFard").style.display = "block";
                document.querySelector(".barchasbha[data-shom='"+shom+"']>.kadrBtnTaeedVaLaghv").style.display = "none";
            }
            else
            {
                namayeshPeygham("خطای ویرایش!", "پس از برسی مجدد اطلاعات، دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[3].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/virayesh-barchasb.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("id="+id+"&bj="+barchasbJadid+"&tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[3].style.display = "block";
}

/*    انصراف از ویرایش یک برچسب    */
function laghvVirayeshBarchasb(shom)
{
    document.querySelector(".barchasbha[data-shom='"+shom+"']>.barchasb").innerHTML = barchasbVB;
    document.querySelector(".barchasbha[data-shom='"+shom+"']>.kadrBtnEmkanatFard").style.display = "block";
    document.querySelector(".barchasbha[data-shom='"+shom+"']>.kadrBtnTaeedVaLaghv").style.display = "none";
}

/*  جستجو بین برچسب ها  */
function searchBarchasb()
{
    var matnJostojoo = document.querySelectorAll(".kadrSearch>input")[3].value.trim();
    if (matnJostojoo == "" || !farsiAst(matnJostojoo))
    {
        namayeshPeygham("پیام سیستم!", "لطفا متن فارسی وارد کنید");
        return;
    }

    noeSaf = "search";
    meghdarSearchSaf = matnJostojoo;
    shomSaf = 1;
    entekhabListBarchasbha(noeSaf, meghdarSearchSaf, shomSaf);
}

/*      باز شدن کادر افزودن یک برچسب     */
function afzoodanBarchasb()
{
    document.querySelector("#kadrListBarchasb>h2.titrKadrListha").innerHTML = "<span class='icon'></span>افزودن برچسب";
    document.querySelectorAll("#kadrListBarchasb>a.emkanatLST")[0].style.display = "none";
    document.querySelectorAll("#kadrListBarchasb>a.emkanatLST")[1].style.display = "inline-block";
    document.querySelectorAll(".kadrSearch")[3].style.display = "none";
    document.querySelectorAll(".kadrDorListha")[3].style.display = "none";
    document.querySelectorAll(".kadrPaging")[3].style.display = "none";
    document.querySelectorAll(".kadrAfzoodan")[3].style.display = "block";

    barresiEnterVaEsc("sabtBarchasb");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrEtelaat = JSON.parse(this.responseText);

            if (arrEtelaat[0][0] == "ok")
            {
                var lmnJoziat = document.querySelector("#kadrListBarchasb .kadrDorJoziat");
                lmnJoziat.innerHTML = "";

                for (var i=0; i<arrEtelaat[1].length; i++)
                {
                    lmnJoziat.innerHTML += "<a href='javascript:void (0);' onclick='entekhabBarchasbDasteh(this);' class='joziat' data-id='" + arrEtelaat[1][i]['id'] + "'><span class='icon'></span>" + arrEtelaat[1][i]['dasteh'] + "</a>";
                }
            }
            else
            {
                entekhabListDasehBandi();
                namayeshPeygham("خطای سیستم!", "لطفا بعدا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[3].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/gereftan-dastehha.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[3].style.display = "block";
}

/*    ثبت یک برچسب جدید    */
function sabtBarchasb()
{
    var barchasb = document.querySelectorAll("#kadrListBarchasb .kadrAfzoodan input")[0].value.trim();

    var arrDastehha = document.querySelectorAll("#kadrListBarchasb a.joziat[data-entekhabi]");
    var arrIdDastehha = [];
    for (var i=0; i<arrDastehha.length; i++)
    {
        arrIdDastehha.push(arrDastehha[i].dataset.id)
    }

    if (barchasb == "" || !farsiAst(barchasb))
    {
        namayeshPeygham("خطای ثبت!", "نام برچسب اشتباه است (نام برچسب باید فارسی باشد)", 0, "", "hsl(0,100%,68%)");
        return;
    }

    var etelaat = [barchasb, arrIdDastehha];

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrEtelaat = JSON.parse(this.responseText);

            if (arrEtelaat[0] == "er:barchasb")
            {
                namayeshPeygham("خطای ثبت!", "نام برچسب اشتباه است (نام برچسب باید فارسی باشد)", 0, "", "hsl(0,100%,68%)");
            }
            else if (arrEtelaat[0] == "ok")
            {
                namayeshPeygham("ثبت برچسب موفقیت آمیز بود", "اکنون می توانید از این برچسب استفاده کنید", 0, "", "hsl(117,100%,71%)");
                document.querySelectorAll("#kadrListBarchasb .kadrAfzoodan input")[0].value = "";

                var arrDastehhayeEntekhabi = document.querySelectorAll("#kadrListBarchasb a.joziat[data-entekhabi]");
                for (i=0; i<arrDastehhayeEntekhabi.length; i++)
                {
                    delete arrDastehhayeEntekhabi[i].dataset.entekhabi;
                    arrDastehhayeEntekhabi[i].getElementsByClassName("icon")[0].innerHTML = "";
                }
            }
            else
            {
                namayeshPeygham("خطای ثبت!", "پس از برسی مجدد اطلاعات، دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");
            }

            document.querySelectorAll(".kadrKolLoading")[3].style.display = "none";
        }
    };
    xhttp.open("POST","ajax/mod/sabt-barchasb.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("q="+JSON.stringify(etelaat)+"&tkA="+tkA);
    document.querySelectorAll(".kadrKolLoading")[3].style.display = "block";
}

<?php
if (isset($_POST["dasteh"]) && is_uploaded_file($_FILES['myfile']['tmp_name']))
{
    $dastehID = (integer)$_POST["dasteh"];
    $maghsadMovaghat = "pdf/tmp/" . basename($_FILES["myfile"]["name"]);
    $uploadOk = 1;
    $pasvand = strtolower(pathinfo($maghsadMovaghat, PATHINFO_EXTENSION));

    try
    {
        if ($dastehID == 0)
            throw new Exception("er:dasteh");

        if ($pasvand !== "pdf")
            throw new Exception("er:pdf");

        if ($_FILES["myfile"]["size"] > 20971520) // 20MB
            throw new Exception("er:size");

        if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $maghsadMovaghat))
        {
            $tarikhErsal = jdate("Y-m-d", "", "", "Asia/Tehran", "en");
            $zamanErsal = jdate("H:i:s", "", "", "Asia/Tehran", "en");
            require_once ("code/etesal-db.php");

            $sql = "insert into tbl_pdf (dastehID, tarikhErsal, zamanErsal) values (?,?,?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("iss", $dastehID, $tarikhErsal, $zamanErsal);
            if ($stmt->execute() == true)
            {
                $idMatlab = $stmt->insert_id;
                rename($maghsadMovaghat, "pdf/".$idMatlab.".pdf");
                echo 'namayeshPeygham("آپلود فایل موفقیت آمیز بود", "این فایل اکنون در سامانه قابل رویت است", 0, "", "hsl(117,100%,71%)");';
            }
            else
            {
                unlink("pdf/tmp/" . basename($_FILES["myfile"]["name"]));
                echo 'namayeshPeygham("خطای آپلود!", "لطفا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");';
            }
            $stmt->close();
            $con->close();

            echo 'namayeshPeygham("آپلود فایل موفقیت آمیز بود", "این فایل اکنون در سامانه قابل رویت است", 0, "", "hsl(117,100%,71%)");';
        }
        else throw new Exception("er:upload");
    }
    catch (Exception $e)
    {
        if ($e->getMessage() == "er:pdf")
            echo 'namayeshPeygham("خطای آپلود!", "لطفا یک فایل پی دی اف انتخاب کنید", 0, "", "hsl(0,100%,68%)");';
        elseif ($e->getMessage() == "er:size")
            echo 'namayeshPeygham("خطای آپلود!", "اندازه فایل نباید بیشتر از 20 مگابایت باشد", 0, "", "hsl(0,100%,68%)");';
        elseif ($e->getMessage() == "er:upload" || $e->getMessage() == "er:dasteh")
            echo 'namayeshPeygham("خطای آپلود!", "لطفا دوباره تلاش کنید", 0, "", "hsl(0,100%,68%)");';
    }

    echo 'entekhabListFileha();';
}
elseif (isset($_POST["dasteh"]))
{
    echo 'namayeshPeygham("خطای آپلود!", "فایل هنوز آپلود نشده است", 0, "", "hsl(0,100%,68%)");';
    echo 'entekhabListFileha();';
}
else
{
    echo 'entekhabListAza();';
}
?>

</script>
</body>
</html>