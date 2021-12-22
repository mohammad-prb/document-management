<?php
include ("code/etesal-db.php");
?>
<!DOCTYPE html>
<html lang="fa-ir">
<head>
    <title>مستندات صفا رایحه</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="pic/logo-kochik.png"/>
    <style rel="stylesheet">
        @font-face
        {
            font-family: "shabnam";
            src: url("fonts/Shabnam-FD.woff");
        }

        @font-face
        {
            font-family: "vazir";
            src: url("fonts/vazir.woff");
        }

        body
        {
            position: relative;
            height: 100%;
            margin: auto;
            padding: 0px;
            min-width: 320px;
            max-width: 2200px;
        }

        #fullCountainer
        {
            position: relative;
            max-width: 2200px;
            margin: auto;
            overflow: auto;
        }

        #CountainerKadrNamayeshPeygham
        {
            display: table;
            height: 100%;
            width: 100%;
            position: fixed;
            top: 0px;
            left: 0px;
            z-index: 1000;
            background-color: hsl(0, 0%, 0%);
        }

        #kadrNamayeshPeygham
        {
            display: table-cell;
            height: 100%;
            width: 100%;
            vertical-align: middle;
        }

        form#kadrPeygham
        {
            width: calc(100% - 50px);
            max-width: 400px;
            padding: 20px;
            position: relative;
            text-align: center;
            display: block;
            margin: 0px auto;
            background-color: hsl(0, 0%, 10%);
            border-radius: 10px;
            animation: aniFadeShodan 0.2s;
            animation-fill-mode: forwards;
        }

        h2#titrPeygham
        {
            text-align: center;
            font-family: vazir;
            margin: 0px;
            padding: 20px;
            background-color: hsl(0, 0%, 20%);
            color: hsl(21, 71%, 62%);
            border-radius: 10px;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        #matnPeygham
        {
            direction: ltr;
            text-align: center;
            font-family: shabnam;
            padding: 10px 0px 0px;
            margin: 0px;
        }

        #matnPeygham>div
        {
            width: 304px;
            overflow: auto;
            margin: auto;
        }

        input
        {
            float: left;
            direction: ltr;
            border: 0px;
            padding: 5px 10px;
            margin: 10px;
            border-radius: 5px;
            font-family: vazir;
            font-size: 1rem;
            background-color: hsl(0, 0%, 20%);
            color: white;
            transition: background-color 0.2s;
        }

        input:focus
        {
            outline: 0px;
            background-color: hsl(0, 0%, 25%);
        }

        span#peyghamKhataVorood
        {
            display: block;
            color: hsl(0, 100%, 70%);
            margin: 0px 0px 15px;
            font-family: vazir;
        }

        input.dokmehTaeed
        {
            float: none;
            background-color: hsl(0, 0%, 20%);
            font-family: Shabnam;
            font-size: 1rem;
            padding: 4px 15px 6px;
            margin: 0px;
            border: 0px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.1s;
        }

        input.dokmehTaeed:hover
        {
            background-color: hsl(0, 0%, 30%);
            color: hsl(202, 100%, 60%);
        }

        img#captcha
        {
            margin: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body dir="rtl">
<div id="fullCountainer">

    <?php
        $sql = "select address, adad from tbl_captcha order by rand() limit 1;";
        $result = $con->query($sql);
        if ($result !== false && $result->num_rows > 0)
        {
            if ($row = $result->fetch_assoc())
            {
                $addressCaptcha = $row["address"];
                $_SESSION["adadCaptcha"] = $row["adad"];
            }
        }
        else
        {
            die();
        }
    ?>

    <div id="CountainerKadrNamayeshPeygham">
        <div id="kadrNamayeshPeygham">
            <form action="index.php" method="post" id="kadrPeygham">
                <h2 id="titrPeygham">ورود به سامانه</h2>
                <div id="matnPeygham">
                    <div>
                        <input type="text" name="codePerseneli" placeholder="کد پرسنلی" size="11" autocomplete="off" maxlength="6" value="<?php if (isset($_POST["codePerseneli"])) echo $_POST["codePerseneli"]; ?>"/>
                        <input type="password" name="ramz" placeholder="رمز عبور" size="11" maxlength="8" autocomplete="off"/>
                        <input type="text" name="codeAmniat" placeholder="کد امنیتی" size="11" autocomplete="off" maxlength="5"/>
                        <img id="captcha" src="pic/captcha/<?php echo $addressCaptcha;?>.jpg"/>
                    </div>
                </div>
                <?php
                if (isset($talashZiad) && $talashZiad)
                    echo '<span id="peyghamKhataVorood" style="margin: 0">لطفا بعد از 30 دقیقه دوباره تلاش کنید.</span>';
                elseif (isset($voroodMovafagh) && !$voroodMovafagh)
                    echo '<span id="peyghamKhataVorood">اطلاعات وارد شده صحیح نمی باشد.</span>';

                if (!isset($talashZiad) || !$talashZiad)
                    echo '<span id="kadrDokmehPeygham"><input type="submit" name="voroodBeSamaneh" value="ورود" class="dokmehTaeed"/></span>'
                ?>
            </form>
        </div>
    </div>

</div>
</body>
</html>