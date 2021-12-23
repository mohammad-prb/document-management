<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("code/config.php");
include ("code/jdf.php");
include ("code/lib.php");
include ("code/etesal-db.php");

if (!isset($_SESSION["tedadTalash"]) || $_SESSION["tedadTalash"] <= 5)
{
    if (isset($_POST["voroodBeSamaneh"]) && isset($_POST["codePerseneli"]) && isset($_POST["ramz"]) && isset($_POST["codeAmniat"]))
    {
        if (isset($_SESSION["tedadTalash"])) $_SESSION["tedadTalash"]++;
        else $_SESSION["tedadTalash"] = 1;

        $talashZiad = false;
        $codePerseneli = (integer)htmlspecialchars(stripcslashes(trim($_POST["codePerseneli"])));
        $ramz = htmlspecialchars(stripcslashes(trim($_POST["ramz"])));
        $codeAmniat = (integer)htmlspecialchars(stripcslashes(trim($_POST["codeAmniat"])));
        if ($codePerseneli != "" && $ramz != "" && $codeAmniat == $_SESSION["adadCaptcha"])
        {
            $ramz = hash("md5", $ramz);
            $sql = "select codePerseneli, sath from tbl_aza where vaziat = 1 and codePerseneli = ? and pass = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("is", $codePerseneli, $ramz);
            $stmt->execute();
            $stmt->bind_result($codePerseneli, $sath);
            if ($stmt->fetch())
            {
                $_SESSION["sathFard"] = $sath;
                $_SESSION["codePerseneli"] = $codePerseneli;
                $voroodMovafagh = true;
                unset($_SESSION["tedadTalash"]);
            }
            else
            {
                $voroodMovafagh = false;
            }
            $stmt->close();
        }
        else
        {
            $voroodMovafagh = false;
        }
    }
}
else
{
    $voroodMovafagh = false;
    $talashZiad = true;
}

if (isset($_GET["khM"]))
{
    if (isset($_SESSION["sathFard"])) unset($_SESSION["sathFard"]);
    if (isset($_SESSION["codePerseneli"])) unset($_SESSION["codePerseneli"]);
    if (isset($_SESSION["modir"])) unset($_SESSION["modir"]);
}

if (isset($_GET["ho"]))
{
    if (isset($_SESSION["modir"])) unset($_SESSION["modir"]);
}

$voroodModir = true;
if (!isset($_SESSION["tedadTalashModir"]) || $_SESSION["tedadTalashModir"] <= 3)
{
    if (isset($_POST["voroodModir"]) && isset($_POST["username"]) && isset($_POST["pass"]) && isset($_POST["codeAmniat"]))
    {
        $codeAmniat = (integer)htmlspecialchars(stripcslashes(trim($_POST["codeAmniat"])));
        if ($codeAmniat == $_SESSION["adadCaptcha"])
        {
            if (isset($_SESSION["tedadTalashModir"])) $_SESSION["tedadTalashModir"]++;
            else $_SESSION["tedadTalashModir"] = 1;
            $talashZiadModir = false;

            $username = htmlspecialchars(stripcslashes(trim($_POST["username"])));
            $ramz = htmlspecialchars(stripcslashes(trim($_POST["pass"])));

            if ($username === USERNAME_MODIR && $ramz === PASSWORD_MODIR)
            {
                $_SESSION["modir"] = "loginAst";
                unset($_SESSION["tedadTalashModir"]);
                header("location:modiriat.php");
            }
            else $voroodModir = false;
        }
        else $voroodModir = false;
    }
}
else $talashZiadModir = true;

if (isset($_GET["kh"]))
{
    if (isset($_SESSION["sathFard"])) unset($_SESSION["sathFard"]);
    if (isset($_SESSION["codePerseneli"])) unset($_SESSION["codePerseneli"]);
}

if (!isset($_SESSION["sathFard"]) || $_SESSION["sathFard"] > 3 || $_SESSION["sathFard"] < 1)
{
    include("code/login.php");
    die();
}

