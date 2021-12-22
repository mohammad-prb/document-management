function bastanPeygham()
{
    document.getElementById("kadrNamayeshPeygham").innerHTML = '';
    document.getElementById("CountainerKadrNamayeshPeygham").style.display = 'none';
}

function namayeshPeygham(titr, matn, dokmehha, tabe, color)
{
    if (dokmehha === undefined) dokmehha = 0;
    if (tabe === undefined) tabe = "";
    if (color === undefined) color = "white";

    document.getElementById("CountainerKadrNamayeshPeygham").style.display = 'table';
    document.getElementById("kadrNamayeshPeygham").innerHTML = '<div id="kadrPeygham">' +
        '<a href="javascript: void (0);" onclick="bastanPeygham();" id="zabdarPeygham"></a>' +
        '<div>' +
        '<h2 id="titrPeygham" style="color: ' + color + '">' + titr + '</h2>' +
        '<p id="matnPeygham">' + matn + '</p>' +
        '<span id="kadrDokmehPeygham">' +
        (dokmehha == 1 ? '<a class="dokmehTaeed" onclick="' + tabe + '" href="javascript:void (0);">تایید</a><a class="dokmehlaghv" onclick="bastanPeygham();" href="javascript:void (0);">لغو</a>' : '') +
        '</span>' +
        '</div>';
    '</div>';
}

function bastanLoading(idCountainer)
{
    document.querySelector("#"+idCountainer+">.kadrKolLoading").style.display = "none";
    ajaxJari.abort();
}

function entekhabBarchasb(id, nam)
{
    document.getElementById("kadrDastehBandi").style.display = "block";
    document.getElementById("kadrPDF").style.display = "none";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;

            document.querySelectorAll(".kadrKolLoading")[0].style.display = "none";
            document.getElementById("kadrDorDasteh").innerHTML = "";

            if (id == 0)
            {
                document.getElementById("barchasbEntekhabi").innerHTML = "";
                document.getElementById("zabdarBarchasbEntekhabi").style.display = "none";
            }
            else
            {
                document.getElementById("barchasbEntekhabi").innerHTML = "<span class=\"icon\"></span>"+nam;
                document.getElementById("zabdarBarchasbEntekhabi").style.display = "block";
            }

            if (this.responseText != "")
            {
                var arrDasteh = JSON.parse(this.responseText);
                if (arrDasteh[0] != "er")
                {
                    for (i=0; i<arrDasteh.length; i++)
                    {
                        document.getElementById("kadrDorDasteh").innerHTML += '<a href="javascript: void (0);" onclick="entekhabDasteh(' + arrDasteh[i][0] + ',\'' + arrDasteh[i][1] + '\');" class="dasteh"><span class="icon"></span>' + arrDasteh[i][1] + '</a>';
                    }
                }
            }
        }
    };
    xhttp.open("POST","ajax/entekhab-barchasb.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("b="+id+"&tk="+tk);
    document.querySelectorAll(".kadrKolLoading")[0].style.display = "block";
}

