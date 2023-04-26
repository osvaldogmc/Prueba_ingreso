const getComunasPorRegion = async( id ) => {
    const formData = new FormData();
    formData.append('id', id);
    const respuesta = await fetch('helpers/get_comunas_region.php', {
        method: 'POST', 
        body: formData,
    });
    const data = await respuesta.json();
    return data;
}

const validaRut = ( rut ) => {
    rut = rut.replace(/\./g, '');
    rut = rut.replace('-', '');
    var cuerpo = rut.slice(0, -1);
    var dv = rut.slice(-1).toUpperCase();
    var suma = 0;
    var multiplicador = 2;
    for ( var i = cuerpo.length - 1; i >= 0; i-- ) {
        suma += multiplicador * cuerpo.charAt(i);
        multiplicador++;
        if ( multiplicador > 7 ) {
            multiplicador = 2;
        }
    }
    var resultado = 11 - ( suma % 11 );
    if ( resultado == 10 ) {
        resultado = 'K';
    } else if (resultado == 11) {
        resultado = '0';
    }
    if ( resultado == dv ) {
        return true;
    } else {
        return false;
    }
}
const validaFormulario = ( formData ) => {
    var respuesta = {
        ok: true,
    }
    var data = {}
    for (const value of formData.entries()) {
        data = {
            ...data,
            [value[0]]: value[1],
        }
    }
    if ( data['user_name'].trim() === '') {
        return {
            ...respuesta,
            ok: false,
            mensaje: 'Debes ingresar nombre y apellido',
        }
    }
    if (
        data['user_alias'].trim().length < 5 ||
        data['user_alias'].trim() === ''
        )   
    {   
        return {
            ...respuesta,
            ok: false,
            mensaje: 'El alias debe contener al menos 5 carácteres',
        }
    } else {
        var regEx = new RegExp(/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/);
        if ( !regEx.test(data['user_alias']) ) {
            return {
                ...respuesta,
                ok: false,
                mensaje: 'El alias debe contener letras y números',
            }
        }
    }
    if ( data['user_rut'].trim() == '' ) {
        return {
            ...respuesta,
            ok: false,
            mensaje: 'Debe ingresar un rut',
        }
    } else {
        if ( !validaRut(data['user_rut']) ) {
            return {
                ...respuesta,
                ok: false,
                mensaje: 'El rut no es válido',
            }
        }
    }
    if ( data['user_mail'].trim() == '' ) {
        return {
            ...respuesta,
            ok: false,
            mensaje: 'Debe ingresar el correo',
        }
    } else {
        var regEx = new RegExp(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/);
        if ( !regEx.test(data['user_mail']) ) {
            return {
                ...respuesta,
                ok: false,
                mensaje: 'El correo no es válido',
            }
        }
    }
    if ( data['region'] == 0 ) {
        return {
            ...respuesta,
            ok: false,
            mensaje: 'Debe seleccionar una región',
        }
    }
    if ( data['comuna'] == 0 ) {
        return {
            ...respuesta,
            ok: false,
            mensaje: 'Debe seleccionar una comuna',
        }
    }
    if ( data['candidato'] == 0 ) {
        return {
            ...respuesta,
            ok: false,
            mensaje: 'Debe seleccionar un candidato',
        }
    }
    let chks = 0;
    if ( data['chkWeb'] === 'true' ) chks += 1;
    if ( data['chkTv'] ==='true' ) chks += 1;
    if ( data['chkRrss'] === 'true' ) chks += 1;
    if ( data['chkAmigo'] === 'true' ) chks += 1;
    if ( chks < 2 ) {
        return {
            ...respuesta,
            ok: false,
            mensaje: 'Debe seleccionar al menos dos opciones',
        }
    }
    return respuesta;
}

const enviarFormulario = async ( formData, url ) => {
    const respuesta = await fetch(url, {
        method: 'POST', 
        body: formData,
    });
    const data = await respuesta.json();
    return data;
}

document.getElementById('region').addEventListener('change', async ( event ) => {
    if ( event.target.value == 0 ) return alert('Debes seleccionar una region');
    const data = await getComunasPorRegion(event.target.value);
    var html = `
    <option value="0">Seleccionar</option>
    `;
    data.forEach( comuna => {
        html += `
        <option value="${ comuna.id }">${ comuna.nombre } </option>
        `;
    });
    document.getElementById('comuna').innerHTML = html;
});

document.getElementById('btn-submit').addEventListener('click', async ( event ) => {
    event.preventDefault();
    const form = document.getElementById('form-data');
    const formData = new FormData(form);
    const chkWeb = document.getElementById('chk-web').checked;
    formData.append('chkWeb', chkWeb);
    const chkTv = document.getElementById('chk-tv').checked;
    formData.append('chkTv', chkTv);
    const chkRrss = document.getElementById('chk-rrss').checked;
    formData.append('chkRrss', chkRrss);
    const chkAmigo = document.getElementById('chk-amigo').checked;
    formData.append('chkAmigo', chkAmigo);
    const valida = validaFormulario(formData);
    if ( valida.ok ) {
        const respuesta = await enviarFormulario( formData, form.action );
        if (respuesta.hasOwnProperty('estado')) {

            if (respuesta['estado']){
                
                return alert(respuesta['mensaje']);
            } else  {
                return alert(respuesta['mensaje']);
            }
        } else {
            console.log(respuesta);
            return alert('Ha ocurrido un error');
        }
       
    } else {
        alert( valida.mensaje );
    }
});
