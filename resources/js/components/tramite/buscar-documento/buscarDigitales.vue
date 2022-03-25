<template>
  <div>
    <nav class="navbar navbar-gorehco navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a href="" class="navbar-brand">{{ titulo }}</a>
        </div>
      </div>
    </nav>
    <section class="jumbotron">
      <div v-if="status" class="container">
        <button class="btn btn-sm btn-danger" @click="nuevaBusqueda()">Nueva busqueda</button>
      </div>
    </section>
    <div v-if="!status" class="container">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel-group">
          <div class="panel panel-success">
            <form class="form-horizontal" @submit.prevent="recaptcha()">
              <div class="panel panel-success">
                <div class="panel-heading">VERIFICACIÓN DE DOCUMENTOS FIRMADOS DIGITALMENTE</div>
                <div class="panel-body text-center">
                  <div class="form-group">
                    <label class="col-md-4 control-label">Reg. Doc.</label>
                    <div class="col-md-6">
                      <input v-model="formData.iddocumento" type="text" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-4 control-label">Contraseña</label>
                    <div class="col-md-6">
                      <input v-model="formData.docu_contrasenia" type="text" class="form-control" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="panel panel-success">
                <div class="panel-body text-right">
                  <button class="btn btn-success">Buscar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="col-md-10">
        <iframe
          v-if="status"
          :src="routePrintPdf.replace(/%s/, formData.id).replace(/%s/s, formData.iddocumento)"
          frameborder="0"
          style="width:130%; height:845px;"
        ></iframe>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  
  props:{
          routePrintPdf:{
              type: String,
              default: ''
            }, 
          routeBuscarDigital:{
              type: String,
              default: ''
            }, 
          titulo:{
              type: String,
              default: ''
            }
        },
  
  data() {
    return {
      formData: {
        iddocumento: null,
        docu_contrasenia: null,
        id:null,
        token: null
      },
      status: false
    }
  },

  methods: {
    buscarDocumento() {
      axios.get(this.routeBuscarDigital, { params: this.formData }).then(response => {
        if (response.data.status) {
          this.status = response.data.status
          this.formData.id = response.data.data.id
        } else {
          alert('No se encontro el digital del documento')
        }
      })
    },

    recaptcha() {
      if (this.formData.iddocumento > 0) {
        this.$recaptcha('login').then(token => {
          this.formData.token = token
          this.buscarDocumento()
          //console.log(token) // Will print the token
        })
      } else {
        alert('Digite bien el registro')
      }
    },

    nuevaBusqueda() {
      this.status = false
      this.formData = {}
    }
  }
}
</script>
