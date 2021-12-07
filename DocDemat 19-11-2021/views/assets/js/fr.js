
// import NomDuComposant from './components/NomDuComposant.js' // exemple import composant

const { ref, computed, onMounted } = Vue
// cadre de travail
const stringOptions = ['Bras-1', 'Four', 'Machine', 'Bras-2', 'Palette']
// const model=[]
// tableau mot cle
const columns = [{
    name: 'name',
    required: true,
    label: 'Nom',
    align: 'left',
    field: row => row.name,
    format: val => `${val}`,
    sortable: true
},
{
    name: 'affecter',
    label: 'Affecter',
    field: 'affecter',
    align: 'center'
},
{
    name: 'supprimer',
    field: 'supprimer',
    align: 'center'
}
]
const rows = [{
    name: 'Description'
},
{
    name: 'Precotion'
},
{
    name: 'Precotion'
},
{
    name: 'Description'
},
{
    name: 'Precotion'
},
{
    name: 'Precotion'
}
]
// tableau documents
const roudocument = [{
    Nom: 'Consigne',
    DureeAffichage: 159,
    DateDV: 6.0,
    DateDFV: 24,
    Rafraichir: 4.0,
    Affecter: "oui"
},
{
    Nom: 'Mode Emploi',
    DureeAffichage: 237,
    DateDV: 9.0,
    DateDFV: 37,
    Rafraichir: 4.3,
    Affecter: "oui"
},
{
    Nom: 'Points importants',
    DureeAffichage: 262,
    DateDV: 16.0,
    DateDFV: 23,
    Rafraichir: 6.0,
    Affecter: "oui"
},
{
    Nom: 'Attention',
    DureeAffichage: 305,
    DateDV: 3.7,
    DateDFV: 67,
    Rafraichir: 4.3,
    Affecter: "oui"
},
{
    Nom: 'Description',
    DureeAffichage: 356,
    DateDV: 16.0,
    DateDFV: 49,
    Rafraichir: 3.9,
    Affecter: "oui"
},
{
    Nom: 'Details',
    DureeAffichage: 375,
    DateDV: 0.0,
    DateDFV: 94,
    Rafraichir: 0.0,
    Affecter: "oui"
},
{
    Nom: 'Outils',
    DureeAffichage: 392,
    DateDV: 0.2,
    DateDFV: 98,
    Rafraichir: 0,
    Affecter: " oui"
}
]
// modaldoc
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
    {
        name: 'DaréeAffichage',
        label: 'Darée Affichage',
        field: 'DaréeAffichage',
        align: 'center',
        sortable: true
    },
    { name: 'Date DV', label: 'Date DV', field: 'DateDV', align: 'center', },
    { name: 'Date FV', label: 'Date FV', field: 'DateFV', align: 'center', },
    { name: 'Raffrechir', label: 'Raffrechir', field: 'Raffrechir', align: 'center', },
    { name: 'affecter', label: 'Affecter', field: 'Affecter', align: 'center', },
    { name: 'ajouter', label: 'Ajouter', field: 'Ajouter', align: 'center', }
]

const originalRows = [
    {
        name: 'Instruction',
        DaréeAffichage: 10,
        DateDV: '12/01/2021',
        DateFV: '12/12/2021',
        Raffrechir: '30 minutes',
    },
    {
        name: 'Precotions',
        DaréeAffichage: 10,
        DateDV: '10/11/2018',
        DateFV: '10/12/2021',
        Raffrechir: '30 minutes',

    },
    {
        name: 'Test',
        DaréeAffichage: 10,
        DateDV: '12/08/2021',
        DateFV: '12/12/2025',
        Raffrechir: '30 minutes',

    },

    {
        name: 'Zenutude',
        DaréeAffichage: 10,
        DateDV: '01/01/2020',
        DateFV: '12/12/2025',
        Raffrechir: '30 minutes',

    }
]

