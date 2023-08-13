function log(i) {
    return Math.log(i) * Math.LOG10E;
}

function ln(i) {
    return Math.log(i);
}

function sq(i) {
    return i * i;
}

function sqr(i) {
    return Math.sqrt(i);
}


function power(x, y) {
    return Math.pow(x, y);
}

function eTo(x) {
    return Math.exp(x);
}


function fixDP(r, dps) {
    if (isNaN(r)) return "NaN";
    var msign = '';
    var mfin = '';
    if (r < 0) msign = '-';
    x = Math.abs(r);
    if (x > Math.pow(10, 21)) return msign + x.toString();
    var m = Math.round(x * Math.pow(10, dps)).toString();
    if (dps == 0) return msign + m;
    while (m.length <= dps) m = "0" + m;
    mfin = msign + m.substring(0, m.length - dps) + "." + m.substring(m.length - dps);
    if (dps == 1) return mfin.replace('.0', '');
    if (dps == 2) return mfin.replace('.00', '');
    if (dps == 3) return mfin.replace('.000', '');
    if (dps == 4) return mfin.replace('.0000', '');
    return mfin;
}

function fixNearest(x, y) {
    return Math.round(x / y) * y;
}

function alertNaN(thisparam) {
    alert(thisparam + ' is improperly formatted. You may only input the digits 0-9 and a decimal point.');
    doCalc = false;
    clrResults();
}

function clrValue(field) {
    field.value = '';
}

var currenttimeout;

function resetInTime() {
    if (currenttimeout) clearTimeout(currenttimeout);
    currenttimeout = setTimeout('minMaxCheck();', 3000);
}



var curelement;

function togCB(thisid) {
    thischeckbox = document.getElementById(thisid);
    if (thischeckbox.checked) { thischeckbox.checked = false; }
    else { thischeckbox.checked = true; }
    BodySurfaceArea_fx();
}

function setRB(thisid) {
    document.getElementById(thisid).checked = true;
    BodySurfaceArea_fx();
}


var calctxt = '';
var xmltxt = '';
var xmlresult = '';
var htmtxt = '';
var postNow = false;
var printing = false;
var interptxt = '';
var interphtm = '';
var interpxml = '';
var rbchk = false;

function BodySurfaceArea_fx() {

    with (document.BodySurfaceArea_form) {


        doCalc = true;
        param_value = parseFloat(Height_param.value);
        if (isNaN(param_value)) { param_value = ""; doCalc = false; }
        unit_parts = Height_unit.options[Height_unit.selectedIndex].value.split('|');
        Height = param_value * parseFloat(unit_parts[0]) + parseFloat(unit_parts[1]);
        param_value = parseFloat(Weight_param.value);
        if (isNaN(param_value)) { param_value = ""; doCalc = false; }
        unit_parts = Weight_unit.options[Weight_unit.selectedIndex].value.split('|');
        Weight = param_value * parseFloat(unit_parts[0]) + parseFloat(unit_parts[1]);
        dp = decpts.options[decpts.selectedIndex].text;
        BSA = 0.007184 * power(Height, 0.725) * power(Weight, 0.425);

        unit_parts = BSA_unit.options[BSA_unit.selectedIndex].value.split('|');
        if (doCalc) BSA_param.value = fixDP((BSA - parseFloat(unit_parts[1])) / parseFloat(unit_parts[0]), dp);





    }




}

function minMaxCheck() {
    if (printing) return;



    with (document.BodySurfaceArea_form) {

        if (Height_param.value && isNaN(Height_param.value)) { clrValue(Height_param); alertNaN('Estatura'); }
        if (Weight_param.value && isNaN(Weight_param.value)) { clrValue(Weight_param); alertNaN('Peso'); }


    }

}

function clrResults() {


    with (document.BodySurfaceArea_form) {

        BSA_param.value = '';


    }

}

var Height = null,
    Weight = null,
    BSA = null,
    param_value = null;