function entekhabDasteh(id, nam, shomSafheh)
{
    if (shomSafheh === undefined) shomSafheh = 1;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (!jsonMotabarAst(this.responseText)) return;
            var arrNatijeh = JSON.parse(this.responseText);

            shomSaf = shomSafheh;
            document.querySelectorAll(".kadrKolLoading")[0].style.display = "none";
            document.getElementById("kadrPDF").style.display = "block";
            document.getElementById("kadrDastehBandi").style.display = "none";
            document.getElementById("kadrDorPDF").innerHTML = "";
            document.getElementById("titrPDF").innerHTML = "<span class=\"icon\"></span>"+nam;

            if (arrNatijeh[0] == "ok")
            {
                var arrPDF = arrNatijeh[1];
                for (var i=0; i<arrPDF.length; i++)
                {
                    document.getElementById("kadrDorPDF").innerHTML += '<a href="javascript: void (0);" onclick="entekhabPDF(' + arrPDF[i][0] + ');" class="pdf" '+(shomSafheh==1 && i==0 ? 'data-jadidTarin' : '')+'>\n' +
                        '                        <span class="icon"></span>\n' +
                        '                        <span class="zaman">' + arrPDF[i][2].substr(0,5) + '<span class="icon"></span></span>\n' +
                        '                        <span class="tarikh">' + arrPDF[i][1].substr(0,4)+"/"+arrPDF[i][1].substr(5,2)+"/"+arrPDF[i][1].substr(8,2) + '<span class="icon"></span></span>\n' +
                        '                    </a>';
                }

                var tedadKolNatayej = arrNatijeh[2];
                var maxShom = Math.ceil(tedadKolNatayej / tedadNamayesh);
                var arrBtnPaging = document.querySelectorAll("#kadrPDF>.kadrPaging a");

                if (tedadKolNatayej > tedadNamayesh)
                {
                    document.querySelector("#kadrPDF>.kadrPaging").style.display = "block";
                    arrBtnPaging[1].parentElement.parentElement.getElementsByClassName("kadrShomSaf")[0].style.borderRadius = "0px";

                    if (shomSaf > 1)
                    {
                        arrBtnPaging[0].parentElement.style.display = "table-cell";
                        arrBtnPaging[1].parentElement.style.display = "table-cell";
                        arrBtnPaging[0].setAttribute("onclick", "entekhabDasteh("+ id +", '"+ nam +"', 1);");
                        arrBtnPaging[1].setAttribute("onclick", "entekhabDasteh("+ id +", '"+ nam +"', "+ (shomSaf-1) +");");
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
                        arrBtnPaging[2].setAttribute("onclick", "entekhabDasteh("+ id +", '"+ nam +"', "+ (shomSaf+1) +");");
                        arrBtnPaging[3].setAttribute("onclick", "entekhabDasteh("+ id +", '"+ nam +"', "+ maxShom +");");
                    }
                    else
                    {
                        arrBtnPaging[2].parentElement.style.display = "none";
                        arrBtnPaging[3].parentElement.style.display = "none";
                        arrBtnPaging[1].parentElement.parentElement.getElementsByClassName("kadrShomSaf")[0].style.borderRadius = "10px 0px 0px 10px";
                    }

                    document.querySelector("#kadrPDF>.kadrPaging td.kadrShomSaf").innerHTML = "صفحه " + shomSaf + " از " + maxShom;
                }
            }
        }
    };
    xhttp.open("POST","ajax/entekhab-dasteh.php?sid="+Math.random(),true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxJari = xhttp;
    xhttp.send("d="+id+"&ss="+shomSafheh+"&tk="+tk);
    document.querySelectorAll(".kadrKolLoading")[0].style.display = "block";
}

function entekhabPDF(id)
{
    window.open('load-pdf.php?tk='+tk+'&id='+id, '_blank');
}

function bazobastBarchasb()
{
    if (document.getElementById("kadrDorBarchasb").clientHeight == 0)
    {
        document.getElementById("kadrDorBarchasb").style.maxHeight = "2600px";      /*  50 برچسب  */
        document.getElementById("titrBarchasb").style.paddingBottom = "15px";
        document.getElementById("titrBarchasb").style.borderBottom = "1px solid hsl(0, 0%, 43%)";
        document.querySelectorAll(".btnKeshoei")[0].style.transform = "rotate(180deg)";
    }
    else
    {
        document.getElementById("kadrDorBarchasb").style.maxHeight = "0px";
        document.getElementById("titrBarchasb").style.paddingBottom = "0px";
        document.getElementById("titrBarchasb").style.borderBottom = "0px";
        document.querySelectorAll(".btnKeshoei")[0].style.transform = "rotate(0deg)";
    }
}

function bargashtBeDastehBandi()
{
    document.getElementById('kadrDastehBandi').style.display = 'block';
    document.getElementById('kadrPDF').style.display = 'none';
}