const app = Vue.createApp({
    setup() {
        const model = ref(null)
        const filterOptions = ref(stringOptions)
        // modaldoc
        const moreContent = ref(true)
        const loading = ref(false)
        const filter = ref('')
        const rowCount = ref(10)
        const rowss = ref([...originalRows])
        const test = ref(null)
        const listeMotCle = ref(null)

        //Pour la page AccAdmin.php
        const cadres = ref(["Ecran Principal", "Four", "Machine", "divers", "Transpal",
            "Machines Combinées", "Bras 1",
            "Bras 2", "Bras 3", "", ""])

        //Pour les tableaux
        const createValue = (val, done) => {
            if (val.length > 0) {
                const modelValue = (model.value || []).slice()
                val
                    .split(/[,;|]+/)
                    .map(v => v.trim())
                    .filter(v => v.length > 0)
                    .forEach(v => {
                        if (stringOptions.includes(v) === false) {
                            stringOptions.push(v)
                        }
                        if (modelValue.includes(v) === false) {
                            modelValue.push(v)
                        }
                    })

                done(null)
                model.value = modelValue
            }
        }
//Dans la page AccAdmin.php
        const addcadres = (v) => {
            cadres.value.push({});
        }

        const loadDocument = async (id = "") => {
            // example
            try {
                const url = `./../controllers/documents/findDocument.php?id=${id}`
                console.log(url)
                const res = await axios.get(url)
                test.value = res.data
                console.log(test.value)
            } catch (error) {
                console.log("On est dans l'erreur")
                alert(error.message)
            }
        }
        const listeDeMotCle= async () => {
            // au démarrage de la page
            try {
                const url = './../controllers/motCleCadre/listeMotCleCtrl.php'
                const res = await axios.get(url)
                listeMotCle.value = res.data
            } catch (error) {
                console.log("On est dans l'erreur")
                console.error(error.message)
            }
        }

        const initPage = async () => {
            await listeDeMotCle()
        }

        onMounted(initPage)
        

        return {
            //tests
            test,
            loadDocument,
            //Pour la page AccAdmin.php
            cadres,
            print,
            //Page AjoutModif.php
            listeMotCle,
            //pagigation AccAdmin.php
            current: ref(3),
            //Pour la page accueilScan.php
            text: ref(''),
            slide: ref(1),
            autoplay: ref(true),
            ph: ref(''),
            dense: ref(false),
            //Cadre de travail (options du nom de cadre)
            // optionss: [],
            cadreDeTravail: [],
            // mot cles
            columns,
            rows,
            // modaldoc
            roudocument,
            alert: ref(false),
            layout: ref(false),
            columnss,
            rowss,

            loading,
            filter,
            rowCount,
            // Ajouter une icone
            fixed: ref(false),
            text: ref(''),
            file: ref(null),

            // options du diapo
            group: ref('oui'), //permet de selectionner l'element 
            options: [{
                label: 'oui',
                value: 'oui'
            },
            {
                label: 'non',
                value: 'non'
            },
            ],
            model,
            filterOptions,
            createValue,

            filterFn(val, update) {
                update(() => {
                    if (val === '') {
                        filterOptions.value = stringOptions
                    } else {
                        const needle = val.toLowerCase()
                        filterOptions.value = stringOptions.filter(
                            v => v.toLowerCase().indexOf(needle) > -1
                        )
                    }
                })
            },
            addcadres,
        }
    },
    //Pour la page AccAdmin.php accede a la fonction d'impression
    methods: {
        print() {
            this.$htmlToPaper('printMe');
        },
    }
})

// app.component('NomDuComposant', NomDuComposant)
app.use(Quasar, { config: {} })
app.mount('#q-app')

{/* <template>
  <vue-carousel :data="data"></vue-carousel>
</template>

<script>
export default {
  data() {
    return {
      data: [
        '<div class="example-slide">Slide 1</div>',
        '<div class="example-slide">Slide 2</div>',
        '<div class="example-slide">Slide 3</div>',
      ],
    };
  },
};
</script>

<style>
.example-slide {
  align-items: center;
  background-color: #666;
  color: #999;
  display: flex;
  font-size: 1.5rem;
  justify-content: center;
  min-height: 10rem;
}
</style> */}
