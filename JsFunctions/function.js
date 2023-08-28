//Listado de comuna por region
function listadocomunaregion(element) {
    var id = $(element).val();
    if (id.trim().length >= 1) {
        if (id > 0) {
            $.ajax({
                type: "POST",
                url: "php/listado/comunaregion.php",
                data: { id: id },
                success: function (data) {
                    $(".comunas").html(data);
                }
            });
        } else {
            console.log("Error");
            $(".comunas").html('<option value="0">Seleccione una comuna</option>');
        }
    } else {
        console.log("Erro 2");
        $(".comunas").html('<option value="0">Seleccione una comuna</option>');
    }
}

//Listado de comuna por region
function listadocomunaregion1(id) {
    if (id.trim().length >= 1) {
        if (id > 0) {
            $.ajax({
                type: "POST",
                url: "php/listado/comunaregion.php",
                data: { id: id },
                success: function (data) {
                    $(".comunas").html(data);
                }
            });
        } else {
            console.log("Error");
            $(".comunas").html('<option value="0">Seleccione una comuna</option>');
        }
    } else {
        console.log("Erro 2");
        $(".comunas").html('<option value="0">Seleccione una comuna</option>');
    }
}

//Listar de Ciudades por region
function listadociudadregion(element) {
    var id = $(element).val();
    if (id.trim().length >= 1) {
        if (id > 0) {
            $.ajax({
                type: "POST",
                url: "php/listado/ciudadesregion.php",
                data: { id: id },
                success: function (data) {
                    $(".ciudades").html(data);
                }
            });
        } else {
            $(".ciudades").html('<option value="0">Seleccione una ciudad</option>');
        }
    } else {
        $(".ciudades").html('<option value="0">Seleccione una ciudad</option>');
    }
}


//Listado de comunas por provincia
function listadocomunaprovincia(id) {
    if (id.trim().length >= 1) {
        if (id > 0) {
            $.ajax({
                type: "POST",
                url: "php/listado/comunaprovincia.php",
                data: { id: id },
                success: function (data) {
                    $(".comunas").html(data);
                }
            });
        } else {
            $(".comunas").html('<option value="0">Seleccione una comuna</option>');
        }
    } else {
        $(".comunas").html('<option value="0">Seleccione una comuna 1</option>');
    }
}

//Listado de Ciudades por provincia
function listadociudadprovincia(id) {
    if (id.trim().length >= 1) {
        if (id > 0) {
            $.ajax({
                type: "POST",
                url: "php/listado/ciudadesprovincia.php",
                data: { id: id },
                success: function (data) {
                    $(".ciudades").html(data);
                }
            });
        } else {
            $(".ciudades").html('<option value="0">Seleccione una ciudad</option>');
        }
    } else {
        $(".ciudades").html('<option value="0">Seleccione una ciudad</option>');
    }
}

function checklistados(element) {
    var id = $(element).val();
    listadocomunaprovincia(id);
    listadociudadprovincia(id);
}

//Listar Provincias por region
function listadoprovincias(element) {
    var id = $(element).val();
    if (id.trim().length >= 1) {
        if (id > 0) {
            $.ajax({
                type: "POST",
                url: "php/listado/provincia.php",
                data: { id: id },
                success: function (data) {
                    $("#provincia").html(data);
                    checklistados($("#provincia"));
                }
            });
        } else {
            $(".provincias").html('<option value="0">Seleccione una provincia</option>');
        }
    } else {
        $(".provincias").html('<option value="0">Seleccione una provincia</option>');
    }
}

function onloadpacientes() {
    listadoprovincias(document.getElementById("region"));
    listadociudadprovincia(document.getElementById("provincia"));
    listadocomunaprovincia(document.getElementById("provincia"));
}








/************************************************************************** */
//Diagnosticos CIEO
//Registro de diagnosticos
$(document).ready(function () {
    $("#diagcieoform").on("submit", function (event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/diagnosticoscieo.php",
            data: datos,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos registrados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    });
});
//Eliminar diagnosticos CIEO
function Eliminardiagnosticocieo(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/diagnosticocieo.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar para modificacion CIEO
function cargardiagnostico(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/diagnosticocieo.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar datos CIEO
function actualizarDiagnostico(id) {
    var codigo = $("#codigoedit").val();
    var completa = $("#completaedit").val();
    var abreviada = $("#abreviadoedit").val();
    var tipo = $("#tipoedit").val();

    $.ajax({
        type: "POST",
        url: "php/update/diagnosticocieo.php",
        data: { id: id, codigo: codigo, completa: completa, abreviada: abreviada, tipo: tipo },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con la actualizacion");
            } else {
                ToastifyError(data);
            }
        }
    });
}
//Fin de diagnosticos CIEO

//Diagnosticos CIE10
//Registro de diagnosticos CIE10
$(document).ready(function () {
    $("#diagcie10form").on("submit", function (event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/diagnosticoscie10.php",
            data: datos,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos registrados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    });
});

//Eliminar diagnosticos CIE10
function Eliminardiagnosticocie10(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/diagnosticocie10.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar para modificacion CIE10
function cargardiagnosticocie10(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/diagnosticocie10.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar datos CIE10
function actualizarDiagnosticoCie10(id) {
    var codigo = $("#codigoedit").val();
    var descripcion = $("#completaedit").val();
    var nodoedit = $("#nodoedit").val();
    var manifestacionedit = $("#manifestacionedit").val();
    var perinataledit = $("#perinataledit").val();
    var pediatricoedit = $("#pediatricoedit").val();
    var obstetricoedit = $("#obstetricoedit").val();
    var adultoedit = $("#adultoedit").val();
    var mujeredit = $("#mujeredit").val();
    var hombreedit = $("#hombreedit").val();
    var poaexemptoedit = $("#poaexemptoedit").val();
    var dpnoprincedit = $("#dpnoprincedit").val();
    var vcdpedit = $("#vcdpedit").val();

    $.ajax({
        type: "POST",
        url: "php/update/diagnosticocie10.php",
        data: { id: id, codigo: codigo, descripcion: descripcion, nodoedit: nodoedit, manifestacionedit: manifestacionedit, perinataledit: perinataledit, pediatricoedit: pediatricoedit, obstetricoedit: obstetricoedit, adultoedit: adultoedit, mujeredit: mujeredit, hombreedit: hombreedit, poaexemptoedit: poaexemptoedit, dpnoprincedit: dpnoprincedit, vcdpedit: vcdpedit },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con la actualizacion");
            } else {
                ToastifyError(data);
            }
        }
    });
}

