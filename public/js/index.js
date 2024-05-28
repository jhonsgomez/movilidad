function loadActions() {
    var listaAcciones = {
        registrar: ["Movilidad"],
        consultar: ["Convenio", "Institucion", "Movilidad"],
    };

    var main_option = document.getElementById("c_o_actions");
    var sec_option = document.getElementById("c_o_about_what");
    var main_option_selected = main_option.value;

    sec_option.innerHTML =
        '<option value="">-- Seleccione una opción --</option>';

    if (main_option_selected != "") {
        main_option_selected = listaAcciones[main_option_selected];

        main_option_selected.forEach(function (action) {
            let opcion = document.createElement("option");
            opcion.value = action.toLowerCase();
            opcion.text = action;
            sec_option.appendChild(opcion);
        });
    }
}

function activateNacInt() {
    var main_option = document.getElementById("actions").value;
    var sec_option = document.getElementById("about_what").value;
    var third_option = document.getElementById("nacoInt");

    if (main_option != "" && sec_option != "") {
        if (main_option == "registrar" && sec_option == "convenios") {
            third_option.setAttribute(
                "title",
                "Solo se habilitará para registro de Movilidades o Consultas en general"
            );
            third_option.disabled = true;
        } else if (
            main_option == "registrar" &&
            sec_option == "instituciones"
        ) {
            third_option.setAttribute(
                "title",
                "Solo se habilitará para registro de Movilidades o Consultas en general"
            );
            third_option.disabled = true;
        } else {
            third_option.removeAttribute("title");
            third_option.disabled = false;
        }
    } else {
        third_option.setAttribute(
            "title",
            "Solo se habilitará para registro de Movilidades o Consultas en general"
        );
        third_option.disabled = true;
    }
}

// function activateEntSal() {
//     var main_option = document.getElementById("actions").value;
//     var sec_option = document.getElementById("about_what").value;
//     var fourth_option = document.getElementById("entSal");

//     if (main_option != "" && sec_option != "") {
//         if (main_option == "registrar" && sec_option == "movilidad") {
//             fourth_option.removeAttribute("title");
//             fourth_option.disabled = false;
//         } else if (main_option == "consultar" && sec_option == "movilidad") {
//             fourth_option.removeAttribute("title");
//             fourth_option.disabled = false;
//         } else {
//             fourth_option.setAttribute(
//                 "title",
//                 "Solo se habilitará en registro y consulta de Movilidades"
//             );
//             fourth_option.disabled = true;
//         }
//     } else {
//         fourth_option.setAttribute(
//             "title",
//             "Solo se habilitará en registro y consulta de Movilidades"
//         );
//         fourth_option.disabled = true;
//     }
// }

function activateDegree(option, title) {
    if (option != "") {
        if (option == "Docente") {
            title.removeAttribute("title");
            title.disabled = false;
        } else {
            title.setAttribute("title", "Solo se habilitará para Docentes");
            title.disabled = true;
        }
    } else {
        title.setAttribute("title", "Solo se habilitará para Docentes");
        title.disabled = true;
    }
}

function activateIndCol(options, name, amount) {
    if (options != "") {
        if (options == "Colaborativo") {
            name.setAttribute("title", "Solo se habilitará para Colectivo");
            name.disabled = true;

            amount.removeAttribute("title");
            amount.disabled = false;
        } else if (options == "Individual") {
            name.removeAttribute("title");
            name.disabled = false;
            amount.setAttribute("title", "Solo se habilitará para Colectivo");
            amount.disabled = true;
        }
    } else {
        name.setAttribute("title", "Solo se habilitará para Colectivo");
        amount.setAttribute("title", "Solo se habilitará para Colectivo");
        name.disabled = true;
        amount.disabled = true;
    }
}

function activateIndColMovIntEnt() {
    var indCol = document.getElementById("mie_colInd").value;
    var name = document.getElementById("mie_fullname");
    var amount = document.getElementById("mie_cantidad");

    activateIndCol(indCol, name, amount);
}

function activateIndColMovIntSal() {
    var indCol = document.getElementById("mis_colInd").value;
    var name = document.getElementById("mis_fullname");
    var amount = document.getElementById("mis_cantidad");

    activateIndCol(indCol, name, amount);
}

function activateIndColMovNacEnt() {
    var indCol = document.getElementById("mne_colInd").value;
    var name = document.getElementById("mne_fullname");
    var amount = document.getElementById("mne_cantidad");

    activateIndCol(indCol, name, amount);
}

function activateIndColMovNacSal() {
    var indCol = document.getElementById("mns_colInd").value;
    var name = document.getElementById("mns_fullname");
    var amount = document.getElementById("mns_cantidad");

    activateIndCol(indCol, name, amount);
}

function activateDegreeMIE() {
    var option = document.getElementById("mie_adminstudoc").value;
    var titulo = document.getElementById("mie_titulos");
    activateDegree(option, titulo);
}

function activateDegreeMIS() {
    var option = document.getElementById("mis_adminstudoc").value;
    var titulo = document.getElementById("mis_titulos");
    activateDegree(option, titulo);
}

function activateDegreeMNE() {
    var option = document.getElementById("mne_adminstudoc").value;
    var titulo = document.getElementById("mne_titulos");
    activateDegree(option, titulo);
}

function activateDegreeMNS() {
    var option = document.getElementById("mns_adminstudoc").value;
    var titulo = document.getElementById("mns_titulos");
    activateDegree(option, titulo);
}

function countCharsOb(obj) {
    document.getElementById("charNumOb").innerHTML = obj.value.length + "/600";
}

function countCharsAl(obj) {
    document.getElementById("charNumAl").innerHTML = obj.value.length + "/600";
}

function mostrarPassword() {
    var cambio = document.getElementById("password");
    if (cambio.type == "password") {
        cambio.type = "text";
        $(".icon").removeClass("bi bi-eye-slash").addClass("bi bi-eye");
    } else {
        cambio.type = "password";
        $(".icon").removeClass("bi bi-eye").addClass("bi bi-eye-slash");
    }
}
