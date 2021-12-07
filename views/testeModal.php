<?php 
  include_once('commun/ent_foot/entete.php');
?>

<body>

<!--
  Forked from:
  https://quasar.dev/vue-components/dialog#example--with-containerized-qlayout
-->
<div id="q-app" style="min-height: 100vh;">
  <div class="q-pa-md q-gutter-sm">
    <q-btn label="Documents" color="primary" @click="layout = true"></q-btn>

    <q-dialog v-model="layout">
      <q-layout view="Lhh lpR fff" container class="bg-white">
        <q-header class="bg-white">
          <q-toolbar>
               <!-- <q-toolbar-title>Documents</q-toolbar-title> -->
            <q-btn flat v-close-popup round dense icon="close" color="black"></q-btn>
          </q-toolbar>
        </q-header>

        <q-page-container>
          <q-page padding>
           
  <!-- tableau modal -->
    <div class="q-pa-md">
      <q-table
        title="Treats"
        :rows="rowss"
        :columns="columnss"
        row-key="id"
        :filter="filter"
        :loading="loading"
        
      >
    <template v-slot:body-cell-affecter="props">
      <q-td key="affecter" :props="props">
        <q-icon name="check_circle_outline" size="2.5em"></q-icon>
      </q-td>
    </template>

    <template v-slot:body-cell-ajouter="props">
      <q-td key="ajouter" :props="props">
        <q-icon name="add" size="2.5em"></q-icon>
      </q-td>
    </template>
   
<!-- boutton et champ de recherche -->
      <template v-slot:top>
        <q-btn color="primary" :disable="loading" label="Save" @click="addRow"></q-btn>
        <q-space></q-space>
        <q-input  outlined  color="primary" v-model="filter">
          <template v-slot:append>
            <q-icon name="search"></q-icon>
          </template>
        </q-input>
      </template>
    </q-table>
  </div>
 </q-page>
 </q-page-container>
      </q-layout>
    </q-dialog>
  </div>
</div>
    <script src="/COMMUN/framework-css-js/vue.js/3.0.11/vue.js"></script>
    <script src="/COMMUN/framework-css-js/quasar/2.0.0-beta.12/quasar.umd.js"></script>
    <script>
    const { ref, computed } = Vue

    const columnss = [
  {
    name: 'Nom',
    required: true,
    label: 'Nom',
    align: 'left',
    field: row => row.name,
    format: val => `${val}`,
    sortable: true
  },
  { name: 'DaréeAffichage',
     label: 'Darée Affichage',
    field: 'DaréeAffichage',
    align: 'center', 
     sortable: true },
  { name: 'Date DV', label: 'Date DV', field: 'DateDV' , align: 'center',},
  { name: 'Date FV', label: 'Date FV', field: 'DateFV' , align: 'center',},
  { name: 'Raffrechir', label: 'Raffrechir', field: 'Raffrechir' , align: 'center',},
  { name: 'affecter', label: 'Affecter', field: 'Affecter', align: 'center', },
  { name: 'ajouter', label: 'Ajouter', field: 'Ajouter',  align: 'center', }
]

const originalRows = [
  {
    name: 'Instruction',
    DaréeAffichage:10,
    DateDV:'12/01/2021',
    DateFV:'12/12/2021',
    Raffrechir:'30 minutes',
  },
  {
    name: 'Precotions',
    DaréeAffichage:10,
    DateDV:'10/11/2018',
    DateFV:'10/12/2021',
    Raffrechir:'30 minutes',
    
  },
  {
    name: 'Test',
    DaréeAffichage:10,
    DateDV:'12/08/2021',
    DateFV:'12/12/2025',
    Raffrechir:'30 minutes',
  
  },
 
  {
    name: 'Zenutude',
    DaréeAffichage:10,
    DateDV:'01/01/2020',
    DateFV:'12/12/2025',
    Raffrechir:'30 minutes',
  
  }
]

const app = Vue.createApp({
  setup () {
    const moreContent = ref(true)
    const loading = ref(false)
    const filter = ref('')
    const rowCount = ref(10)
    const rowss = ref([...originalRows])

    return {
      layout: ref(false),
      columnss,
      rowss,

      loading,
      filter,
      rowCount,

    }
  }
})

app.use(Quasar, { config: {} })
app.mount('#q-app')

     </script>


</body>
</html>