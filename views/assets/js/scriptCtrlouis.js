const { ref, computed, onMounted } = Vue
// cadre de travail
const stringOptions = ['Bras-1', 'Four', 'Machine', 'Bras-2', 'Palette']
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
    name: ''
},
{
    name: ''
},
{
    name: ''
},
{
    name: ''
},
{
    name: ''
},
{
    name: ''
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
        const listeIconeCadre = ref(null)
        const icones = ref([]);
        const  nouvNom = ref(null)
        const nouvImage = ref(null)
        const test = ref(null)
        // const mesDonnees = {nom, image}

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
        const addcadres = (v) => {
            cadres.value.push({});
        }
        //Exemple de Louis
        const loadDocument = async (id ="") => {
            // example
            try {
                const url = `./../controllers/documents/findDocument.php?id=${id}`
                console.log(url)
                const res = await axios.get(url)
                test.value = res.data
            } catch (error) {
                console.log("On est dans l'erreur")
                alert(error.message)
            }
        }
        const ajoutModif = async () => {
            // au démarrage de la page
            try {
                const url = './../controllers/AjoutModifCtrl.php'
                const res = await axios.get(url)
                test.value = res.data
            } catch (error) {
                console.log("On est dans l'erreur")
                console.error(error.message)
            }
        }
        
        const initPage = async () => {
            await ajoutModif()
        }

        onMounted(initPage)

        //Fonction qui recupère la liste des icones
        const listIcone = async () =>{
          try{
            const url = './../controllers/iconeCadre/listeIconeDeCadreCtrl.php'
            const res = await axios.get(url)
            listeIconeCadre.value = res.data
          }catch(error){
            console.log("On est dans l'erreur")
            console.error(error.message)
          }
        }
        const icone = async () => {
          await listIcone()
        }
        //Au chargement de la page j'appelle la fonction
        onMounted(icone)

        //Essaie pour la recuperation de données du modal icone
        const createIcon = async () => {
            try {
                const url = '../../controllers/iconeCadre/insererIconeCtrl.php'
                const formData = new FormData()
                formData.append('nom', nouvNom.value)
                formData.append('image', nouvImage.value)
                
                const axiosConfig = {
                    method: 'post',
                    url: url,
                    data: formData,
                    headers: { "Content-Type": "multipart/form-data" }
                }
            const res = await axios(axiosConfig)
            } catch (error) {
                console.error(error)
            }
        }

        //Tous ce qu'on retourne
        return {
            //tests
            createIcon,
            nouvNom,
            nouvImage,
            loadDocument,
            //Pour la page AjoutModif.php
            listeIconeCadre,
            //Pour la page AccAdmin.php
            cadres,
            print,
            //pagigation AccAdmin.php
            current: ref(3),
            //Pour la page accueilScan.php
            text: ref(''),
            slide: ref(1),
            autoplay: ref(true),
            ph: ref(''),
            dense: ref(false),
            //Cadre de travail (options du nom de cadre)
            optionss: [
                'Google', 'Facebook', 'Twitter', 'Apple', 'Oracle'],
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
    //Pour la page AccAdmin.php
    methods: {
        print() {
            this.$htmlToPaper('printMe');
        },
    }
})
app.use(Quasar, { config: {} })
app.mount('#q-app')