//Fin de diagnosticos CIE10


//Ecog
//Registro de ecog
$(document).ready(function () {
    $("#ecogform").on("submit", function (event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/ecog.php",
            data: datos,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos registrados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    }
    );
});

//Eliminar ecog
function EliminarEcog(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/ecog.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar para modificacion
function cargarEcog(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/ecog.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar datos
function actualizarEcog(id) {
    var codigo = $("#codigoedit").val();
    var descripcion = $("#descripcionedit").val();

    $.ajax({
        type: "POST",
        url: "php/update/ecog.php",
        data: { id: id, codigo: codigo, descripcion: descripcion },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con la actualizacion");
            } else {
                ToastifyError(data);
            }
        }
    });
}
//Fin de ecog

//Histologico
//Registro de histologico
$(document).ready(function () {
    $("#histologicoform").on("submit", function (event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/histologico.php",
            data: datos,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos registrados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    }
    );
});

//Eliminar histologico
function EliminarHistologico(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/histologico.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar para modificacion
function cargarHistologico(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/histologico.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar datos
function actualizarHistologico(id) {
    var codigo = $("#codigoedit").val();
    var descripcion = $("#descripcionedit").val();

    $.ajax({
        type: "POST",
        url: "php/update/histologico.php",
        data: { id: id, codigo: codigo, descripcion: descripcion },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con la actualizacion");
            } else {
                ToastifyError(data);
            }
        }
    });
}
//Fin de histologico

//Invacion tumoral
//Registro de invacion tumoral
$(document).ready(function () {
    $("#invaciontumoralform").on("submit", function (event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/invaciontumoral.php",
            data: datos,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos registrados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    }
    );
});

//Eliminar invacion tumoral
function EliminarInvacionTumoral(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/invaciontumoral.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar para modificacion
function cargarInvacionTumoral(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/invaciontumoral.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar datos
function actualizarInvacionTumoral(id) {
    var codigo = $("#codigoedit").val();
    var descripcion = $("#descripcionedit").val();

    $.ajax({
        type: "POST",
        url: "php/update/invaciontumoral.php",
        data: { id: id, codigo: codigo, descripcion: descripcion },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con la actualizacion");
            } else {
                ToastifyError(data);
            }
        }
    });
}
//Fin de invacion tumoral

//TNM
//Registro de TNM
$(document).ready(function () {
    $("#tnmform").on("submit", function (event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/tnm.php",
            data: datos,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos registrados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    }
    );
});

//Eliminar TNM
function EliminarTNM(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/tnm.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar para modificacion
function cargarTNM(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/tnm.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar datos
function actualizarTNM(id) {
    var codigo = $("#codigoedit").val();
    var descripcion = $("#descripcionedit").val();
    var diagnostico = $("#diagnosticoedit").val();

    $.ajax({
        type: "POST",
        url: "php/update/tnm.php",
        data: { id: id, codigo: codigo, descripcion: descripcion, diagnostico: diagnostico },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con la actualizacion");
            } else {
                ToastifyError(data);
            }
        }
    });
}

//Regiones
//Registro de regiones
$(document).ready(function () {
    $("#regionesform").on("submit", function (event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/regiones.php",
            data: datos,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos registrados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    }
    );
});

//Eliminar regiones
function EliminarRegiones(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/regiones.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar para modificacion
function cargarRegiones(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/regiones.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar datos
function actualizarRegion(id) {
    var codigo = $("#codigoedit").val();
    var descripcion = $("#descripcionedit").val();

    $.ajax({
        type: "POST",
        url: "php/update/regiones.php",
        data: { id: id, codigo: codigo, descripcion: descripcion },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con la actualizacion");
            } else {
                ToastifyError(data);
            }
        }
    });
}

//Provincia
//Registro de provincia
$(document).ready(function () {
    $("#provinciaform").on("submit", function (event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/provincia.php",
            data: datos,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos registrados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    }
    );
});

//Eliminar provincia
function EliminarProvincia(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/provincia.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar para modificacion
function cargarProvincia(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/provincia.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar datos
function actualizarProvincia(id) {
    var codigo = $("#codigoedit").val();
    var descripcion = $("#descripcionedit").val();

    $.ajax({
        type: "POST",
        url: "php/update/provincia.php",
        data: { id: id, codigo: codigo, descripcion: descripcion },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con la actualizacion");
            } else {
                ToastifyError(data);
            }
        }
    });
}

//Comunas
//Registro de comunas
$(document).ready(function () {
    $("#comunasform").on("submit", function (event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/comunas.php",
            data: datos,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos registrados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    }
    );
});

//Eliminar comunas
function EliminarComunas(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/comunas.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar para modificacion
function cargarComunas(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/comunas.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar datos
function actualizarComunas(id) {
    var codigo = $("#codigoedit").val();
    var descripcion = $("#descripcionedit").val();
    var provincia = $("#provinciaedit").val();

    $.ajax({
        type: "POST",
        url: "php/update/comunas.php",
        data: { id: id, codigo: codigo, descripcion: descripcion, provincia: provincia },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con la actualizacion");
            } else {
                ToastifyError(data);
            }
        }
    });
}

//Nacionalidades
//Registro de nacionalidades
$(document).ready(function () {
    $("#nacionalidadesform").on("submit", function (event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/nacionalidad.php",
            data: datos,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos registrados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    }
    );
});

