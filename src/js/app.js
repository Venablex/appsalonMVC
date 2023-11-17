let paso = 1;
const paso_Inicial = 1;
const paso_Final = 3;

const cita = {
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}


document.addEventListener('DOMContentLoaded',function () {
    appInit();
});

function appInit() {
    tabs();
    mostrarSeccion();
    btnPaginador();
    btnAnterior();
    btnSiguiente();
    consultAPI();
    nombreCliente();
    selectFecha();
    selectHora();
    // showResumen();
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');
    // console.log(botones)

    botones.forEach(boton => {
        boton.addEventListener('click',function (e) {
            
            paso = parseInt(e.target.dataset.paso);
            // console.log(paso)
            mostrarSeccion();
            btnPaginador();
        })
    })
}

function mostrarSeccion() {
    
    const seccionAnterior = document.querySelector('.mostrar');

    if (seccionAnterior) {
        // console.log("remove .mostrar")
        seccionAnterior.classList.remove('mostrar');
    }

    const seccion = document.querySelector('#paso-'+paso);
    seccion.classList.add('mostrar');

    const btn_anterior = document.querySelector('.actual');
    btn_anterior.classList.remove('actual');

    const btn_actual = document.querySelector(`[data-paso="${paso}"]`);
    btn_actual.classList.add('actual');
}

function btnPaginador() {
    const pagAnterior = document.querySelector('#anterior');
    const pagSiguiente = document.querySelector('#siguiente');

    const pagOculta = document.querySelector('.paginacion .ocultar');

    if (pagOculta) {
        // console.log("remove .ocultar")
        pagOculta.classList.remove('ocultar');
    }

    if (paso === 1) {
        pagAnterior.classList.add('ocultar');
    }else if (paso === 3) {
        pagSiguiente.classList.add('ocultar');
        showResumen();
    }
}

function btnAnterior() {
    const btnAnterior = document.querySelector('#anterior');

    btnAnterior.addEventListener('click',function () {

        if (paso <= paso_Inicial) return;

        paso--;
        btnPaginador();
        mostrarSeccion();
    })

}

function btnSiguiente() {
    const btnSiguiente = document.querySelector('#siguiente');

    btnSiguiente.addEventListener('click',function () {

        if (paso >= paso_Final) return;

        paso++;
        btnPaginador();
        mostrarSeccion();
    })
}

