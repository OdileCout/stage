// import NomDuComposant from './components/NomDuComposant.js' // exemple import composant

const { ref, computed, onMounted } = Vue

const app = Vue.createApp({
    /***qrcode */
    components: {
        QrcodeVue,
    },
    setup() {
        const affich = 'https://sgetcms1.fmlogistic.fr/TST/Categorie/DocDemat/views/pageAffichageDoc.php'
/******** DOCUMENTS */
//inserer les donées dans le modal du tableau des documents
// modaldoc
    const columnss = ref([
        {
            name: 'Nom',
            required: true,
            label: 'Nom',
            align: 'left',
            sortable: true
        },
        // {
        //     name: 'DuréeAffichage',
        //     label: 'Durée Affichage (minutes)',
        //     field: 'DuréeAffichage',
        //     align: 'center',
        //     sortable: true
        // },
        // { 
        //     name: 'Date DV', 
        //     label: 'Date DV',
        //     field: 'DateDV', 
        //     align: 'center', 
        // },
        // { 
        //     name: 'Date FV',
        //     label: 'Date FV', 
        //     field: 'DateFV', 
        //     align: 'center', 
        // },
        { 
            name: 'affecter', 
            label: 'Affecter', 
            field: 'Affecter', 
            align: 'center', 
        },
        { 
            
            name: 'supprimer',
            label:'Supprimer',
         
        },
    ])
    const keyWordDocs = ref([])
    const loading = ref(false)
    const filter = ref('')
    const rowCount = ref(10)

    const getKeyDocs = async () => {
    // au démarrage de la page
        try {
            const url = './../controllers/documents/listeDesDocumentsCtrl.php'
            const res = await axios.get(url)
                res.data.forEach(keyWord => {
                    keyWord.affected = false
                })
                keyWordDocs.value = res.data
        } catch (error) {
            console.log("On est dans l'erreur")
            console.error(error.message)
        }
    }
    const loadDataOptionsDoc = computed(() => {
        return  keyWordDocs.value.map(doc => doc.nom )
    })
 // fonction pour faire la recherche dans le tableau
    const searchTerm = ref('')
    const filteredDocs = computed(() => { 
    const filteredDocuments =  keyWordDocs.value.filter((doc) => {
        //  console.log(doc);
         return doc.nom.toLowerCase().includes(searchTerm.value.toLowerCase());
       })
    //    console.log(filteredDocuments);
       return filteredDocuments ;
 })
    const documents = async () => {
        await getKeyDocs()
    }
    onMounted(documents)
    //affecter les documents avec une cadre de travail
    //Documents selectionnerz
    const docSelect= ref("")
    const valCheck = ref([])
    const keysDocsSelect = ref([])
    const keysDocsSelectCadre = ref([])
    const displayResult = ref("")
    const columnsDocDesaffecter = ref([
        {
            name: 'Nom',
            required: true,
            label: 'Nom',
            align: 'left'  
        },
        {
            name: 'DuréeAffichage',
            label: 'Durée Affichage',
            field: 'DuréeAffichage',
            align: 'center',
            sortable: true
        },
        { 
            name: 'Date DV', 
            label: 'Date Début Validité',
            field: 'Date DV', 
            align: 'center', 
        },
        { 
            name: 'Date FV',
            label: 'Date Fin Validité', 
            field: 'Date FV', 
            align: 'center', 
        },
        {
            name: 'raffraichissement',
            label: 'raffraichir(min)',
            field: 'raffraichissement',
            align: 'center',
            sortable: true
        },
        {
            name: 'ordreDePriorite',
            label: 'Priorite',
            field: 'ordreDePriorite',
            align: 'center',
            sortable: true
        },
        { 
            name: 'desaffected', 
            label: 'desaffecter', 
            field: 'desaffected',
            sortable: false , 
            align: 'center', 
        },
    ])
    const columnsDoc = ref([
        {
            name: 'Nom',
            required: true,
            label: 'Nom',
            align: 'left'  
        },
        {
            name: 'DuréeAffichage',
            label: 'Durée Affichage',
            field: 'DuréeAffichage',
            align: 'center',
            sortable: true
        },
        { 
            name: 'Date DV', 
            label: 'Date Debut Val',
            field: 'Date DV', 
            align: 'center', 
        },
        { 
            name: 'Date FV',
            label: 'Date Fin Val', 
            field: 'Date FV', 
            align: 'center', 
        },
        {
            name: 'raffraichissement',
            label: 'raffraichir (minutes)',
            field: 'raffraichissement',
            align: 'center',
            sortable: true
        },
        {
            name: 'ordreDePriorite',
            label: 'Priorite',
            field: 'ordreDePriorite',
            align: 'center',
            sortable: true
        },
        { 
            name: 'affected', 
            label: 'affecter', 
            field: 'affected',
            sortable: false , 
            align: 'center', 
        },
    ])
    //Les fonctions
    const addIdDoc = (id) => {
    valCheck.value.push([id])
    // console.log(valCheck.value);
    }
    const saveDoc = async (id) => {
        try {
            // console.log('moi');
            if(valCheck.value !== null){
                id = [valCheck.value]
                // console.log(id);
                // console.log('toi');
            const url = `./../controllers/documents/docmentSelectionnerCtrl.php?id=${id}`
            // console.log(url);
            const res = await axios.get(url)
            //   console.log(res.data);
           
            res.data.forEach(keyWord => {
                keyWord.affected = false
                //  console.log(keyWord.affected);
            });
            keysDocsSelect.value = res.data
            //  console.log(keysDocsSelect.value);
        }
        } catch (error) {
            console.log("On est dans l'erreur")
            console.error(error.message)
        }
    }
/*********************CADRE DE TRAVAIL*********** */
/*********variables* cadre*******/
    const cadreselect=ref(null)
    const  nouveauNom=ref(null)
    const description=ref(null)
    const diaporama=ref(false)
    const id=ref(null)
    const edition =ref(true)
    const cadreDeTravail=ref([])
    const idIconeChange =ref(null)
    const selectionDesci=ref(true)
    const selectionDiapo=ref(true)
    /**Ratacher un documents* */
    const raffraich=ref('')
    const  ordreDePri=ref('')
    const addIdDocCheck = ref(null)
    const checkDoc = (id,raffraichissement,ordreDePriorite) =>{
    addIdDocCheck.value=id;
    raffraich.value=raffraichissement;
    ordreDePri.value=ordreDePriorite;
    // console.log(addIdDocCheck.value);
    }
    const renouvel = async()=>{

    }
    const insertDocumentation = async()=>{
        try{
                 const url = './../controllers/IdcadreEtDocument/documentCadre.php'
                 const formData = new FormData()
                    formData.append('idDocument',  addIdDocCheck.value)
                    formData.append('raffraichissement',   raffraich.value)
                    console.log(raffraich.value)
                    formData.append('ordreDePriorite', ordreDePri.value)
                    console.log(ordreDePri.value)
                    console.log(addIdDocCheck.value)
                  const axiosConfig = {
                        method: 'post',
                        url: url,
                        data: formData,
                        headers: { "Content-Type": "multipart/form-data" }
                   }
          const res =  await axios(axiosConfig)
                //  console.log(res.data);
            }catch(error){
                 console.error(error.message);
             } 
         }
         const attacherDocAvecRaffraich = async (id,raffraichissement,ordreDePriorite) =>{
            checkDoc(id,raffraichissement,ordreDePriorite),
            insertDocumentation()
         }
         //Si le cadre de travail est créer mais la personne a oublier d'attacher des documents avec
        const idDuCadre = ref('')
        const prendreITemraffraichOdrePri = (id,idCadre,raffraichissement,ordreDePriorite,dureeAffichage,dateDebut,dateFin) =>{
            addIdDocCheck.value = id;
            idDuCadre.value = idCadre;
            raffraich.value = raffraichissement;
            ordreDePri.value = ordreDePriorite;
            dureeAffichageDoc.value = dureeAffichage
            dateDebutDeValiditeDoc.value = dateDebut
            dateDeFinValiditeDoc.value = dateFin
        }
        //Fonction qui attacher le document sur un cadre selectionner qui n'a pas encore des document
    const AttacheDocumentation = async()=>{
        try{
            // dateHeureDebutDeValiditeDoc = dateDebutDeValiditeDoc.value+' '+HeureDebutDeValiditeDoc.value;
            // dateHeureDeFinValiditeDoc = dateDeFinValiditeDoc.value+' '+heureDeFinValiditeDoc.value;
            dateHeureDebutDeValiditeDoc = dateDebutDeValiditeDoc.value
            dateHeureDeFinValiditeDoc = dateDeFinValiditeDoc.value 
            const url = './../controllers/IdcadreEtDocument/attacherDocumentCadreCtrl.php';
            const formData = new FormData()
            formData.append('idCadre', idDuCadre.value)
            // console.log(idDuCadre.value);
            formData.append('idDocument', addIdDocCheck.value)
            formData.append("dureeAffichage",dureeAffichageDoc.value)
            formData.append('raffraichissement', raffraich.value)
            // console.log(raffraich.value);
            formData.append('ordreDePriorite', ordreDePri.value)
            console.log(dureeAffichageDoc.value);
            formData.append("dateDebutDeValidite",dateHeureDebutDeValiditeDoc)
            console.log(dateHeureDebutDeValiditeDoc);
            formData.append("dateDeFinValidite",dateHeureDeFinValiditeDoc)
            console.log(dateHeureDeFinValiditeDoc);
            // console.log(addIdDocCheck.value);
            // console.log(ordreDePri.value);
            const axiosConfig = {
                method: 'post',
                url: url,
                data: formData,
                headers: { "Content-Type": "multipart/form-data" }
            }
            const res =  await axios(axiosConfig)
            console.log(res.data);
        }catch(error){
                console.error(error.message);
        } 
    }
         //La fonction qui appelle les deux fonction qui fait l'insertion de l'attachement des documents sur un cadre
        const insertDocSurCadre = (id, idCadre,raffraichissement,ordreDePriorite,dureeAffichage,dateDebut,dateFin) =>{
            prendreITemraffraichOdrePri(id,idCadre,raffraichissement,ordreDePriorite,dureeAffichage,dateDebut,dateFin),
            AttacheDocumentation(),
            cadre()
        }
// detacher les doc du cadre de travail au ckeck dans bdd(tableau cadre)
        const checkDisaffectDocs= async (id,idCadreSelected)=>{ 
            fonctIdMocle(id,idCadreSelected)
            disaffectDocs() 
    }
    const disaffectDocs = async () => {
    const url = './../controllers/IdcadreEtDocument/disaffectDocsCtrl.php'
    const formData = new FormData()
    formData.append('idDocument',idMocle.value)
    formData.append('idCadre',cadreSelected.value)
    console.log(idMocle.value,cadreSelected.value);
    const axiosConfig = {
        method: 'post',
        url: url,
        data: formData,
        headers: { "Content-Type": "multipart/form-data" }
    }
    const res = await axios(axiosConfig)
    const index = listeDocumentCadreAttach.value.findIndex(listeDocumentAttach=> id == listeDocumentAttach.id)
    listeDocumentCadreAttach.value.splice(index,1); 
}
                /******************** */
                const currentIcone=ref(null)
                const checkIconCadre = (id, idCadre) =>{
                    idIconeChange.value = id;
                    currentIcone.value =idCadre;
                }
                const checkIcon = (id) =>{
                    idIconeChange.value = id
                }
         // fonction pour mettre les deux @clik dans un
         const displayReattachIcone = (id) => {
            checkIcon(id),
            reattachIcone()              
    }
    const reattachIcone = async () => {
        try{
            const url = './../controllers/cadre-de-travail/reattachIcone.php'
            const formData = new FormData()
            formData.append('idIcone',idIconeChange.value)
            // console.log(idIconeChange.value)
            const axiosConfig = {
                method: 'post',
                url: url,
                data: formData,
                headers: { "Content-Type": "multipart/form-data" }
            }
            const res =  await axios(axiosConfig)
            // console.log(res.data);
        }catch(error){
            console.error(error.message);
        }               
    }    

/** */
    const insernomCadre = async () => {
        try{
            console.log(nouveauNom.value);
            const url = './../controllers/cadre-de-travail/insererNomCadreCtrl.php'
            const formData = new FormData()
            formData.append('nom', nouveauNom.value)  
            const axiosConfig = {
                method: 'post',
                url: url,
                data: formData,
                headers: { "Content-Type": "multipart/form-data" }
            }
            const res =  await axios(axiosConfig)
            // console.log(res.data);
        }catch(error){
            console.error(error.message);
        }       
    }
    // dinamisation
    const  insernomCadreandRefraish  = async () => {
        // await location.reload()
        await insernomCadre()
        await cadre()
        // await refraich()
      }
    const inserDescCadre = async () => {
        try{
            const url = './../controllers/cadre-de-travail/insererDescCadreCtrl.php'
            const formData = new FormData()
            formData.append('description',description.value)    
            const axiosConfig = {
                method: 'post',
                url: url,
                data: formData,
                headers: { "Content-Type": "multipart/form-data" }
            }
            const res =  await axios(axiosConfig)
            // console.log(res.data);
        }catch(error){
            console.error(error.message);
        }       
    }
    // insertion dynamique description
    const  inserdescCadreandRefraish  = async () => {
        await inserDescCadre()
        await cadre()
      }
    const insertDiapo = async () => {
        try{
            const url = './../controllers/cadre-de-travail/insererDiapoCadreCtrl.php'
            const formData = new FormData()
            formData.append('diaporama',diaporama.value)  
            const axiosConfig = {
                method: 'post',
                url: url,
                data: formData,
                headers: { "Content-Type": "multipart/form-data" }
            }
            const res =  await axios(axiosConfig)
            // console.log(res.data);
        }catch(error){
            console.error(error.message);
        }       
    }
    // fonction pour inserer et mettre a jour
    const  inserdiapoCadreandRefraish  = async () => {
        await insertDiapo()
        await cadre()
      }

    const idMocle = ref(null)
    const cadreSelected = ref(null)
    const fonctIdMocle = (id, idCadreSelected) => {
        idMocle.value = id
        cadreSelected.value = idCadreSelected
        console.log(cadreSelected.value);
    }
    const insertMotcle = async () => {
        try{
            const url = './../controllers/IdCadreEtMotcle/insertIdCtrl.php'
            const formData = new FormData()
            formData.append('idmotcle',idMocle.value)
            formData.append('idmotCadre',cadreSelected.value)
            
            // console.log(idMocle.value); 
            const axiosConfig = {
                method: 'post',
                url: url,
                data: formData,
                headers: { "Content-Type": "multipart/form-data" }
            }
            const res =  await axios(axiosConfig)
            // console.log(res.data);
        }catch(error){
            console.error(error.message);
        }       
    }
/** */
    const cadresTravailOptions = computed(() => {
    //   return cadreDeTravail.value.map(cadre => cadre.nom)
        return cadreDeTravail.value.map(cadre => {
            return {
                label : cadre.nom,
                value : cadre 
            }
        })  
    })
    const cadre = async () => {
            // au démarrage de la page
        try {
            const url = './../controllers/cadre-de-travail/cadreDeTravailTraitement.php'
            const res = await axios.get(url)
            cadreDeTravail.value = res.data
            // console.log( res.data)
        } catch (error) {
            console.log("On est dans l'erreur")
            console.error(error.message)
        }
    }
    const initCadre = async () => {
        await cadre()
    }
    onMounted(initCadre)
      /*************miseajourDescription***************/

      const miseAjourDesDonneesDesc = async (id="") => {
        try {
            const url =`./../controllers/cadre-de-travail/miseAjourDescription.php?=${id}`
            const formData = new FormData()
            formData.append('id', cadreselect.value.value.id)
            formData.append('descri', cadreselect.value.value.description)
            const axiosConfig = {
                method: 'post',
                url: url,
                data: formData,
                headers: { "Content-Type": "multipart/form-data" }
            }  
            const res =  await axios(axiosConfig)
            console.log(res.data)
        }catch(error){
            console.error(error.message)
        }
    }
    const  miseAjourDesDonneesDescAndFresh = async () => {
        await  miseAjourDesDonneesDesc()
        await cadre()  
    }
    
        /*************miseajourDiaporama***************/

    const miseAjourDesDonneesDiapo = async (id="") => {
        try {
            const url =`./../controllers/cadre-de-travail/miseAjourDiaporama.php?=${id}`
            const formData = new FormData()
            formData.append('id', cadreselect.value.value.id)
            formData.append('diaporama', cadreselect.value.value.diaporama)
            const axiosConfig = {
                method: 'post',
                url: url,
                data: formData,
                headers: { "Content-Type": "multipart/form-data" }
            }  
            const res =  await axios(axiosConfig)
            console.log(res.data)
        }catch(error){
            console.error(error.message)
        }
    }
    // fonction mise a jour et refraiche
    const  miseAjourDiapoAndFresh = async (id) => {
        await  miseAjourDesDonneesDiapo()
        await cadre()  
    }
       // fonction qui regroupe  miseAjourIcones et checkIcon pour pouvoir modifier l'iconne attacher
    //    detectIcone est utiliser pour la suppression de l'icone
   
    // const detectIcone=ref(null)
    const currentCadreId = ref(null)
    const changeIconAttacher = (id, idCadreDeTravail) =>{
        checkIconCadre(id, idCadreDeTravail),
        miseAjourIcones()
            
            // currentCadreId.value = idCadreDeTravail
            // console.log(idCadreDeTravail);
    }

    // fonction qui permet d'ajouter une icone sans  rafraichir
    const createIconAndFresh = async () => {
        await createIcon()
         await listIcone()  
    }
    const miseAjourIcones = async () => {
        try {
            const url ='./../controllers/cadre-de-travail/miseAjourDesIconeCadre.php'
            const formData = new FormData()
            formData.append('id', idIconeChange.value)
            // console.log(idIconeChange.value)
            formData.append('idIcone',  currentIcone.value) 
            // console.log(currentIcone.value)
            const axiosConfig = {
                method: 'post',
                url: url,
                data: formData,
                headers: { "Content-Type": "multipart/form-data" }
            }  
            const res =  await axios(axiosConfig)
            console.log(res.data)
        }catch(error){
            console.error(error.message)
        }
    }
    // fonction qui met ajour le cadre de travail apres suppression de l'icone
     const miseAjourCadrePourIcones = async (id="") => {
        try {
             const url =`./../controllers/cadre-de-travail/miseAjourCadrePourIcon.php?${id}`
             const formData = new FormData()
             console.log(cadreselect.value.value.id)
             formData.append('idIcone', cadreselect.value.value.id)
             const axiosConfig = {
                 method: 'post',
                 url: url,
                 data: formData,
                 headers: { "Content-Type": "multipart/form-data" }
             }  
             const res = await axios(axiosConfig)
            console.log(res.data)
        }catch(error){
             console.error(error.message)
        }
 
     }
 
     const iconeDeleted = async(id) =>{
        const url = './../controllers/iconeCadre/removeIcone.php'
        console.log(url);
        const formData = new FormData()
        formData.append('id', idIconeChange.value)
            console.log(idIconeChange.value )
            const axiosConfig = {
                method: 'post',
                url: url,
                data: formData,
                headers: { "Content-Type": "multipart/form-data" }
            }
        const res = await axios(axiosConfig)
        index = listeIconeCadre.value.findIndex(iconeTodelete =>id == iconeTodelete.id)
        listeIconeCadre.value.splice(index, 1); 
        }

    // fonction de rassemblement pour la suppression de l'icone.
        const selectDelete = async () => {
            await miseAjourCadrePourIcones()
            await iconeDeleted()
         }
         const deleteRefraich = async () => {
            await selectDelete()
            await listIcone()
         }
         
/****** TABLEAU MOT CLE ********/
    //page Ajoutmodif.php tableau MotCle
    const listeMotCle = ref(null)
    const MotCleLearn = ref("")
    const displayResultDoc = ref("")
    const  displayResultModal=ref('')
    // console.log(displayResult);
    const test = ref(null)
    const columnsAffected = ref([
        { 
             name: 'nom', 
             label: 'Nom', 
             field: 'nom', 
             sortable: true 
         },
         { 
             name: 'desaffected', 
             label: 'desaffecter', 
             field: 'desaffected', 
             sortable: false 
         },
    ])
     const columns = ref([
         { 
              name: 'nom', 
              label: 'Nom', 
              field: 'nom', 
              sortable: true 
          },
          { 
              name: 'affected', 
              label: 'Affecté', 
              field: 'affected', 
              sortable: false 
          },
          { 
            
             name: 'supprimer',
             label:'Supprimer',
          
         },
    ])
    const keyWords = ref([])
        const listeDeMotCle= async () => {
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
    // au démarrage de la page on appelle la fonction
    onMounted(initPage)

    //inserer les donées dans tab mot clé
    const getKeyWord = async () => {
    // au démarrage de la page
        try {
            const url = './../controllers/motCleCadre/listeMotCleCtrl.php'
            //console.log(url)
            const res = await axios.get(url)
            // console.log(res.data);
            res.data.forEach(keyWord => {
                keyWord.affected=false
            //console.log(keyWord.affected);
            });
            keyWords.value = res.data
            //console.log( keyWords.value)
        } catch (error) {
            console.log("On est dans l'erreur")
            console.error(error.message)
        }
    }
    const loadDataOptions = computed(() => {
        return keyWords.value.map(test => test.nom)
    })
    const init = async () => {
        await getKeyWord()  
    }
     onMounted(init)

 //ajouter motCle dans bdd
     const createMotcle = async () => {
        const url = './../controllers/motCleCadre/insertMotCleCtrl.php'
        const formData = new FormData()
        formData.append('nomMotCle', MotCleLearn.value)
        const axiosConfig = {
            method: 'post',
            url: url,
            data: formData,
            headers: { "Content-Type": "multipart/form-data" }
        }
            const res = await axios(axiosConfig)
    }
    const ajouterAfficherMotCle = async () =>{
        await createMotcle(),
        await getKeyWord()
    }
    //delete column du tab Mot cle
    const deleteKeyWordId = async (id) => {
        const url = './../controllers/motCleCadre/removeMotCleCtrl.php'
        const formData = new FormData()
        formData.append('id',id)   
        const axiosConfig = {
            method: 'post',
            url: url,
            data: formData,
            headers: { "Content-Type": "multipart/form-data" }
        }
        const res = await axios(axiosConfig)
        const index = keyWords.value.findIndex(keyword =>id == keyword.id)
        keyWords.value.splice(index,1); 
    }
    //supprimer les motscles de la Bdd et de l affichage
    const keyWordDeleted = async (id) => {
        const url = './../controllers/motCleCadre/deleteMotCleCtrl.php'
        const formData = new FormData()
        formData.append('id', keyWordTodelete.value)
        const axiosConfig = {
            method: 'post',
            url: url,
            data: formData,
            headers: { "Content-Type": "multipart/form-data" }
        }
        const res = await axios(axiosConfig)
        const index = keyWords.value.findIndex(Todelete =>id ==Todelete.id)
        keyWords.value.splice(index,1); 
    }
// const recoverName = ref(null)
    const dialog = ref(false)
    const keyWordTodelete= ref(null)
    const displayTrashDialog =(id)=>{
        dialog.value = true
        keyWordTodelete.value = id
        recoverNameCadreAndKeyWordIdI()
        // recoverName.value = id
        console.log(keyWordTodelete.value);
    }
    const displayResultName = ref('') 
//afficher le nom du cadre attacher au motcle  
    const recoverNameCadreAndKeyWordIdI = async () => {
        const url = './../controllers/IdCadreEtMotcle/recoverNameCadreCtrl.php'
        const formData = new FormData()
        formData.append('id',keyWordTodelete.value)
        const axiosConfig = {
            method: 'post',
            url: url,
            data: formData,
            headers: { "Content-Type": "multipart/form-data" }
        }
        const res = await axios(axiosConfig)
        displayResultName.value = res.data
        console.log(res.data);
    }
    const docNameIdMotCle = ref([])
    const listeMotcleCadreAttach = ref([])
    const listeNameIdMotCles = async (id = "") =>{
            try{
                const url = `./../controllers/cadre-de-travail/attachNameIdMotCle.php?id=${id}`
                const res = await axios.get(url)
                docNameIdMotCle.value = res.data
                if(docNameIdMotCle.value.length>0){
                    const long = docNameIdMotCle.value.length;
                    for(i= 0; i < long; i++ ){
                        listeMotcleCadreAttach.value.push(docNameIdMotCle.value[i].id)
                    }
                    console.log(listeMotcleCadreAttach.value);
                }
            }catch(error){
                console.log("On est dans l'erreur")
                console.error(error.message)
            }
    }
    const NameIdMotCle= ref(null)
    const docNameIdMotCless = computed(() => {
        return  docNameIdMotCle.value.map(NameIdMotCle => NameIdMotCle.nom)
    })
        
    const checkIndeleted= async (id,idCadreSelected)=>{
        fonctIdMocle(id,idCadreSelected),
        keyWordDeletedCheckIn()
     
  }
// detacher les mots clés du cadre de travail au ckeck dans bdd
  const keyWordDeletedCheckIn = async (id) => {
          const url = './../controllers/motCleCadre/checkInkeyWordCtrl.php'
          const formData = new FormData()
          formData.append('id',idMocle.value)
          formData.append('idmotCadre',cadreSelected.value)
          console.log(idMocle.value,cadreSelected.value);
          const axiosConfig = {
              method: 'post',
              url: url,
              data: formData,
              headers: { "Content-Type": "multipart/form-data" }
          }
          const res = await axios(axiosConfig)
          const index=docNameIdMotCle.value.findIndex(docNameIdMotCle=> id == docNameIdMotCle.id)
          docNameIdMotCle.value.splice(index,1); 
      }
    //Quand affecte un mot clé sur un cadre de travail existant mais sans mot clé 
    const affecterMotCle = async () => {
            try{
                const url = './../controllers/IdCadreEtMotcle/insertIdCtrl.php'
                const formData = new FormData()
                formData.append('idmotcle',idMocle.value)
                const axiosConfig = {
                    method: 'post',
                    url: url,
                    data: formData,
                    headers: { "Content-Type": "multipart/form-data" }
                }
                const res =  await axios(axiosConfig)
                    // console.log(res.data);
                }catch(error){
                    console.error(error.message);
            }       
    }
/****** TABLEAU ICONE ********/
        //Page AjoutModif.php les constantes icones
    const cadreIcones = ref(null)
    const nouvNom = ref(null)
    const listeIconeCadre = ref([])
    const messages = ref("")
    const urlImgIcone = "../controllers/iconeCadre/tmp/";
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
// pagination des icones
    const currentMax = ref(1)
    const currentMaxIcones = computed(()=>{
        let IconesMax=([])
        if(listeIconeCadre.value.length>0){
           const startIndex = iconesByPage.value * (currentMax.value -1)
           let maxIndex = startIndex + iconesByPage.value
        if(maxIndex> listeIconeCadre.value.length){
              maxIndex= listeIconeCadre.value.length
        }
        for(let i = startIndex ; i < maxIndex  ; i++){
            IconesMax.push( listeIconeCadre.value[i])
            // console.log(listeIconeCadre.value);  
           }   
       }
       return IconesMax 
    })
    const iconesByPage = ref(6)
    const pageMax = computed(() => {
        return Math.ceil(listeIconeCadre.value.length/iconesByPage.value) 
    
    })
//Au chargement de la page j'appelle la fonction
    onMounted(icone)
//la recuperation de données du modal icone
    const createIcon = async () => {
        try {
            const url = './../controllers/iconeCadre/insererIconeCtrl.php'
            const formData = new FormData();
            const imagefile = document.querySelector('#file');
            // console.log(imagefile.files[0]);
            // const items = [].slice.call(imagefile.children)
            formData.append("nom", nouvNom.value);           
            formData.append("image", imagefile.files[0]);
            const axiosConfig = {
                method: 'post',
                url: url,
                data: formData,
                headers: { "Content-Type": "multipart/form-data" }
            }
            const res =  await axios(axiosConfig)
                console.log(res.data);
        } catch (error) {
            console.error(error.message);
        }
    }
    //Pour le icone attacher au cadre de travail selectionner
    const iconeCadreAttach = ref(null)
    //Icone attacher à un cadre de travail
    const iconeAttacherauCadre = async (id = "") =>{
        try{
            const url = `./../controllers/cadre-de-travail/iconeAttacheCtrl.php?id=${id}`
            // console.log(url);
            const res = await axios.get(url)
            iconeCadreAttach.value = res.data
            console.log(res.data);
            if(iconeCadreAttach.value.length>0){
                checkIcon(iconeCadreAttach.value[0].id)
            }
        }catch(error){
            console.log("On est dans l'erreur")
            console.error(error.message)
        }
    }
/*****constante page d'accueil admin Dans la page AccAdmin.php */
    const takeCadresIcones = ref([])
 /*****Fonction Print**** */
    const QrCodePrint=()=>{
        print = this.$htmlToPaper('printMe')
    }
    /********Pagination accAdmin*********/
        // const cadres = ref([]) 
    const current = ref(1)
    const currentIcones = computed(()=>{
        let IconesMax=([])
        if( takeCadresIcones.value.length>0){
            const startIndex = cadreByPage.value * (current.value -1)
            let maxIndex = startIndex + cadreByPage.value
            if(maxIndex>takeCadresIcones.value.length){
                maxIndex=takeCadresIcones.value.length
            }
            for(let i = startIndex ; i < maxIndex  ; i++){
                IconesMax.push(takeCadresIcones.value[i])
            }
        }
        return IconesMax   
    })

    //fonction pour faire  la recherche de nom de cadres
    const searchCadre= ref('')
    const filteredCadres = computed(() => { 
        const filteredCadreTravail =  currentIcones.value.filter((fcadre) => {
            console.log(fcadre);
            return fcadre.nom.toLowerCase().includes(searchCadre.value.toLowerCase());
        })
        console.log(filteredCadreTravail);
        return filteredCadreTravail ;
    })
    const cadreByPage = ref(12)
    const paginationMax = computed(() => {
        return Math.ceil(takeCadresIcones.value.length/cadreByPage.value)     
    }) 
    // afficher les icones reliés au cadre de travail
    const listeCadresIcones = async () => {
        // au démarrage de la page
        try {
            const url = './../controllers/cadre-de-travail/listeCadreIconeCtrl.php'
            const res = await axios.get(url)
            takeCadresIcones.value = res.data
        }catch(error) {
            console.log("On est dans l'erreur")
             console.error(error.message)
        }
    }
    const initListeCadresIcones = async () => {
        await listeCadresIcones()
    }
    onMounted(initListeCadresIcones) 
/* DOCUMENT *******/            
            const nomNouveauDoc = ref('')
            const cheminDoc = ref('')
            const dureeAffichageDoc = ref(null)
            const dateDeFinValiditeDoc = ref(null)
            const dateDebutDeValiditeDoc = ref(null)
            const HeureDebutDeValiditeDoc = ref(null)
            const heureDeFinValiditeDoc = ref(null)
            var dateHeureDebutDeValiditeDoc = ref(null)
            var dateHeureDeFinValiditeDoc = ref(null)
            const insertDocument = async () => {
                // dateHeureDebutDeValiditeDoc = dateDebutDeValiditeDoc.value+' '+HeureDebutDeValiditeDoc.value;
                // dateHeureDeFinValiditeDoc = dateDeFinValiditeDoc.value+' '+heureDeFinValiditeDoc.value;
                try{
                    const url = './../controllers/documents/insertDocumentCtrl.php'
                    const formData = new FormData()
                    const imagefile = document.querySelector('#UnDocument');
                    formData.append("nom",nomNouveauDoc.value)
                    formData.append("chemin", imagefile.files[0])
                    // formData.append("dureeAffichage",dureeAffichageDoc.value)
                    // formData.append("dateDebutDeValidite",dateHeureDebutDeValiditeDoc)
                    // formData.append("dateDeFinValidite",dateHeureDeFinValiditeDoc)
                    // console.log(dateHeureDeFinValiditeDoc);
                   
                 const axiosConfig = {
                        method: 'post',
                        url: url,
                        data: formData,
                        headers: { "Content-Type": "multipart/form-data",
                                   "Content-Type": "application/force-download" 
                                 }
                    }
                    const res =  await axios(axiosConfig)
                    // console.log(res.data);
                }catch(error){
                    console.error(error.message);
                }  
            } 
            //Pour inserer les documents et les afficher après
            const insertEtAfficher = async () => {
                await insertDocument(),
                await getKeyDocs()
            }
 //Liste des document attacher à un cadre de travail
            const listeDocumentCadreAttach = ref([])
            const lesIdCadresAttacher = ref([])
            const listDocumentAttacherauCadre = async (id) =>{
                try{
                    const url = `./../controllers/cadre-de-travail/listeDocumentAttacherCtrl.php?id=${id}`
                    const res = await axios.get(url)
                    listeDocumentCadreAttach.value = res.data
                    if(listeDocumentCadreAttach.value.length>0){
                        const long = listeDocumentCadreAttach.value.length;
                        for(i= 0; i < long; i++ ){
                            lesIdCadresAttacher.value.push(listeDocumentCadreAttach.value[i].id)
                        }
                        // console.log(lesIdCadresAttacher.value);
                    }
                }catch(error){
                    console.log("On est dans l'erreur")
                    console.error(error.message)
                }
            }
            const testes = ref(null)
            const doc = computed(() => {
                return  listeDocumentCadreAttach.value.map(testes => testes.nom )
            })
            //Fonction qui fait appel aux plusieurs fonctions pour l'affichage de la modification
            const relieur = async (id) =>{
                listDocumentAttacherauCadre(id);
                listeNameIdMotCles(id);
                iconeAttacherauCadre(id)
            }
            const refraich = async () =>{
               await location.reload();
            }
        //supprimer les documents de la Bdd et de l affichage
        const Iconedialog=ref(false) 

        const DeletedDocs = async () => {
            const url = './../controllers/documents/deleteDocsCtrl.php'
            const formData = new FormData()
            formData.append('id',deletedTodoc.value)
            console.log(id);
            const axiosConfig = {
                method: 'post',
                url: url,
                data: formData,
                headers: { "Content-Type": "multipart/form-data" }
            }
            const res = await axios(axiosConfig)
            const index = keyWordDocs.value.findIndex(TodeleteDocs =>id ==TodeleteDocs.id)
            keyWordDocs.value.splice(index,1); 
        }
            //ouvre la boite de dialogue confirmation sup du doc dans le modal
            const validateDialog = ref(false)
            const deletedTodoc = ref(null)
            const displayDocTrashDialog =(id)=>{
            validateDialog.value = true
            deletedTodoc.value = id 
            }
        //Affichage des documents attacher au cadre de travail avec la visionneuse
        const docVisionner = ref([])
        
        const afficherDocuments = async () => { 
                try {
                    console.log();
                    const url = './../controllers/cadre-de-travail/afficherDocumentAttacherCadreCtrl.php'
                    const formData = new FormData()
                    formData.append('id', PHP_ID)
                    const axiosConfig = {
                        method: 'post',
                        url: url,
                        data: formData,
                        headers: { "Content-Type": "multipart/form-data" }
                    }  
                    const res =  await axios(axiosConfig)
                    docVisionner.value = res.data
                }catch(error){
                    console.error(error.message)
                }
        }
        const affichageDocs = async () => {
            await afficherDocuments()
        }
        onMounted(affichageDocs)
const url=ref(true)
        const telechargerUrl = async () =>{
            url=true;

        }
    
        //C'est l'options d'un bouton pour afficher les documents un par un
        // const slideOptions = computed(() => {
        //     return  docVisionner.value.map(doc => {
        //         return {
        //         label : doc,
        //         value : doc 
        //         }
        //     })
        // })
        /*** Les fonctions pour la modification nom de document *****/
        const changeNameDoc = async (iddoc, namedoc) =>{
            try {
                const url = './../controllers/documents/updateNameDocCtrl.php'
                const formData = new FormData()
                formData.append('id', iddoc)
                formData.append('nomDoc', namedoc)
                const axiosConfig = {
                    method: 'post',
                    url: url,
                    data: formData,
                    headers: { "Content-Type": "multipart/form-data" }
                }  
                const res =  await axios(axiosConfig)
                console.log(res.data) 
            }catch(error){
                console.error(error.message)
            }
        }
        const updateNameDoc = async (id, bbb) =>{
            await changeNameDoc(id, bbb),
            await getKeyDocs()
        }
        /*** Les fonctions pour la modification durée d'affichage de document *****/
        const changeDureeAffichDoc = async (iddoc, newDuree, idCadre) =>{
            try {
                const url = './../controllers/documents/updateDureeAffichDocCtrl.php'
                const formData = new FormData()
                formData.append('id', iddoc)
                formData.append('DureeDoc', newDuree)
                formData.append('idCadre', idCadre)
                console.log(newDuree);
                const axiosConfig = {
                    method: 'post',
                    url: url,
                    data: formData,
                    headers: { "Content-Type": "multipart/form-data" }
                }  
                const res =  await axios(axiosConfig)
                console.log(res.data) 
            }catch(error){
                console.error(error.message)
            }
        }
        const updateDureeAffichDoc = async (id, nomdoc, idCadre) =>{
            await changeDureeAffichDoc(id, nomdoc, idCadre),
            await getKeyDocs()
        }
        /*** Les fonctions pour la modification de date de début de validité de document *****/ 
        const changeDateDebutDoc = async (iddoc, newDateDV, idCadre) =>{
            try {
                const url = './../controllers/documents/updateDateDVDocCtrl.php'
                const formData = new FormData()
                formData.append('id', iddoc)
                formData.append('DateDVDoc', newDateDV)
                formData.append('idCadre', idCadre)
                console.log(newDateDV);
                const axiosConfig = {
                    method: 'post',
                    url: url,
                    data: formData,
                    headers: { "Content-Type": "multipart/form-data" }
                }  
                const res =  await axios(axiosConfig)
                console.log(res.data) 
            }catch(error){
                console.error(error.message)
            }
        }
        const updateDateDvDoc = async (id, nomdoc, idCadre) =>{
            changeDateDebutDoc(id, nomdoc, idCadre),
            await getKeyDocs()
        }
        //Fonction qui change la date de fin d'un document
        const changeDateFinDoc = async (iddoc, newDateDF, idCadre) =>{
            try {
                const url = './../controllers/documents/updateDateFVDocCtrl.php'
                const formData = new FormData()
                formData.append('id', iddoc)
                formData.append('DateDFDoc', newDateDF)
                formData.append('idCadre', idCadre)
                const axiosConfig = {
                    method: 'post',
                    url: url,
                    data: formData,
                    headers: { "Content-Type": "multipart/form-data" }
                }  
                const res =  await axios(axiosConfig)
                console.log(res.data) 
            }catch(error){
                console.error(error.message)
            }
        }
        const updateDateFVDoc = async (id, nomdoc, idCadre) =>{
            await changeDateFinDoc(id, nomdoc, idCadre),
            await getKeyDocs()
        }
        //Fonction qui change le raffraichissement d'un document
        const changeRafraichirDoc = async (iddoc, newRaffr, idCadre) =>{
            try {
                const url = './../controllers/IdCadreEtMotcle/updateReffreshDocCtrl.php'
                const formData = new FormData()
                formData.append('id', iddoc)
                formData.append('raffraichDoc', newRaffr)
                formData.append('idCadre', idCadre)
                const axiosConfig = {
                    method: 'post',
                    url: url,
                    data: formData,
                    headers: { "Content-Type": "multipart/form-data" }
                }  
                const res =  await axios(axiosConfig)
                console.log(res.data) 
            }catch(error){
                console.error(error.message)
            }
        }
        const updateRaffraichDoc = async (id, newRaffr, idCadre) =>{
            await changeRafraichirDoc(id, newRaffr, idCadre),
            await getKeyDocs()
        }
        
        //Fonction qui change la date de fin d'un document
        const changeOrderePrioriteDoc = async (iddoc, newOrder, idCadre) =>{
            try {
                const url = './../controllers/IdCadreEtMotcle/updateOrderDocCtrl.php'
                const formData = new FormData()
                formData.append('id', iddoc)
                formData.append('ordrePriDoc', newOrder)
                formData.append('idCadre', idCadre)
                const axiosConfig = {
                    method: 'post',
                    url: url,
                    data: formData,
                    headers: { "Content-Type": "multipart/form-data" }
                }  
                const res =  await axios(axiosConfig)
                console.log(res.data) 
            }catch(error){
                console.error(error.message)
            }
        }
        const updateOrdrePrioriteDoc = async (id, newOrder, idCadre) =>{
            await changeOrderePrioriteDoc(id, newOrder, idCadre),
            await getKeyDocs()
        }
      //delete tout les documents  sur la corbeille global
      const getCadreSelected = ref(null)
      const getCadre = (idcadre)=>{
          getCadreSelected.value = idcadre;
      }
      const deletedAllDocs = async () => {
      const url = './../controllers/IdcadreEtDocument/deletedDocAllCtrl.php'
      const formData = new FormData()
      formData.append('idCadre',getCadreSelected.value)
      formData.append('idDocument',lesIdCadresAttacher.value)
      // console.log(getCadreSelected.value);
      // console.log(lesIdCadresAttacher.value);
      const axiosConfig = {
          method: 'post',
          url: url,
          data: formData,
          headers: { "Content-Type": "multipart/form-data" }
      }
      const res = await axios(axiosConfig)
      console.log(res.data);
      // const index = listeDocumentCadreAttach.value.findIndex(TodeleteDocs =>id ==TodeleteDocs.id)
      // listeDocumentCadreAttach.value.splice(index,1); 
      const index = listeDocumentCadreAttach.value.findIndex(TodeleteDocs =>id ==TodeleteDocs.id)
      listeDocumentCadreAttach.value.splice(this.listeDocumentCadreAttach ); 
      
  }
      const deletedAllKeyWord = async () => {
      const url = './../controllers/IdCadreEtMotcle/deletedAllKeyWordCtrl.php'
      const formData = new FormData()
      formData.append('idMotCle',listeMotcleCadreAttach.value)
      formData.append('idCadre', getCadreSelected.value)
      console.log(docNameIdMotCle.value);
      console.log(getCadreSelected.value);
      const axiosConfig = {
          method: 'post',
          url: url,
          data: formData,
          headers: { "Content-Type": "multipart/form-data" }
      }
      const res = await axios(axiosConfig)
      console.log(res.data);
      const index=docNameIdMotCle.value.findIndex(docNameIdMotCle=> id == docNameIdMotCle.id)
      docNameIdMotCle.value.splice(this.docNameIdMotCle); 
  }
// fonction pour desaffecter une icone du cadre de travail
const disaffectIcone = async () => {
    const url = './../controllers/iconeCadre/dettacherIcone.php'
    const formData = new FormData()
    formData.append('id', cadreselect.value.value.id)
    console.log(cadreselect.value.value.id);
    listIcone(cadreselect.value.value.id) 

    const axiosConfig = {
        method: 'post',
        url: url,
        data: formData,
        headers: { "Content-Type": "multipart/form-data" }
    }
    const res = await axios(axiosConfig)
}  
const disafrefraich = async () => {
    await disaffectIcone(),
    await listIcone() 
   
}
// suppression du cadre de travail
const supprimerDesDonneesCadre = async(id) =>{
    const url = `./../controllers/cadre-de-travail/removeCadreDeTravail.php`
    console.log(url);
    const formData = new FormData()
    console.log(cadreselect.value);
    formData.append('id',id);
    // console.log(cadreselect.value.value.description);  
        const axiosConfig = {
            method: 'post',
            url: url,
            data: formData,
            headers: { "Content-Type": "multipart/form-data" }
        }
    const res = await axios(axiosConfig)
    }
     
    const deletedAll= async (idcadre)=>{
         getCadre(idcadre)
         await disaffectIcone()
         await deletedAllDocs()
         await deletedAllKeyWord(idcadre)
         await supprimerDesDonneesCadre(idcadre) 
         
    } 
    const deleteDataAll = async(idcadre)=>{
        await deletedAll(idcadre)
        await initCadre()
        await refraich()
    }
     // fonction searchInput
     const  searchkey=ref("")
     const inputType = ref()
     const searchInput = async(param) => {
         inputType.value = param;
     }
 // fonctionfichier text
 const  searchtextkey=ref("")
 const text = ref()
 const searchTextInput = async(param) => {
     inputType.value = param;
 }

    //  fonction video
    const  searchVideokey=ref("")
    const video=ref("")
    const searchVideoInput = async(param) => {
        inputType.value = param;
    }
     //  fonction image
     const  searchImagekey=ref("")
     const image=ref("")
     const searchImageInput = async(param) => {
         inputType.value = param;
     }
   
//      const name = ref('')
//     const search= async() =>{
//          //recherche par nom
//          name.toLowerCase().includes(searchkey.toLowerCase())
 
// }

 
        return {
            searchInput,
            inputType,
            searchkey,
            searchtextkey,
            searchTextInput,
            text,
            searchVideokey,
            searchVideoInput,
            video,
            searchImagekey,
            image,
            searchImageInput,
            deleteDataAll,
            deleteRefraich,
            afficherDocuments,
            docVisionner,
            refraich,
            checkDoc,
            attacherDocAvecRaffraich,
            insertDocumentation,
            // miseajour
            miseAjourDesDonneesDesc,
            miseAjourDesDonneesDiapo,
            miseAjourIcones,
            currentIcone,
            currentCadreId,
            // currentIcone,
            createIconAndFresh,
            changeIconAttacher,
            // suppression
             iconeDeleted,
             selectDelete,
            // mise ajour refraiche
            // deleteRefraich,
            miseAjourCadrePourIcones ,
            miseAjourDiapoAndFresh ,
            miseAjourDesDonneesDescAndFresh,
           
            // insertion dinamique
            insernomCadreandRefraish,
            inserdescCadreandRefraish,
            inserdiapoCadreandRefraish,
             /**recherche doc */
            searchTerm,
            filteredDocs ,
             /**filtrecadre */
            searchCadre,
            filteredCadres ,
            //document page ajouModif
            valCheck,
            loadDataOptionsDoc,
            displayResultDoc,
            displayResultModal,
            keysDocsSelect,
            columnsDoc,
            columnsDocDesaffecter,
            saveDoc,
            addIdDoc,
            docSelect,
            insertDocument,
            listeDocumentCadreAttach,
            listDocumentAttacherauCadre,
            keysDocsSelectCadre,
            doc,
            testes,
            insertEtAfficher,
            //Mis à jour document
            changeNameDoc,
            updateNameDoc,
            updateDureeAffichDoc,
            changeDureeAffichDoc,
            updateDateDvDoc,
            changeDateDebutDoc,
            updateDateFVDoc,
            changeDateFinDoc,
            updateRaffraichDoc,
            updateOrdrePrioriteDoc,
            //modal btn addDoc document
            addDoc: ref(false),
            file: ref(null),
            nomNouveauDoc,
            cheminDoc,
            dureeAffichageDoc,
            dateDeFinValiditeDoc,
            dateDebutDeValiditeDoc,
            insertDocSurCadre,
            prendreITemraffraichOdrePri,
            AttacheDocumentation,
            HeureDebutDeValiditeDoc,
            heureDeFinValiditeDoc,
            dateHeureDebutDeValiditeDoc,
            dateHeureDeFinValiditeDoc,
            //delete doc dans modal document
            DeletedDocs,
            displayDocTrashDialog,
            deletedTodoc,
            //desaffecter doc au check
            checkDisaffectDocs,
            disaffectDocs,
            //delete dans le modal relier a la corbeil
            validateDialog,
            // pop-up delete
            dialog,
            cancelEnabled: ref(false),
            displayTrashDialog,
            //afficher nom cadre rattacher 
            recoverNameCadreAndKeyWordIdI,
            displayResultName,    
            //Pour la page AccAdmin.php
            // cadres,
            print,
            takeCadresIcones,
            QrCodePrint,
            currentIcones,
            cadreByPage,
            paginationMax,
            current,
            //********Page AjoutModif.php********/
            relieur,
            /*******cadre de travail*******/
            id,
            cadreselect,
            nouveauNom,
            description,
            diaporama,
            edition,
            idMocle,
            selectionDesci,
            selectionDiapo,
            /**fonctions */
            // miseAjourDesDonnees,
            cadresTravailOptions,
            // inserCadre,
            cadre,
            cadreDeTravail,           
            insernomCadre,
            inserDescCadre,
            insertDiapo,
            fonctIdMocle,
            insertMotcle,
            /****************/

            //tab icones
            listeMotCle,
            createIcon,
            listIcone,
            listeIconeCadre,
            nouvNom,
            urlImgIcone,
            messages,
            iconeAttacherauCadre,
            iconeCadreAttach,
            checkIcon,
            checkIconCadre,
            displayReattachIcone,
            idIconeChange,
            //pagination du tab icones
            currentMax, 
            pageMax,
            currentMaxIcones,
            /******* */
            //delete icone
            Iconedialog,
            // mot cles
            columns,  
            columnsAffected,    
            keyWords,
            test,
            MotCleLearn,
            createMotcle,
            ajouterAfficherMotCle,
            loadDataOptions,
            val: ref(true),
            //supprimer ma ligne du tab mot cle
            deleteKeyWordId,
            displayResult,
            listeNameIdMotCles,
            docNameIdMotCle,
            NameIdMotCle,
            docNameIdMotCless,
            // delete motcle de la bdd
            keyWordDeleted,
            //delete les motcle au ckeck bdd
            checkIndeleted,
            keyWordDeletedCheckIn,
            //******Pour la page accueilScan.php*****/
            text: ref(''),
            slide: ref(1),
            autoplay: ref(true),
            ph: ref(''),
            dense: ref(false),
            //Cadre de travail (options du nom de cadre)
            // optionss: [],
            cadreDeTravail: [],
            
            // modaldoc
            alert: ref(false),
            layout: ref(false),
            columnss,
            keyWordDocs,
         //supp tout les données de la page*
            deletedAll, 
            deletedAllDocs,
            deletedAllKeyWord,
            getCadre,
            getCadreSelected,
            supprimerDesDonneesCadre,
             //  detacher icone
            disaffectIcone,
            disafrefraich,
            // rowss,
            loading,
            filter,
            rowCount,
            // Ajouter une icone
            fixed: ref(false),
            text: ref(''),
            file: ref(null),
            affich,
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
            // model,
            // filterOptions,
            // createValue,

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
            }
        }
    },  
})
app.use(Quasar, { config: {} })
app.mount('#q-app')