//Eliminar nacionalidades
function EliminarNacionalidades(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/nacionalidad.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar para modificacion
function cargarNacionalidades(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/nacionalidad.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar datos
function actualizarNacionalidades(id) {
    var codigo = $("#codigoedit").val();
    var descripcion = $("#descripcionedit").val();

    $.ajax({
        type: "POST",
        url: "php/update/nacionalidad.php",
        data: { id: id, codigo: codigo, descripcion: descripcion },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con la actualizacion");
            } else {
                ToastifyError(data);
            }
        }
    });
}

//Generos
//Registro de generos
$(document).ready(function () {
    $("#generosform").on("submit", function (event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/genero.php",
            data: datos,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos registrados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    }
    );
});

//Eliminar generos
function EliminarGeneros(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/genero.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar para modificacion
function cargarGeneros(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/genero.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar datos
function actualizarGeneros(id) {
    var codigo = $("#codigoedit").val();
    var descripcion = $("#descripcionedit").val();

    $.ajax({
        type: "POST",
        url: "php/update/genero.php",
        data: { id: id, codigo: codigo, descripcion: descripcion },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con la actualizacion");
            } else {
                ToastifyError(data);
            }
        }
    });
}

//Especialidad
//Registro de especialidad
$(document).ready(function () {
    $("#especialidadform").on("submit", function (event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/especialidad.php",
            data: datos,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos registrados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    }
    );
});

//Eliminar especialidad
function EliminarEspecialidad(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/especialidad.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar para modificacion
function cargarEspecialidad(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/especialidad.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar datos
function actualizarEspecialidad(id) {
    var codigo = $("#codigoedit").val();
    var descripcion = $("#descripcionedit").val();

    $.ajax({
        type: "POST",
        url: "php/update/especialidad.php",
        data: { id: id, codigo: codigo, descripcion: descripcion },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con la actualizacion");
            } else {
                ToastifyError(data);
            }
        }
    });
}

//Profesion
//Registro de profesion
$(document).ready(function () {
    $("#profesionform").on("submit", function (event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/profesion.php",
            data: datos,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos registrados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    }
    );
});

//Eliminar profesion
function EliminarProfesion(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/profesion.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar para modificacion
function cargarProfesion(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/profesion.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar datos
function actualizarProfesion(id) {
    var codigo = $("#codigoedit").val();
    var descripcion = $("#descripcionedit").val();
    var especialidad = $("#especialidad").val();

    $.ajax({
        type: "POST",
        url: "php/update/profesion.php",
        data: { id: id, codigo: codigo, descripcion: descripcion, especialidad: especialidad },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con la actualizacion");
            } else {
                ToastifyError(data);
            }
        }
    });
}