async function consultAPI() {
    
    try {
        const url = `${location.origin}/api/servicios`;

        const result =await fetch(url);

        const servicios =await result.json();

        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {

    servicios.forEach(servicio =>{
        const { id,nombre,precio } = servicio;

        const p_Servicio = document.createElement('p');
        p_Servicio.classList.add('nombre-servicio');
        p_Servicio.textContent = nombre;

        const p_Precio = document.createElement('p');
        p_Precio.classList.add('precio-servicio');
        p_Precio.textContent = `$${precio}`;
        
        const div_Servicio = document.createElement('div');
        div_Servicio.classList.add('servicio');
        div_Servicio.dataset.idServicio= id;

        div_Servicio.onclick = function () {
            selectServicio(servicio);
        };

        div_Servicio.appendChild(p_Servicio);
        div_Servicio.appendChild(p_Precio);

        document.querySelector('#servicios').appendChild(div_Servicio);
    });
}

function selectServicio(servicio) {


    const div_Servicio = document.querySelector(`[data-id-servicio="${servicio.id}"]`);

    // Codigo creado por mi
    // if (div_Servicio.classList.contains('seleccionado')) {

    //     cita.servicios.forEach( select_serv => {

    //         if (select_serv.id === servicio.id) {
    //             cita.servicios.splice(cita.servicios.indexOf(servicio),1)
    //         }

    //     });

    //     div_Servicio.classList.remove('seleccionado');
    // }else{
    //     cita.servicios.push(servicio);
    //     div_Servicio.classList.add('seleccionado');
    // }

    // Codigo del curso

    if (cita.servicios.some( agregado => agregado.id === servicio.id)) {
        
        cita.servicios = cita.servicios.filter( agregado => agregado.id !== servicio.id)

        div_Servicio.classList.remove('seleccionado');
    } else {
        cita.servicios.push(servicio);
        div_Servicio.classList.add('seleccionado');
    }

}

function nombreCliente() {
    const nombre = document.querySelector('#nombre').value;

    cita.nombre = nombre;
}

function selectFecha() {
    const inputFecha = document.querySelector('#fecha');

    inputFecha.addEventListener('input',function (e) {
        
        const dia = new Date(e.target.value).getUTCDay();

        if ([6,0].includes(dia)) {
            cita.fecha = e.target.value = '';

            showAlerta({msg:'Fines de semana no permitidos',type:'error',type2:1});
        } else {
            showAlerta({day : dia})

            cita.fecha = e.target.value;
        }
        // console.log(dia)
    });
}

function selectHora() {
    const inputHora = document.querySelector('#hora');

    inputHora.addEventListener('input',function (e){
        
        const hora = e.target.value.split(':')[0];

        if (hora < 10 || hora > 18) {
            
            cita.hora = e.target.value = '';

            showAlerta({msg:'Hora no válida',type:'error',type2:2});

        }else {
            showAlerta({hour:hora});

            cita.hora = e.target.value; 
        }

    })
}

function showAlerta(obj) {

    const alertaPrevia = document.querySelectorAll('#paso-2 p .alerta');

    if (alertaPrevia.length === 1) {

        if ((alertaPrevia[0].textContent.includes('Fines') && obj.day) || (alertaPrevia[0].textContent.includes('Hora') && obj.hour)) {
            alertaPrevia[0].remove();
            return;
        }else if (obj.day || obj.hour) {
            return;
        }else if (obj.msg) {
            
            if (alertaPrevia[0].textContent.includes('Fines') && obj.type2 === 1) {
                return;
            }else if (alertaPrevia[0].textContent.includes('Hora') && obj.type2 === 2) {
                return;
            }
        }

    }else if (alertaPrevia.length > 1) {

        for (let i = 0; i < alertaPrevia.length; i++) {
            const elmt = alertaPrevia[i];

            if ((elmt.textContent.includes('Fines') && obj.day) || (elmt.textContent.includes('Hora') && obj.hour)) {
                elmt.remove();
                return;
            }
            
        }

        if (obj.msg) {
            return;
        }

    }
    else if (obj.day || obj.hour) {
        return;
    }
    
    const alerta = document.createElement('div');
    alerta.textContent = obj.msg;
    alerta.classList.add('alerta');
    alerta.classList.add(obj.type);
    alerta.style.marginTop = '2rem';

    // console.log(alerta)

    const formulario = document.querySelector('#paso-2 p')
    formulario.appendChild(alerta);

    // setTimeout(() => {
    //     alerta.remove();
    // }, 5000);
}

function showAlerta2(obj) {

    const alertaPrevia = document.querySelector('.contenido-resumen p .alerta');

    if (alertaPrevia) {

        if (obj.msg) {
            return;
        }else if (obj.fill) {
            alertaPrevia.remove();
            return;
        }
    }else if (obj.fill) {
        return;
    }

    const alerta = document.createElement('div');
    alerta.textContent = obj.msg;
    alerta.classList.add('alerta');
    alerta.classList.add(obj.type);
    alerta.style.marginTop = '2rem';

    // console.log(alerta)

    const formulario = document.querySelector('.contenido-resumen p')
    formulario.appendChild(alerta);
}

function showResumen() {

    const resumen = document.querySelector('.resumen-datos');

    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        
        showAlerta2({msg:'Faltan datos de Servicios, Fecha u Hora',type:'error'});
        resumen.classList.add('display-none');
        return;
    }

    showAlerta2({fill:true});
    
    resumen.classList.remove('display-none');

    resumen.children[0].innerHTML = resumen.children[0].innerHTML.slice(0,21)+cita.nombre;

    const UTC_date = new Date(cita.fecha);

    const opciones = {timeZone:'UTC',weekday:'long',year:'numeric',month:'long',day:'numeric'};

    const format_date = UTC_date.toLocaleDateString('es-MX',opciones);

    console.log(format_date)

    resumen.children[1].innerHTML = resumen.children[1].innerHTML.slice(0,20)+format_date;
    resumen.children[2].innerHTML = resumen.children[2].innerHTML.slice(0,19)+cita.hora+' Horas';

    if (!document.querySelector('.resumen-datos h2')) {
        const h2Servicios = document.createElement('h2');
        h2Servicios.textContent = 'Resumen de Servicios';
        resumen.appendChild(h2Servicios);
    }

    let arrServicios = [];

    cita.servicios.forEach( (servicio,i) => {

        arrServicios[i] = document.createElement('div');
        arrServicios[i].classList.add('contenedor-servicio');

        const textServicio = document.createElement('p');
        textServicio.textContent = servicio.nombre;

        const precioServicio = document.createElement('p');
        precioServicio.innerHTML = `<span>Precio: </span>$${servicio.precio}`;

        arrServicios[i].appendChild(textServicio);
        arrServicios[i].appendChild(precioServicio);

    });

    if (resumen.children.length === 4) {

        
        arrServicios.forEach( servicio => {

            resumen.appendChild(servicio);

        });
    }else if (resumen.children.length > 4) {

        let i = 0;

        while (i !== 4) {
            i = resumen.children.length-1;
            resumen.children.item(i).remove();
        }


        arrServicios.forEach( servicio => {

            resumen.appendChild(servicio);

        });
    }

    const btnReservar = document.createElement('button');
    btnReservar.classList.add('boton');
    btnReservar.textContent = 'Reservar Cita';
    btnReservar.onclick = reservarCita;

    resumen.appendChild(btnReservar);
}

async function reservarCita() {
    const datos = new FormData();

    const idServicios = cita.servicios.map(servicio => servicio.id)

    datos.append('fecha',cita.fecha);
    datos.append('hora',cita.hora);
    // datos.append('nombre',cita.nombre);
    datos.append('servicios',idServicios);

    // console.log(idServicios)

    const url = `${location.origin}/api/citas`;

    try {

        const response = await fetch(url,{
            method: 'POST',
            body: datos
        });
    
        console.log(response)
    
        const result = await response.json();
    
        if (result) {
            Swal.fire({
                icon: 'success',
                title: 'Cita Creada',
                text: 'Tu cita fue creada correctamente'
            })

            // setTimeout(() => {
            //     window.location.reload();
            // }, 2000);

        }

    } catch (error) {

        console.log(error)

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al guardar la cita'
        })

    }
}
