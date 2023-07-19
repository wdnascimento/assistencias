<template>
    <div id="primeiroApp">
        Contador: {{ contador }}
        <button v-on:click="toggle">{{ acaoContador() }}</button>
    </div>
</template>

<script>
    export default {
        mounted() {
          // console.log('Component mounted.')
        },

        data(){
            return {
                contador: 0,
                timer: null
            }
        },

        methods: {

         toggle() {
            let vm = this;

            if (this.timer) {

              clearInterval(this.timer);

              this.timer = null;

            } else {

              this.timer = setInterval(function() {

                  axios.get('http://nextone.vestiba.net/api/teste')
                  .then(response => {
                  })
                  .catch(error => {
                  })
                   // console.log('aumentou.'+ vm.getContador())
                    vm.setContador(vm.getContador() + 1);

              }, 1000);

            }
          },

          getContador(){
              return this.contador;
          },

          getUrl(){
              return this.url;
          },

          setContador(valor){
              this.contador = valor;
          },
          setUrl(valor){
              this.url = valor;
          },
          acaoContador: function acaoContador() {
            if (this.timer) {
                return 'parar';
            } else {
              return 'começar';
            }
          }
        }
    }
</script>