//Usuarios
//Registro de usuarios
$(document).ready(function () {
    $("#usuarioform").on("submit", function (event) {
        event.preventDefault();
        var rut = $("#UserRut").val();
        var datos = new FormData(this);

        if (validarRut(rut)) {
            $.ajax({
                type: "POST",
                url: "php/insert/usuario.php",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos registrados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            window.location.href = "usuarios.php";
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con el registro");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Rut invalido");
        }
    }
    );
});

//Eliminar usuario
function EliminarUsuario(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/usuario.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar mas datos
function cargarUsuario(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/usuario.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}


//Usuarios
//Editar usuarios
$(document).ready(function () {
    $("#usuarioformedit").on("submit", function (event) {
        event.preventDefault();
        var rut = $("#UserRut").val();
        var datos = new FormData(this);

        if (validarRut(rut)) {
            $.ajax({
                type: "POST",
                url: "php/update/usuario.php",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos Actualizados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con el registro");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Rut invalido");
        }
    }
    );
});

//Activar o Desactivar usuario
function activar(id, estado) {
    $.ajax({
        type: "POST",
        url: "php/update/estado.php",
        data: { id: id, estado: estado },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos Actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con el registro");
            } else {
                ToastifyError(data);
            }
        }
    });
}

//Cargar datos para resetear contraseña
function resetear(id) {
    $("#idusuario").val(id);
    $("#modaledit").modal("show");
    $("#contra").val("");
    $("#contra1").val("");
}

//Resetear contraseña
function cambiarcontra() {
    var id = $("#idusuario").val();
    var contra = $("#contra").val();
    var contra1 = $("#contra1").val();

    if (contra === contra1) {
        $.ajax({
            type: "POST",
            url: "php/update/contra.php",
            data: { id: id, contra: contra },
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Contraseña Actualizados con exito");
                    //Cerrar modal
                    $("#modaledit").modal("hide");
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    } else {
        ToastifyError("Las contraseñas no coinciden");
    }
}

//*************************************************************************************************************** */
//Pacientes Functions
/**************************************************************************************************************** */
//buscartipoprevision
function buscartipoprevision(element) {
    var id = $(element).val();
    if (id == 1) {
        $("#titleprevision").html("Tipo Fonasa");
        $(".fonasa").removeClass("d-none");
        $.ajax({
            type: "POST",
            url: "php/charge/tipoprevision.php",
            data: { id: id },
            success: function (data) {
                $(".tipoprevision").html(data);
            }
        });
    } else if (id == 2) {
        $("#titleprevision").html("ISAPRE");
        $(".fonasa").removeClass("d-none");
        $.ajax({
            type: "POST",
            url: "php/charge/tipoprevision.php",
            data: { id: id },
            success: function (data) {
                $(".tipoprevision").html(data);
            }
        });
    } else if (id == 3) {
        $(".fonasa").addClass("d-none");
    }
}

function checktipo(element) {
    var id = $(element).val();
    if (id == 1) {
        $(".rut").removeClass("d-none");
        $(".idotro").addClass("d-none");
    } else if (id == 2) {
        $(".rut").addClass("d-none");
        $(".idotro").addClass("d-none");
    } else {
        $(".rut").addClass("d-none");
        $(".idotro").removeClass("d-none");
    }
}

function checklaboral(element) {
    var id = $(element).val();
    if (id == 1) {
        $(".ocupacion").removeClass("d-none");
    } else {
        $(".ocupacion").addClass("d-none");
    }
}

$(document).ready(function () {
    $("#btnsavepatient").on("click", function (event) {
        event.preventDefault();
        //Datos Paciente
        var tipoidentificacion = $("#tipoidentificacion").val();//Obligatorio
        var rut = $("#rut").val();
        var documentoadd = $("#documentoadd").val();
        var nacionalidad = $("#nacionalidad").val();//Obligatorio
        var paisorigen = $("#paisorigen").val();//Obligatorio
        var correo = $("#email").val();
        var nombre = $("#nombre").val();//Obligatorio
        var apellido1 = $("#apellido1").val();//Obligatorio
        var apellido2 = $("#apellido2").val();
        var genero = $("#genero").val();//Obligatorio
        var estadocivil = $("#estadocivil").val();//Obligatorio
        var fechanacimiento = $("#fechanacimiento").val();//Obligatorio
        var hora = $("#horanacimiento").val();
        var fonomovil = $("#fonomovil").val();//Obligatorio
        var fonofijo = $("#fonofijo").val();
        var nombresocial = $("#nombresocial").val();
        var funcionario = 0;
        //Chequear si funcionario esta checkeado
        if ($("#funcionariocheck").is(':checked')) {
            funcionario = 1;
        }
        var discapacidad = 0;
        //Chequear si discapacidad esta checkeado
        if ($("#discapacidadcheck").is(':checked')) {
            discapacidad = 1;
        }
        var reciennacido = 0;
        //Chequear si reciennacido esta checkeado
        if ($("#reciennacidochek").is(':checked')) {
            reciennacido = 1;
        }
        var hijode = $("#hijode").val();
        var pesodenacimiento = $("#pesodenacimiento").val();
        var talladenacimiento = $("#talladenacimiento").val();
        var tipoparto = $("#tipoparto").val();
        var rol = $("#rol").val();
        var fechafallecimiento = $("#fechafallecimiento").val();
        var horafallecimiento = $("#horafallecimiento").val();

        //Validar datos paciente
        if (tipoidentificacion == 1) {
            if (validarRut(rut) == false) {
                ToastifyError("Rut Paciente invalido");
                $("#rut").focus();
                return false;
            }
        } else if (tipoidentificacion > 2) {
            if (documentoadd.trim().length == 0) {
                ToastifyError("Ingrese documento de identificacion");
                $("#documentoadd").focus();
                return false;
            }
        }
        if (nacionalidad == 0) {
            ToastifyError("Seleccione nacionalidad");
            $("#nacionalidad").focus();
            return false;
        }
        if (paisorigen == 0) {
            ToastifyError("Seleccione pais de origen");
            $("#paisorigen").focus();
            return false;
        }
        if (nombre.trim().length == 0) {
            ToastifyError("Ingrese nombre");
            $("#nombre").focus();
            return false;
        }
        if (apellido1.trim().length == 0) {
            ToastifyError("Ingrese primer apellido");
            $("#apellido1").focus();
            return false;
        }
        if (genero == 0) {
            ToastifyError("Seleccione genero");
            $("#genero").focus();
            return false;
        }
        if (fechanacimiento.trim().length == 0) {
            ToastifyError("Ingrese fecha de nacimiento");
            $("#fechanacimiento").focus();
            return false;
        }
        if (fonomovil.trim().length == 0) {
            ToastifyError("Ingrese telefono movil");
            $("#fonomovil").focus();
            return false;
        }

        //Datos Ficha, Inscripcion y previsión
        var ficha = $("#ficha").val();
        var fechaadmision = $("#fechaadmision").val();
        var familia = $("#familia").val();
        var inscrito = $("#inscrito").val();
        var sector = $("#sector").val();
        var prevision = $("#prevision").val();
        var tipoprevision = $("#tipoprevision").val();
        var estadoafiliar = $("#estadoafiliacion").val();
        var chilesolidario = 0;
        //Chequear si chilesolidario esta checkeado
        if ($("#chilesolidariocheck").is(':checked')) {
            chilesolidario = 1;
        }
        var prais = 0;
        //Chequear si prais esta checkeado
        if ($("#praischeck").is(':checked')) {
            prais = 1;
        }
        var sename = 0;
        //Chequear si sename esta checkeado
        if ($("#senamecheck").is(':checked')) {
            sename = 1;
        }
        var ubicacionficha = $("#ubicacionficha").val();
        var fichasaludmental = 0;
        //Chequear si fichasaludmental esta checkeado
        if ($("#fichasaludmentalcheck").is(':checked')) {
            fichasaludmental = 1;
        }


        //Datos de Ubicación
        var region = $("#region").val();
        var procincia = $("#provincia").val();
        var comuna = $("#comuna").val();
        var ciudad = $("#ciudad").val();
        var tipocalle = $("#tipocalle").val();
        var nombrecalle = $("#nombrecalle").val();
        var numerodireccion = $("#numerodireccion").val();
        var block = $("#block").val();


        //Validar datos de Ubicación
        if (nombrecalle.trim().length == 0) {
            ToastifyError("Ingrese nombre de calle");
            $("#nombrecalle").focus();
            return false;
        }
        if (numerodireccion.trim().length == 0) {
            ToastifyError("Ingrese numero de dirección");
            $("#numerodireccion").focus();
            return false;
        }
        if (block.trim().length == 0) {
            ToastifyError("Ingrese El Bloque , Departamento o Casa");
            $("#block").focus();
            return false;
        }



        //Otros Antecedentes
        var pueblooriginario = $("#pueblooriginario").val();
        var escolaridad = $("#escolaridad").val();
        var cursorepite = $("#cursorepite").val();
        var situacionlaboral = $("#situacionlaboral").val();
        var ocupacion = $("#ocupacion").val();


        //Validar datos de Persona Responsable
        var rutpersona = $("#rutpersona").val();
        if (rut.trim().length > 0) {
            if (validarRut(rutpersona) == false) {
                ToastifyError("Rut invalido");
                $("#rutpersona").focus();
                return false;
            }
        }
        var nombrepersona = $("#nombrepersona").val();
        if (rut.trim().length > 0) {
            if (nombrepersona.trim().length == 0) {
                ToastifyError("Ingrese nombre de persona responsable");
                $("#nombrepersona").focus();
                return false;
            }
        }
        var relacion = $("#relacion").val();
        var telefonomovil = $("#telefonomovil").val();
        if (rut.trim().length > 0) {
            if (telefonomovil.trim().length == 0) {
                ToastifyError("Ingrese telefono movil de persona responsable");
                $("#telefonomovil").focus();
                return false;
            }
        }
        var direccion = $("#direccion").val();
        if (rut.trim().length > 0) {
            if (direccion.trim().length == 0) {
                ToastifyError("Ingrese direccion de persona responsable");
                $("#direccion").focus();
                return false;
            }
        }

        //Agrupar datos paciente
        var datos = {
            tipoidentificacion: tipoidentificacion,
            rut: rut,
            documentoadd: documentoadd,
            nacionalidad: nacionalidad,
            paisorigen: paisorigen,
            correo: correo,
            nombre: nombre,
            apellido1: apellido1,
            apellido2: apellido2,
            genero: genero,
            estadocivil: estadocivil,
            fechanacimiento: fechanacimiento,
            hora: hora,
            fonomovil: fonomovil,
            fonofijo: fonofijo,
            nombresocial: nombresocial,
            funcionario: funcionario,
            discapacidad: discapacidad,
            reciennacido: reciennacido,
            hijode: hijode,
            pesodenacimiento: pesodenacimiento,
            talladenacimiento: talladenacimiento,
            tipoparto: tipoparto,
            rol: rol,
            fechafallecimiento: fechafallecimiento,
            horafallecimiento: horafallecimiento,
            ficha: ficha,
            fechaadmision: fechaadmision,
            familia: familia,
            inscrito: inscrito,
            sector: sector,
            prevision: prevision,
            tipoprevision: tipoprevision,
            estadoafiliar: estadoafiliar,
            chilesolidario: chilesolidario,
            prais: prais,
            sename: sename,
            ubicacionficha: ubicacionficha,
            fichasaludmental: fichasaludmental,
            region: region,
            procincia: procincia,
            comuna: comuna,
            ciudad: ciudad,
            tipocalle: tipocalle,
            nombrecalle: nombrecalle,
            numerodireccion: numerodireccion,
            block: block,
            pueblooriginario: pueblooriginario,
            escolaridad: escolaridad,
            cursorepite: cursorepite,
            situacionlaboral: situacionlaboral,
            ocupacion: ocupacion,
            rutpersona: rutpersona,
            nombrepersona: nombrepersona,
            relacion: relacion,
            telefonomovil: telefonomovil,
            direccion: direccion
        };
        $.ajax({
            type: "POST",
            url: "php/insert/paciente.php",
            data: datos,
            cache: false,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Paciente registrado(a) con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        //window.location.href = "listadopacientes.php";
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    });
    $("#btnactualizarpatient").on("click", function (event) {
        event.preventDefault();
        //Datos Paciente
        var tipoidentificacion = $("#tipoidentificacion").val();//Obligatorio
        var rut = $("#rut").val();
        var documentoadd = $("#documentoadd").val();
        var nacionalidad = $("#nacionalidad").val();//Obligatorio
        var paisorigen = $("#paisorigen").val();//Obligatorio
        var correo = $("#email").val();
        var nombre = $("#nombre").val();//Obligatorio
        var apellido1 = $("#apellido1").val();//Obligatorio
        var apellido2 = $("#apellido2").val();
        var genero = $("#genero").val();//Obligatorio
        var estadocivil = $("#estadocivil").val();//Obligatorio
        var fechanacimiento = $("#fechanacimiento").val();//Obligatorio
        var hora = $("#horanacimiento").val();
        var fonomovil = $("#fonomovil").val();//Obligatorio
        var fonofijo = $("#fonofijo").val();
        var nombresocial = $("#nombresocial").val();
        var funcionario = 0;
        //Chequear si funcionario esta checkeado
        if ($("#funcionariocheck").is(':checked')) {
            funcionario = 1;
        }
        var discapacidad = 0;
        //Chequear si discapacidad esta checkeado
        if ($("#discapacidadcheck").is(':checked')) {
            discapacidad = 1;
        }
        var reciennacido = 0;
        //Chequear si reciennacido esta checkeado
        if ($("#reciennacidochek").is(':checked')) {
            reciennacido = 1;
        }
        var hijode = $("#hijode").val();
        var pesodenacimiento = $("#pesodenacimiento").val();
        var talladenacimiento = $("#talladenacimiento").val();
        var tipoparto = $("#tipoparto").val();
        var rol = $("#rol").val();
        var fechafallecimiento = $("#fechafallecimiento").val();
        var horafallecimiento = $("#horafallecimiento").val();

        //Validar datos paciente
        if (tipoidentificacion == 1) {
            if (validarRut(rut) == false) {
                ToastifyError("Rut Paciente invalido");
                console.log("Rut Paciente invalido: " + rut);
                $("#rut").focus();
                return false;
            }
        } else if (tipoidentificacion > 2) {
            if (documentoadd.trim().length == 0) {
                ToastifyError("Ingrese documento de identificacion");
                $("#documentoadd").focus();
                return false;
            }
        }
        if (nacionalidad == 0) {
            ToastifyError("Seleccione nacionalidad");
            $("#nacionalidad").focus();
            return false;
        }
        if (paisorigen == 0) {
            ToastifyError("Seleccione pais de origen");
            $("#paisorigen").focus();
            return false;
        }
        if (nombre.trim().length == 0) {
            ToastifyError("Ingrese nombre");
            $("#nombre").focus();
            return false;
        }
        if (apellido1.trim().length == 0) {
            ToastifyError("Ingrese primer apellido");
            $("#apellido1").focus();
            return false;
        }
        if (genero == 0) {
            ToastifyError("Seleccione genero");
            $("#genero").focus();
            return false;
        }
        if (fechanacimiento.trim().length == 0) {
            ToastifyError("Ingrese fecha de nacimiento");
            $("#fechanacimiento").focus();
            return false;
        }
        if (fonomovil.trim().length == 0) {
            ToastifyError("Ingrese telefono movil");
            $("#fonomovil").focus();
            return false;
        }

        //Datos Ficha, Inscripcion y previsión
        var ficha = $("#ficha").val();
        var fechaadmision = $("#fechaadmision").val();
        var familia = $("#familia").val();
        var inscrito = $("#inscrito").val();
        var sector = $("#sector").val();
        var prevision = $("#prevision").val();
        var tipoprevision = $("#tipoprevision").val();
        var estadoafiliar = $("#estadoafiliacion").val();
        var chilesolidario = 0;
        //Chequear si chilesolidario esta checkeado
        if ($("#chilesolidariocheck").is(':checked')) {
            chilesolidario = 1;
        }
        var prais = 0;
        //Chequear si prais esta checkeado
        if ($("#praischeck").is(':checked')) {
            prais = 1;
        }
        var sename = 0;
        //Chequear si sename esta checkeado
        if ($("#senamecheck").is(':checked')) {
            sename = 1;
        }
        var ubicacionficha = $("#ubicacionficha").val();
        var fichasaludmental = 0;
        //Chequear si fichasaludmental esta checkeado
        if ($("#fichasaludmentalcheck").is(':checked')) {
            fichasaludmental = 1;
        }


        //Datos de Ubicación
        var region = $("#region").val();
        var procincia = $("#provincia").val();
        var comuna = $("#comuna").val();
        var ciudad = $("#ciudad").val();
        var tipocalle = $("#tipocalle").val();
        var nombrecalle = $("#nombrecalle").val();
        var numerodireccion = $("#numerodireccion").val();
        var block = $("#block").val();


        //Validar datos de Ubicación
        if (nombrecalle.trim().length == 0) {
            ToastifyError("Ingrese nombre de calle");
            $("#nombrecalle").focus();
            return false;
        }
        if (numerodireccion.trim().length == 0) {
            ToastifyError("Ingrese numero de dirección");
            $("#numerodireccion").focus();
            return false;
        }
        if (block.trim().length == 0) {
            ToastifyError("Ingrese El Bloque , Departamento o Casa");
            $("#block").focus();
            return false;
        }



        //Otros Antecedentes
        var pueblooriginario = $("#pueblooriginario").val();
        var escolaridad = $("#escolaridad").val();
        var cursorepite = $("#cursorepite").val();
        var situacionlaboral = $("#situacionlaboral").val();
        var ocupacion = $("#ocupacion").val();


        //Validar datos de Persona Responsable
        var rutpersona = $("#rutpersona").val();
        if (rut.trim().length > 0) {
            if (validarRut(rutpersona) == false) {
                ToastifyError("Rut invalido");
                $("#rutpersona").focus();
                return false;
            }
        }
        var nombrepersona = $("#nombrepersona").val();
        if (rut.trim().length > 0) {
            if (nombrepersona.trim().length == 0) {
                ToastifyError("Ingrese nombre de persona responsable");
                $("#nombrepersona").focus();
                return false;
            }
        }
        var relacion = $("#relacion").val();
        var telefonomovil = $("#telefonomovil").val();
        if (rut.trim().length > 0) {
            if (telefonomovil.trim().length == 0) {
                ToastifyError("Ingrese telefono movil de persona responsable");
                $("#telefonomovil").focus();
                return false;
            }
        }
        var direccion = $("#direccion").val();
        if (rut.trim().length > 0) {
            if (direccion.trim().length == 0) {
                ToastifyError("Ingrese direccion de persona responsable");
                $("#direccion").focus();
                return false;
            }
        }
        var idpaciente = $("#idpaciente").val();
        var fichaid = $("#fichaid").val();
        var ubicacionid = $("#ubicacionid").val();
        var otrosid = $("#otrosid").val();
        var idresponsable = $("#idresponsable").val();
        //Agrupar datos paciente
        var datos = {
            tipoidentificacion: tipoidentificacion,
            rut: rut,
            documentoadd: documentoadd,
            nacionalidad: nacionalidad,
            paisorigen: paisorigen,
            correo: correo,
            nombre: nombre,
            apellido1: apellido1,
            apellido2: apellido2,
            genero: genero,
            estadocivil: estadocivil,
            fechanacimiento: fechanacimiento,
            hora: hora,
            fonomovil: fonomovil,
            fonofijo: fonofijo,
            nombresocial: nombresocial,
            funcionario: funcionario,
            discapacidad: discapacidad,
            reciennacido: reciennacido,
            hijode: hijode,
            pesodenacimiento: pesodenacimiento,
            talladenacimiento: talladenacimiento,
            tipoparto: tipoparto,
            rol: rol,
            fechafallecimiento: fechafallecimiento,
            horafallecimiento: horafallecimiento,
            ficha: ficha,
            fechaadmision: fechaadmision,
            familia: familia,
            inscrito: inscrito,
            sector: sector,
            prevision: prevision,
            tipoprevision: tipoprevision,
            estadoafiliar: estadoafiliar,
            chilesolidario: chilesolidario,
            prais: prais,
            sename: sename,
            ubicacionficha: ubicacionficha,
            fichasaludmental: fichasaludmental,
            region: region,
            procincia: procincia,
            comuna: comuna,
            ciudad: ciudad,
            tipocalle: tipocalle,
            nombrecalle: nombrecalle,
            numerodireccion: numerodireccion,
            block: block,
            pueblooriginario: pueblooriginario,
            escolaridad: escolaridad,
            cursorepite: cursorepite,
            situacionlaboral: situacionlaboral,
            ocupacion: ocupacion,
            rutpersona: rutpersona,
            nombrepersona: nombrepersona,
            relacion: relacion,
            telefonomovil: telefonomovil,
            direccion: direccion,
            idpaciente: idpaciente,
            fichaid: fichaid,
            ubicacionid: ubicacionid,
            otrosid: otrosid,
            idresponsable: idresponsable
        };
        $.ajax({
            type: "POST",
            url: "php/update/paciente.php",
            data: datos,
            cache: false,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Paciente Actualizado(a) con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        //window.location.href = "listadopacientes.php";
                    }, 1000);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        });
    });
});


function cargarsignos() {
    var paciente = $("#pacienteid").val();
    $.ajax({
        url: "php/charge/signosvitales.php",
        type: "POST",
        data: { id: paciente },
        success: function (respuesta) {
            $("#signos").html(respuesta);
        }
    });
}

function cargarmedidas() {
    var paciente = $("#pacienteid").val();
    $.ajax({
        url: "php/charge/medidas.php",
        type: "POST",
        data: { id: paciente },
        success: function (respuesta) {
            $("#medidas").html(respuesta);
        }
    });
}


$(document).ready(function () {
    $("#formsignos").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "php/insert/signos.php",
            type: "POST",
            data: $("#formsignos").serialize(),
            success: function (respuesta) {
                respuesta = respuesta.trim();
                if (respuesta == 1) {
                    ToastifySuccess("Se registro los signos vitales correctamente");
                    cargarsignos();
                } else {
                    ToastifyError(respuesta);
                }

            }
        });
    });
    $("#formmedidas").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "php/insert/medidas.php",
            type: "POST",
            data: $("#formmedidas").serialize(),
            success: function (respuesta) {
                respuesta = respuesta.trim();
                if (respuesta == 1) {
                    ToastifySuccess("Se registro las medidas correctamente");
                    cargarmedidas();
                } else {
                    ToastifyError(respuesta);
                }

            }
        });
    });
});


