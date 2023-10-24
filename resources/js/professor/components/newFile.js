import axios from 'axios';

export default (await import('vue')).defineComponent({
props: [
'user_id',
'sala_id',
'disciplinas'
],

data() {
return {
disciplina_id: "",
aulas: [],
base_url: process.env.MIX_APP_URL,
chamando: false
};
},

computed: {
emAtendimento: function () {
return idx => {
return (Array.isArray(this.$store.getters.getAulas[idx].em_atendimento) && this.$store.getters.getAulas[idx].em_atendimento.length)
? true
: false;
};
},

checkVal: function () {
return this.chamando;
}
},

methods: {
isUser(user_id) {
return (user_id == this.user_id) ? 'font-weight-bold text-light bg-dark' : '';
},
carregarAulas() {
axios.get(process.env.MIX_APP_URL + '/api/aulasala/' + this.sala_id, { assinc: true })
.then(response => {
this.$store.commit('setAulas', response.data);
})
.catch(error => {
if (error.response.status == 401) {
window.location.href = process.env.MIX_APP_URL;
} else {
this.$toast.open({
message: error.response.data.message,
type: 'error',
// all of other options may go here
});
}
});
},

chamar(aula_id) {

axios.post(process.env.MIX_APP_URL + '/api/chamar',
{
aula_id: aula_id,
}
)
.then(response => {

if (response.status == 201) {
if ((response.data.result == true) && (response.data.aluno != null)) {
this.chamando = true;
setInterval(() => {
this.chamando = false;
}, 30000);
this.sendSMS(response.data);
}
}
})
.catch(error => {
console.log(error);
if (error.response.status == 401) {
window.location.href = process.env.MIX_APP_URL;
} else {
this.$toast.open({
message: error.response.data.message,
type: 'error',
// all of other options may go here
});
}
});

},

cadastraraula() {
if (this.disciplina_id == "") {
this.$swal.fire(
'Erro ao Ativar!',
'Selecione a Disciplina',
'danger');
} else {
axios.post(process.env.MIX_APP_URL + '/api/cadastraraula',
{
sala_id: this.sala_id,
professor_id: this.user_id,
disciplina_id: this.disciplina_id,
}
)
.then(response => {
if (response.status == 201) {
this.$swal.fire(
'OK!',
'Aula Cadastrada',
'success');
}
})
.catch(error => {
if (error.response.status == 401) {
window.location.href = process.env.MIX_APP_URL;
} else {
this.$toast.open({
message: error.response.data.message,
type: 'error',
// all of other options may go here
});
}
});
}

},

pausar(aula_id) {
axios.post(process.env.MIX_APP_URL + '/api/pausar',
{
aula_id: aula_id,
}
)
.catch(error => {
if (error.response.status == 401) {
window.location.href = process.env.MIX_APP_URL;
} else {
this.$toast.open({
message: error.response.data.message,
type: 'error',
// all of other options may go here
});
}
});

},

finalizar(aula_id) {
this.$swal.fire(
{
title: 'Deseja finalizar o atendimento?',
text: "A fila de alunos será apagada!",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Sim, Finalizar'
}).
then((result) => {
if (result.isConfirmed) {
axios.post(process.env.MIX_APP_URL + '/api/finalizar',
{
aula_id: aula_id,
})
.then((result) => {
this.$swal.fire(
'OK!',
'Aula Finalizada',
'success');
window.location.href = process.env.MIX_APP_URL + '/professor';
}).
catch(error => {
if (error.response.status == 401) {
window.location.href = process.env.MIX_APP_URL;
} else {
this.$toast.open({
message: error.response.data.message,
type: 'error',
// all of other options may go here
});
}
});
}
});

},

redirect(url) {
window.location.href = url;
},

listenChannel() {
window.Echo.channel('aulasala.' + this.sala_id)
.listen('.getAulaSala', (e) => {
this.$store.commit('setAulas', e.data);
}
);
window.Echo.channel('painelsala.' + 1)
.listen('.getPainelSala', (e) => {
console.log(e);
// this.$store.commit('setAtendimentos',e.data) ;
});
},

sendSMS(data) {

if (data.aluno.send_sms == 1 && data.aluno.celular != '' && data.aluno.celular.replace(/\D/g, '').length == 11) {
var phone = data.aluno.celular.replace(/\D/g, '');
const sms_data = {
id: '1',
phone: phone,
message: 'Bora!! ' + data.aluno.name + '. Chegou sua vez ' + data.aula.sala.titulo + ' - Professor: ' + data.aula.professor.name + ' Disciplina: ' + data.aula.disciplina.titulo,
};

const options = {
method: 'POST',
url: 'https://api.plataformadesms.com.br/v2/message/single',
headers: {
Key: 'RQ96HSnCByXeddf',
'Content-Type': 'application/json',
},
data: sms_data, // Usamos 'data' para passar os dados no Axios
};

axios(options)
.then((response) => {
// console.log(response.data);
console.log("sms enviado");
})
.catch((error) => {
if (error.response) {
console.error('Erro de resposta:', error.response.data);
} else {
console.error('Erro na requisição:', error.message);
}
});
}

}
},

mounted() {
this.carregarAulas();
this.listenChannel();
}
});
