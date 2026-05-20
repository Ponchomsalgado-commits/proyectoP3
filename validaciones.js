
function validarFormulario(evento) {
    const form = document.getElementById('formRegistro');
    const matricula = form.matricula_alumno.value;
    const fechaInicio = form.fecha_inicio_lecutura.value;
    const fechaFinal = form.fecha_final_lecutura.value;

    const regexNumeros = /^[0-9]+$/; 
    
    if (!regexNumeros.test(matricula)) {
      alert("⚠️ Error: La matrícula solo debe contener números, sin letras ni espacios.");
      evento.preventDefault(); 
      return false;
    }

    if (matricula.length < 5) {
      alert("⚠️ Error: La matrícula es muy corta. Revisa el número.");
      evento.preventDefault();
      return false;
    }

    const fecha1 = new Date(fechaInicio);
    const fecha2 = new Date(fechaFinal);

    if (fecha2 < fecha1) {
      alert("⏳ Error de lógica: La fecha de término de lectura no puede ser anterior a la fecha de inicio.");
      evento.preventDefault(); 
      return false;
    }

    return true; 
}