//*************************************************************************************************************** */
//Comité
//Registro de nombre de comite
$(document).ready(function () {
    $("#nombrecomiteform").on("submit", function (event) {
        event.preventDefault();
        var nombre = $("#nombre").val();
        var datos = new FormData(this);

        if (nombre != "") {
            $.ajax({
                type: "POST",
                url: "php/insert/nombrecomite.php",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos registrados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con el registro");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Debe ingresar un nombre");
        }
    }
    );
});

//Eliminar comite
function EliminarNombrecomite(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/nombrecomite.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar mas datos
function cargarNombrecomite(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/nombrecomite.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Actualizar comite
function actualizarNombrecomite(id) {
    var codigo = $("#codigoedit").val();
    var nombre = $("#descripcionedit").val();
    $.ajax({
        type: "POST",
        url: "php/update/nombrecomite.php",
        data: { id: id, codigo: codigo, nombre: nombre },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos Actualizados con exito");
                //Recargar pagina en 1 segundo
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data == 0 || data == "0") {
                ToastifyError("Hubo un error con el registro");
            } else {
                ToastifyError(data);
            }
        }
    });
}

//*************************************************************************************************************** */
//Comite
//Seleccionar Nombre Comite
function agregarnombrecomite(id, nombre) {
    $("#nombretext").val(nombre);
    $("#idnombre").val(id);
    $("#modalnombrecomite").modal("hide");
    buscarFolio(id);
}

//Buscar Folio
function buscarFolio(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/folio.php",
        data: { id: id },
        success: function (data) {
            $(".folio").html("FOLIO: " + data);
            $("#folio").val(data);
        }
    });
}

