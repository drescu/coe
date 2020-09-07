var tabla;

// Funcion que se ejecuta al inicio 
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit",function(e) {
        guardaryeditar(e);
    })

    /*
    // cargamos los items al select categoria
    $.post("../ajax/evento.php?op=selectCategoria", function(r)
    {
        // datos que devuelvo a la vista
        $("#idcategoria").html(r);
        $("#idcategoria").selectpicker('refresh');
    });

    $("#imagenmuestra").hide();
    */

}

// Funcion limpiar 
function limpiar() {
    $("#tipo_doc").val("DNI");
    $("#numero_doc").val("");
    $("#nombre").val("");
    $("#apellido").val("");
    $("#nacionalidad").val("Argentina");
    $("#pueblo_indigena1").prop("checked", false);
    $("#pueblo_indigena2").prop("checked", false);
    $("#etnia").val("");
    $("#etnia").prop("disabled", true);
    
}

// Funcion mostrar formulario
function mostrarform(flag) {
    limpiar();
    if(flag) {
        // muestra el formulario de alta
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#numero_doc").focus();
        $("#btnGuardar").prop("disabled",false);
        $("#superior").hide();
    } else {
        // muestra el listado principal
        $("#listadoregistros").show(); 
        $("#formularioregistros").hide();
        $("#superior").show();
    }
}

// Funcion cancelar form
function cancelarform() {
    limpiar();
    mostrarform(false);
}

// Funcion listar
function listar() { 
    tabla=$('#tbllistado').dataTable(
        {
        "aProcessing": true,    // Activamos el procesamiento del datatables
        "aServerSide": true,    // Paginacion y filtrado realizados por el servidor
        dom: 'Bfrtip',          // Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/evento.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 5,            // paginacion
        "order": [[ 0, "desc" ]]        // orden de datos: columna, orden
    }).DataTable(); 
}

function guardaryeditar(e) {
    e.preventDefault();     // no se activara la accion predeterminada del evento 
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/evento.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        
        success: function(datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        } 
    });
    limpiar();
}

function mostrar(idpersona) {
    // envio por post, al controlador ajax 
    $.post("../ajax/evento.php?op=mostrar", {idpersona : idpersona}, function(data, status)
    {
        data = JSON.parse(data);
        mostrarform(true);

        // datos que devuelvo a la vista
        $("#idpersona").val(data.idpersona);
        //$('#idcategoria').selectpicker('refresh');
        $("#nombre").val(data.nombre);
        $("#apellido").val(data.apellido);
        $("#tipo_doc").val(data.tipo_doc);
        $("#numero_doc").val(data.numero_doc);
        generarbarcode();
    })
}

function comprobar() {      
    if (document.getElementById("pueblo_indigena2").checked) {
        $("#etnia").prop("disabled", false);
        $("#etnia").focus();
    } else {
        $("#etnia").prop("disabled", true);
        //$("#etnia").focus();
    }      
}

init();