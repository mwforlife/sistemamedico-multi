function formatRut(cliente)
{cliente.value=cliente.value.replace(/[.-]/g, '')
.replace( /^(\d{1,2})(\d{3})(\d{3})(\w{1})$/, '$1.$2.$3-$4')}

var Fn = { //-------------
    // Valida el rut con su cadena completa "XXXXXXXX-X"---------------------------
    validaRut: function(rutCompleto) { //-------------
        rutCompleto = rutCompleto.replace(".", ""); //-------------
        rutCompleto = rutCompleto.replace(".", ""); //-------------
        rutCompleto = rutCompleto.replace("‐", "-"); //-------------
        //-------------
        if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test(rutCompleto)) //-------------
            return false; //-------------
        var tmp = rutCompleto.split('-'); //-------------
        var digv = tmp[1]; //-------------
        var rut = tmp[0]; //-------------
        if (digv == 'K') digv = 'k'; //-------------
        //-------------
        return (Fn.dv(rut) == digv); //-------------
    }, //-------------
    dv: function(T) { //-------------
            var M = 0,
                S = 1; //-------------
            for (; T; T = Math.floor(T / 10)) //-------------
                S = (S + T % 10 * (9 - M++ % 6)) % 11; //-------------
            return S ? S - 1 : 'k'; //-------------
        } //-------------
}; //-------------
//---------------------------------------------------------------------------------

function validarRut(rut){
    if (Fn.validaRut(rut)) {
        return true;      
    } else {
        return false;
    }
}