//Registro de comite
$(document).ready(function () {
    $("#comiteform").on("submit", function (event) {
        event.preventDefault();
        var datos = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/insert/comite.php",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                //Sacar la primera letra del string
                var firstletter = data.charAt(0);
                //Si es 1, sacar el resto del string
                if (firstletter == 1 || firstletter == "1") {
                    var id = data.substring(1);
                    $("#idcomite").val(id);
                    ToastifySuccess("Datos registrados con exito");
                    //Eliminar clase d-none
                    $(".comitedetails").removeClass("d-none");
                    $("#btnregistrar").attr("disabled", true);
                    $("#btnregistrar").attr("type", "button");
                } else if (firstletter == 0 || firstletter == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        })
    }
    );
});


//Agregar Profesional
function agregarprofesional(id, rut, nombre, profesion) {
    var result = existeProfesionalesComite(id);
    if (result == true) {
        ToastifyError("El profesional ya se encuentra agregado");
    } else {
        agregarProfesionalesComite(id, rut, nombre, profesion);
    }
}


function mostrar(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/evento.php",
        data: { id: id },
        success: function (data) {
            $(".contenido").html(data);
        }
    });
}
/************************************************************************** */
function historial($paciente, $comite, $observacion) {
    $.ajax({
        url: "php/charge/historial.php",
        type: "POST",
        data: { paciente: $paciente, comite: $comite, observacion: $observacion },
        success: function (respuesta) {
            $("#historial").html(respuesta);
        }
    });
}