if (!isset($_SESSION["token"]))
{
    if (function_exists('random_bytes'))
        $_SESSION["token"] = bin2hex(random_bytes(32));
    else
        $_SESSION["token"] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
}
$token = $_SESSION["token"];
?>
<!DOCTYPE html>
<html lang="fa-ir">
<head>
    <title>مستندات صفا رایحه</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="pic/logo-kochik.png"/>
    <link rel="stylesheet" href="style/main.css"/>
    <script>
        var tk = "<?php echo $token;?>";
        var tedadNamayesh = <?php echo TEDAD_NAMAYESH_PDF;?>;
    </script>
</head>
<body dir="rtl">
<div id="fullCountainer">

    <div id="header">
        <img src="pic/logo-s.png" id="aksHeader"<?php if ($_SESSION["sathFard"]===1) echo ' ondblclick="document.getElementById(\'CountainerKadrNamayeshPeygham\').style.display = \'table\';"';?>/>
        <h1 id="titrKol">مستندات صفا رایحه</h1>
        <div id="kadrEmkanat">
            <a href="index.php?kh" class="btnEmkanat" title="خروج"></a>
        </div>
    </div>

    <div id="kadrBarchasb">
        <h2 id="titrBarchasb"><span class="icon"></span>برچسب ها</h2>
        <span class="btnKeshoei" onclick="bazobastBarchasb();"> </span>
        <div id="kadrDorBarchasb">
            <?php
            $sql = "select * from tbl_barchasb order by barchasb";
            $result = $con->query($sql);
            if ($result !== false && $result->num_rows > 0)
            {
                while ($row = $result->fetch_assoc())
                {
                    echo '<a href="#kadrDastehBandi" onclick="entekhabBarchasb(' . $row["id"] . ', \'' . $row["barchasb"] . '\');" class="barchasb"><span class="icon"></span>' . $row["barchasb"] . '</a>';
                }
            }
            ?>
        </div>
    </div>

    <div id="kadrMatalebAkhir">
        <h2 id="titrMatalebAkhir"><span class="icon"></span>فایل های جدید</h2>
        <div id="kadrDorMatalebAkhir">
            <?php
            $sql = @"select tbl_pdf.id as id, dasteh, tarikhErsal, zamanErsal from tbl_pdf
                    inner join tbl_dasteh on tbl_dasteh.id = dastehID
                    where tbl_pdf.vaziat = 1 and tarikhErsal >= '" . jdate('Y-m-d', jmktime(0, 0, 0, jdate('m'), jdate('d'), jdate('Y')) - 604800, "", "Asia/Tehran", "en") . "' and sath >= " . $_SESSION['sathFard'] . @"
                    order by tarikhErsal desc, zamanErsal desc, id desc";       //  فایل های هفته اخیر ( عدد ثابت = به ازای هر روز 86400 )
            $result = $con->query($sql);
            if ($result !== false && $result->num_rows >= 4)
            {
                while ($row = $result->fetch_assoc())
                {
                    echo @'<a href="javascript: void (0);" onclick="entekhabPDF(' . $row["id"] . ');" class="pdf" title="' . $row["dasteh"] . '">
                                <span class="icon"></span>
                                <span class="dasteh"><span class="icon"></span>' . $row["dasteh"] . '</span>
                                <span class="tarikh">' . str_replace("-", "/", $row["tarikhErsal"]) . '<span class="icon"></span></span>
                                <span class="zaman">' . substr($row["zamanErsal"], 0, 5) . '<span class="icon"></span></span>
                            </a>';
                }
            }
            else
            {
                $sql = @"select tbl_pdf.id as id, dasteh, tarikhErsal, zamanErsal from tbl_pdf
                        inner join tbl_dasteh on tbl_dasteh.id = dastehID
                        where tbl_pdf.vaziat = 1 and sath >= " . $_SESSION['sathFard'] . " order by tarikhErsal desc, zamanErsal desc, id desc limit 4";
                $result = $con->query($sql);
                if ($result !== false && $result->num_rows > 0)
                {
                    while ($row = $result->fetch_assoc())
                    {
                        echo @'<a href="javascript: void (0);" onclick="entekhabPDF(' . $row["id"] . ');" class="pdf" title="' . $row["dasteh"] . '">
                                <span class="icon"></span>
                                <span class="dasteh"><span class="icon"></span>' . $row["dasteh"] . '</span>
                                <span class="tarikh">' . str_replace("-", "/", $row["tarikhErsal"]) . '<span class="icon"></span></span>
                                <span class="zaman">' . substr($row["zamanErsal"], 0, 5) . '<span class="icon"></span></span>
                            </a>';
                    }
                }
            }
            ?>
        </div>
    </div>

    <div id="kadrDastehBandi">
        <div class="kadrKolLoading" style="display: none">
            <div class="kadrLoading">
                <img src="pic/loading.png" class="loading">
                <a href="javasCript: void (0);" onclick="bastanLoading('kadrDastehBandi');" class="zabdarLoading"></a>
            </div>
        </div>

        <h2 id="titrDasteh"><span class="icon"></span>موضوعات</h2>
        <div id="kadrDorFilter"><span id="barchasbEntekhabi"></span><span id="zabdarBarchasbEntekhabi" onclick="entekhabBarchasb(0, '');"></span></div>
        <div id="kadrDorDasteh">
            <?php
            $sql = "select * from tbl_dasteh where vaziat = 1 and sath >= " . $_SESSION['sathFard'] . " order by dasteh";
            $result = $con->query($sql);
            if ($result !== false && $result->num_rows > 0)
            {
                while ($row = $result->fetch_assoc())
                {
                    echo '<a href="javascript: void (0);" onclick="entekhabDasteh(' . $row["id"] . ', \'' . $row["dasteh"] . '\');" class="dasteh"><span class="icon"></span>' . $row["dasteh"] . '</a>';
                }
            }
            ?>
        </div>
    </div>

    <div id="kadrPDF" style="display: none">
        <div class="kadrKolLoading" style="display: none">
            <div class="kadrLoading">
                <img src="pic/loading.png" class="loading">
                <a href="javasCript: void (0);" onclick="bastanLoading('kadrPDF');" class="zabdarLoading"></a>
            </div>
        </div>

        <h2 id="titrPDF"></h2>
        <a href="javascript: void (0);" class="btnBargasht" onclick="bargashtBeDastehBandi();"><span class="icon"></span>بازگشت</a>
        <div id="kadrDorPDF"></div>

        <div class="kadrPaging" style="display: none">
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

    <?php
    if ($_SESSION["sathFard"] === 1)
    {
        echo @'<div id="CountainerKadrNamayeshPeygham" style="display: none">
                    <div id="kadrNamayeshPeygham">
                        <form action="index.php" method="post" id="kadrPeygham">
                            <h2 id="titrPeygham">ورود مدیر</h2>
                            <div id="matnPeygham">
                                <div>
                                    <input type="text" name="username" placeholder="نام کاربری" size="11" autocomplete="off" value="' .  (isset($_POST["username"]) ? $_POST["username"] : "") . @'"/>
                                    <input type="password" name="pass" placeholder="رمز عبور" size="11" autocomplete="off"/>
                                    <input type="text" name="codeAmniat" placeholder="کد امنیتی" size="11" autocomplete="off" maxlength="5"/>
                                    <img id="captcha" src="captcha.php"/>
                                </div>
                            </div>' .
                            (isset($talashZiadModir) && $talashZiadModir ? '<span id="peyghamKhataVorood" style="margin: 0">لطفا بعد از 30 دقیقه دوباره تلاش کنید.</span>' : (isset($voroodModir) && !$voroodModir ? '<span id="peyghamKhataVorood">اطلاعات وارد شده صحیح نمی باشد.</span>' : '')) .
                            '<span id="kadrDokmehPeygham">'.
                            (isset($talashZiadModir) && $talashZiadModir ? '' : '<input type="submit" name="voroodModir" value="ورود" class="dokmehTaeed"/>').
                            @'</span>
                            <a href="javascript: void (0);" class="zabdarPeygham" onclick="document.getElementById(\'CountainerKadrNamayeshPeygham\').style.display = \'none\';"></a>
                        </form>
                    </div>
                </div>';
    }

    if (!$voroodModir)
    {
        echo "<script>document.getElementById('CountainerKadrNamayeshPeygham').style.display = 'table';</script>";
    }
    ?>

</div>

<script>var shomSaf = 1;</script>
<script src="script/lib.js"></script>
<script src="script/main.js"></script>
</body>
</html>
<?php $con->close();?>