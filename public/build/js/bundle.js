let paso=1;const paso_Inicial=1,paso_Final=3,cita={nombre:"",fecha:"",hora:"",servicios:[]};function appInit(){tabs(),mostrarSeccion(),btnPaginador(),btnAnterior(),btnSiguiente(),consultAPI(),nombreCliente(),selectFecha(),selectHora()}function tabs(){document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",(function(e){paso=parseInt(e.target.dataset.paso),mostrarSeccion(),btnPaginador()}))})}function mostrarSeccion(){const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar");document.querySelector("#paso-"+paso).classList.add("mostrar");document.querySelector(".actual").classList.remove("actual");document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}function btnPaginador(){const e=document.querySelector("#anterior"),t=document.querySelector("#siguiente"),n=document.querySelector(".paginacion .ocultar");n&&n.classList.remove("ocultar"),1===paso?e.classList.add("ocultar"):3===paso&&(t.classList.add("ocultar"),showResumen())}function btnAnterior(){document.querySelector("#anterior").addEventListener("click",(function(){paso<=1||(paso--,btnPaginador(),mostrarSeccion())}))}function btnSiguiente(){document.querySelector("#siguiente").addEventListener("click",(function(){paso>=3||(paso++,btnPaginador(),mostrarSeccion())}))}async function consultAPI(){try{const e=location.origin+"/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:n,precio:o}=e,c=document.createElement("p");c.classList.add("nombre-servicio"),c.textContent=n;const a=document.createElement("p");a.classList.add("precio-servicio"),a.textContent="$"+o;const i=document.createElement("div");i.classList.add("servicio"),i.dataset.idServicio=t,i.onclick=function(){selectServicio(e)},i.appendChild(c),i.appendChild(a),document.querySelector("#servicios").appendChild(i)})}function selectServicio(e){const t=document.querySelector(`[data-id-servicio="${e.id}"]`);cita.servicios.some(t=>t.id===e.id)?(cita.servicios=cita.servicios.filter(t=>t.id!==e.id),t.classList.remove("seleccionado")):(cita.servicios.push(e),t.classList.add("seleccionado"))}function nombreCliente(){const e=document.querySelector("#nombre").value;cita.nombre=e}function selectFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)?(cita.fecha=e.target.value="",showAlerta({msg:"Fines de semana no permitidos",type:"error",type2:1})):(showAlerta({day:t}),cita.fecha=e.target.value)}))}function selectHora(){document.querySelector("#hora").addEventListener("input",(function(e){const t=e.target.value.split(":")[0];t<10||t>18?(cita.hora=e.target.value="",showAlerta({msg:"Hora no válida",type:"error",type2:2})):(showAlerta({hour:t}),cita.hora=e.target.value)}))}function showAlerta(e){const t=document.querySelectorAll("#paso-2 p .alerta");if(1===t.length){if(t[0].textContent.includes("Fines")&&e.day||t[0].textContent.includes("Hora")&&e.hour)return void t[0].remove();if(e.day||e.hour)return;if(e.msg){if(t[0].textContent.includes("Fines")&&1===e.type2)return;if(t[0].textContent.includes("Hora")&&2===e.type2)return}}else if(t.length>1){for(let n=0;n<t.length;n++){const o=t[n];if(o.textContent.includes("Fines")&&e.day||o.textContent.includes("Hora")&&e.hour)return void o.remove()}if(e.msg)return}else if(e.day||e.hour)return;const n=document.createElement("div");n.textContent=e.msg,n.classList.add("alerta"),n.classList.add(e.type),n.style.marginTop="2rem";document.querySelector("#paso-2 p").appendChild(n)}function showAlerta2(e){const t=document.querySelector(".contenido-resumen p .alerta");if(t){if(e.msg)return;if(e.fill)return void t.remove()}else if(e.fill)return;const n=document.createElement("div");n.textContent=e.msg,n.classList.add("alerta"),n.classList.add(e.type),n.style.marginTop="2rem";document.querySelector(".contenido-resumen p").appendChild(n)}function showResumen(){const e=document.querySelector(".resumen-datos");if(Object.values(cita).includes("")||0===cita.servicios.length)return showAlerta2({msg:"Faltan datos de Servicios, Fecha u Hora",type:"error"}),void e.classList.add("display-none");showAlerta2({fill:!0}),e.classList.remove("display-none"),e.children[0].innerHTML=e.children[0].innerHTML.slice(0,21)+cita.nombre;const t=new Date(cita.fecha).toLocaleDateString("es-MX",{timeZone:"UTC",weekday:"long",year:"numeric",month:"long",day:"numeric"});if(console.log(t),e.children[1].innerHTML=e.children[1].innerHTML.slice(0,20)+t,e.children[2].innerHTML=e.children[2].innerHTML.slice(0,19)+cita.hora+" Horas",!document.querySelector(".resumen-datos h2")){const t=document.createElement("h2");t.textContent="Resumen de Servicios",e.appendChild(t)}let n=[];if(cita.servicios.forEach((e,t)=>{n[t]=document.createElement("div"),n[t].classList.add("contenedor-servicio");const o=document.createElement("p");o.textContent=e.nombre;const c=document.createElement("p");c.innerHTML="<span>Precio: </span>$"+e.precio,n[t].appendChild(o),n[t].appendChild(c)}),4===e.children.length)n.forEach(t=>{e.appendChild(t)});else if(e.children.length>4){let t=0;for(;4!==t;)t=e.children.length-1,e.children.item(t).remove();n.forEach(t=>{e.appendChild(t)})}const o=document.createElement("button");o.classList.add("boton"),o.textContent="Reservar Cita",o.onclick=reservarCita,e.appendChild(o)}async function reservarCita(){const e=new FormData,t=cita.servicios.map(e=>e.id);e.append("fecha",cita.fecha),e.append("hora",cita.hora),e.append("servicios",t);const n=location.origin+"/api/citas";try{const t=await fetch(n,{method:"POST",body:e});console.log(t);await t.json()&&Swal.fire({icon:"success",title:"Cita Creada",text:"Tu cita fue creada correctamente"})}catch(e){console.log(e),Swal.fire({icon:"error",title:"Error",text:"Hubo un error al guardar la cita"})}}document.addEventListener("DOMContentLoaded",(function(){appInit()}));
//# sourceMappingURL=bundle.js.map