//Revisar informe
function verinforme(id) {
    $("#informepdf").attr("src", "php/reporte/informecomite.php?id=" + id);
    $("#modalinforme").modal("show");
}


//Finalizar Comite
function finalizarcomite1(id){
    swal.fire({
        title: '¿Estas seguro de finalizar este comite?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, finalizar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "php/update/finalizarcomite.php",
                type: "POST",
                data: { id: id },
                success: function (respuesta) {
                    if (respuesta == 1) {
                        ToastifySuccess("Comite finalizado con exito");
                        setTimeout(function () {
                            window.location.href = "listadocomite.php";
                        }, 1000);
                    } else {
                        ToastifyError(respuesta);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Habilitar Comite
function habilitarcomite(id){
    swal.fire({
        title: '¿Estas seguro de habilitar este comite?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, habilitar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "php/update/habilitarcomite.php",
                type: "POST",
                data: { id: id },
                success: function (respuesta) {
                    if (respuesta == 1) {
                        ToastifySuccess("Comite habilitado con exito");
                        setTimeout(function () {
                            window.location.href = "listadocomite.php";
                        }, 1000);
                    } else {
                        ToastifyError(respuesta);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

/*******************Registrar medicamentos */
$(document).ready(function () {
    $("#medicamentosform").on("submit", function (event) {
        event.preventDefault();
        var datos = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/insert/medicamentos.php",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                //Recibir el JSON
                try{
                    var medicamento = JSON.parse(data);
                    //si el elemento error = true, mostrar error
                    if(medicamento.error == true){
                        ToastifyError(medicamento.message);
                    }else if(medicamento.error == false){
                        ToastifySuccess(medicamento.message);
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                }catch(error){
                    ToastifyError(data);

                }
            }
        })
    }
    );
    $("#formmededit").on("submit", function (event) {
        event.preventDefault();
        var datos = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/update/medicamentos.php",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                //Recibir el JSON
                try{
                    var medicamento = JSON.parse(data);
                    //si el elemento error = true, mostrar error
                    if(medicamento.error == true){
                        ToastifyError(medicamento.message);
                    }else if(medicamento.error == false){
                        ToastifySuccess(medicamento.message);
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                }catch(error){
                    ToastifyError(data);

                }
            }
        })
    });
});

//Eliminar medicamento
function EliminarMedicamento(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/medicamentos.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar mas datos
function cargarMedicamento(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/medicamentos.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

/******************Esquema */
$(document).ready(function () {
    $("#esquemaform").on("submit", function (event) {
        event.preventDefault();
        var datos = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/insert/esquema.php",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos registrados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        })
    });
    $("#formesquemaedit").on("submit", function (event) {
        event.preventDefault();
        var datos = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/update/esquema.php",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos Actualizados con exito");
                    //Recargar pagina en 1 segundo
                    setTimeout(function () {
                       location.reload();
                    }, 1500);
                } else if (data == 0 || data == "0") {
                    ToastifyError("Hubo un error con el registro");
                } else {
                    ToastifyError(data);
                }
            }
        })
    });
});

//Eliminar esquema
function EliminarEsquema(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/esquema.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Cargar mas datos
function cargarEsquema(id) {
    $.ajax({
        type: "POST",
        url: "php/charge/esquema.php",
        data: { id: id },
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Agregar medicamento
function agregarmedicamento(id, medicamento){
    $("#modaledit").modal("hide");
    $("#medicamentoid").val(id);
    $("#med").html("Medicamento: "+medicamento);
    $("#modaladd").modal("show");
}

$(document).ready(function () {
    $("#formesmed").on("submit", function (event) {
        event.preventDefault();
        var datos = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/insert/esquemamedicamento.php",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                //Recibir el JSON
                try{
                    var medicamento = JSON.parse(data);
                    //si el elemento error = true, mostrar error
                    if(medicamento.error == true){
                        ToastifyError(medicamento.message);
                    }else if(medicamento.error == false){
                        ToastifySuccess(medicamento.message);
                        //Recargar pagina en 1 segundo
                        listarMedicamentos();
                        $("#modaladd").modal("hide");
                        $("#modaledit").modal("show");                          
                        $("#formesmed")[0].reset();                 
                    }
                }catch(error){
                    ToastifyError(data);

                }
            }
        })
    });
});

//Eliminar medicamento
function EliminarMedicamentoEsquema(id) {
    swal.fire({
        title: '¿Estas seguro de eliminar este registro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        //Texto del boton de confirmacion
        confirmButtonText: 'Si, eliminar!',
        //Texto del boton cancelar
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/delete/esquemamedicamento.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Datos eliminados con exito");
                        //Recargar pagina en 1 segundo
                        listarMedicamentos();
                    } else if (data == 0 || data == "0") {
                        ToastifyError("Hubo un error con la eliminacion");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyError("Accion cancelada");
        }
    });
}

//Listar medicamentos
function listarMedicamentos(){
    var id = $("#esquemaid").val();
    $.ajax({
        type: "POST",
        url: "php/charge/esquemamedicamento.php",
        data: { id: id },
        success: function (data) {
            $("#listamedicamentos").html(data);
        }
    });
}

function cargarMedicamentoesquema(){
    var id = $("#esquema").val();
    $.ajax({
        type: "POST",
        url: "php/charge/cargaresquemamed.php",
        data: { id: id },
        success: function (data) {
            $("#medi").html(data);
        }
    });
}

function registraratencion(paciente, empresa, medico, reserva){
    console.log("Paciente: "+paciente);
    console.log("Empresa: "+empresa);
    console.log("Medico: "+medico);
    console.log("Reserva: "+reserva);
    var diagnosticoid = $("#iddiag").val();
    var diagnosticotext = $("#diagnostico").val();
    var cieo10 = $("#idcie10").val();
    var cieo10text = $("#cie10").val();
    var tipoatencion = $("#tipoatencion").val();
    var ecog = $("#ecog").val();
    //Capturar el texto del select
    var ecogtext = $("#ecog option:selected").text();
    var ingreso =0;
    if($("#ingreso").is(':checked')){
        ingreso = 1;
    }
    var receta =0;
    if($("#receta").is(':checked')){
        receta = 1;
    }
    var reingreso =0;
    if($("#reingreso").is(':checked')){
        reingreso = 1;
    }
    var anamnesis = $("#anamnesis").val();
    var procedimientotext = $("#procedimientotext").val();
    var resolucion = $("#resolucion").val();
    var estadoatencion = $("#estadoatencion").val();

    //Validar datos
}