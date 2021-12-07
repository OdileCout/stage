<?php
include_once('commun/ent_foot/entete.php');
//include_once('../controllers/AjoutModifCtrl.php');
?>
<div id="q-app" style="height: auto">
    <div class="row q-pa-md" style="padding: 20px 20px;">
        <div class="col-3 col-md-3">
            <div class="col-12 col-md-4" style="width: 70%;">
                <q-img style="min-height: 10%;" src="assets/img/logoFm.png"></q-img>
            </div>
        </div>
        <div class="col-9 col-md-9">
        </div>
    </div>
    <form action="">
        <div class="row" style="height: auto;">
            <div class="col-12 col-md-7" style="padding: 0 15px 10px 15px">
                <!------------------- cadre de travail ------------------------------>
                <div class="cadre_travail" style="padding: 0 15px 5px 15px; height: 99%">
                    <div class="">
                        <h4 class="midtitle">Cadre de travail</h4>
                    </div>
                    <div>
                        <label>Nom de Tâche:</label>
                        <div class="row">
                            <div v-if="edition" class="col">
                                <q-select v-model="cadreselect" :options="cadresTravailOptions"
                                    @update:model-value="relieur(cadreselect.value.id)"></q-select>
                            </div>
                            <div v-else class="col">
                                <q-input filled v-model="nouveauNom" @blur="insernomCadreandRefraish"
                                    label="nouveau Cadre">
                                </q-input>
                            </div>
                            <q-btn flat round :icon="(edition) ? 'edit': 'add'" @click="revenir"></q-btn>
                        </div>
                        <div class="labelDescription">
                            <label>Description:</label>
                            <div class='row'>
                                <div v-if="cadreselect && edition" class="col">
                                    <q-input v-if="selectionDesci && cadreselect" outlined square
                                        v-model="cadreselect.value.description" :dense="dense"
                                        @blur="miseAjourDesDonneesDescAndFresh(cadreselect.value.id)"></q-input>
                                </div>
                                <div v-else class="col">
                                    <q-input outlined @blur="inserdescCadreandRefraish" :dense="dense"
                                        v-model="description"></q-input>
                                </div>
                            </div>
                        </div>
                        <!--------------- diapo --------------------------->
                        <div class="row bas">
                            <div class="col-6 labelDiapo">
                                <label class="diapo">Diaporama:</label>
                                <div class="q-gutter-sm">
                                    <div class="row">
                                        <div v-if="cadreselect && edition" class="col">
                                            <q-checkbox v-if="selectionDiapo && cadreselect"
                                                v-model="cadreselect.value.diaporama"
                                                @click="miseAjourDiapoAndFresh(cadreselect.value.id)"></q-checkbox>
                                        </div>
                                        <div v-else class="col">
                                            <q-checkbox @click="inserdiapoCadreandRefraish " v-model="diaporama">
                                            </q-checkbox>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!------- icone pour generer un QRcode ------------->
                            <div class="col-6 qrcode">
                                <label class="diapo">QRcode:</label>
                                <span class="material-icons-outlined q-pa-lg">
                                    <a v-if="cadreselect" :href="`QrCodePrint.php?id=${cadreselect.value.id}`"
                                        target="_blank">
                                        <qrcode-vue v-if="edition && cadreselect"
                                            :value=`pageAffichageDoc.php?idCadre=${cadreselect.value.id}` :size="100">
                                        </qrcode-vue>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ------------------------------tableau mot cles------------------------------------- -->
            <div class="mot-cle col-12 col-md-5" style="padding: 0 15px 15px 15px">
                <div class="ligneMotCle_Cdt" style="padding: 0 15px 10px 15px">
                    <div class="">
                        <h4 class="midtitle">Mot cle</h4>
                    </div>
                    <div v-if="cadreselect && edition && (docNameIdMotCle.length !== 0)">
                        <q-table :columns="columnsAffected" :rows="docNameIdMotCle">
                            <template v-slot:body="props">
                                <q-tr :props="props">
                                    <q-td key="nom" :props="props">
                                        {{ props.row.nomMotCle }}
                                    </q-td>
                                    <q-td key="desaffected" :props="props">
                                        <q-checkbox v-model="props.row.desaffected"
                                            @click="checkIndeleted(props.row.id,cadreselect.value.id)">
                                        </q-checkbox>
                                    </q-td>
                                </q-tr>
                            </template>
                        </q-table>
                    </div>
                    <div v-else-if="cadreselect && edition && (docNameIdMotCle.length == 0)">
                        <q-table :columns="columns" :rows="keyWords">
                            <template v-slot:body="props">
                                <q-tr :props="props">
                                    <q-td key="nom" :props="props">
                                        {{ props.row.nomMotCle }}
                                    </q-td>
                                    <q-td key="affected" :props="props">
                                        <q-checkbox v-model="props.row.affected"
                                            @click="effecterMotCle(props.row.id, cadreselect.value.id)">
                                        </q-checkbox>
                                    </q-td>
                                    <q-td key="supprimer" :props="props" @click="displayTrashDialog(props.row.id)">
                                        <q-btn flat round icon="delete" color="primary">
                                        </q-btn>
                                    </q-td>
                                </q-tr>
                            </template>
                        </q-table>
                    </div>
                    <div v-else>
                        <q-table :columns="columns" :rows="keyWords">
                            <template v-slot:body="props">
                                <q-tr :props="props">
                                    <q-td key="nom" :props="props">
                                        {{ props.row.nomMotCle }}
                                    </q-td>
                                    <q-td key="affected" :props="props">
                                        <q-checkbox v-model="props.row.affected" @blur="insertMotcle"
                                            @click="fonctIdMocle(props.row.id, cadreselect.value.id)"
                                            @update:model-value="displayResult">
                                        </q-checkbox>
                                    </q-td>
                                    <q-td key="supprimer" :props="props" @click="displayTrashDialog(props.row.id)">
                                        <q-btn flat round icon="delete" color="primary">
                                        </q-btn>
                                    </q-td>
                                </q-tr>
                            </template>
                        </q-table>
                    </div>
                    <div class="btnAjoutMotcle">
                        <div class="material-icons-outlined q-pb-sm q-pr-md">
                            <q-btn color="primary" icon="add" @click="alert = true" padding="xs"
                                style="font-size: 1em;">
                            </q-btn>
                        </div>
                    </div>
                </div>
            </div>
            <!-----------------------  espace pour le modal tableau mots cles--------------- -->
            <div class="q-pa-md q-gutter-sm">
                <q-dialog v-model="alert">
                    <q-card>
                        <q-card-section>
                            <p class="text-h6">Ajouter un Mot Clé</p><br>
                        </q-card-section>
                        <q-card-section class="q-pt-none">
                            <div class="q-pa-md">
                                <div class="q-gutter-md" style="max-width: 300px">
                                    <q-input v-model="MotCleLearn" outlined label="Nouveau mot clé"></q-input>
                                </div>
                            </div>
                            <q-card-actions align="right">
                                <q-btn @click="ajouterAfficherMotCle" flat label="Enregister" color="white"
                                    class="bg-blue" v-close-popup>
                                </q-btn>
                            </q-card-actions>
                        </q-card-section>
                    </q-card>
                </q-dialog>
            </div>
        </div>
        <!-------- espace pour le modal delete mot cle --------------->
        <div class="">
            <q-dialog v-model="dialog" persistent>
                <q-card>
                    <q-card-section class="row items-center">
                        <q-avatar icon="delete_forever" color="red" text-color="white"></q-avatar>
                        <span class="q-ml-xl">Voulez-vous vraiment supprimer!</span>
                        <q-card-section class="q-pt-none">
                            <h6>Cadre de travail attacher :</h6>
                            <q-card-section v-for="displayResultNames in displayResultName">
                                <li>{{displayResultNames.nom}}</li>
                            </q-card-section align="left">
                            <q-toggle v-model="cancelEnabled" label="valider">
                            </q-toggle>
                        </q-card-section>
                    </q-card-section>
                    <!-- Notice v-close-popup -->
                    <q-card-actions align="right">
                        <q-btn flat label="Annuler" color="primary" v-close-popup></q-btn>
                        <q-btn flat label="Supprimer" @click="keyWordAllDeleted(dialog.value)" :disable="!cancelEnabled"
                            color="primary" v-close-popup="cancelEnabled"></q-btn>
                    </q-card-actions>
                </q-card>
            </q-dialog>
        </div>
        <!------------------  espace pour le tableau d'icons  ---------------------------->
        <div class="row_column" style="height: auto;">
            <div class="col-12 col-md-3 q-pa-md " style="height: auto;">
                <div class="row lesIcones col-12 col-md-2 q-pt-sm flex flex-center">
                    <div class="col-12">
                        <p class="titles ">Icônes</p>
                        <p class="text-center">{{mess}}</p>
                    </div>
                    <div class="q-pa-md col-12 col-md-12">
                        <div class="row" align="center" v-if="cadreselect && edition">
                            <div class="col-12 col-md-2 q-pt-sm q-pb-sm" v-for="icon in currentMaxIcones "
                                v-bind:class="{'selected': idIconeChange === icon.id}">
                                <p class="flex flex-center q-pb-xs ">{{icon.nom}}</p>
                                <q-img :src="urlImgIcone+icon.image"
                                    @click="changeIconAttacher(icon.id, cadreselect.value.id)" style="width:50px">
                                </q-img>

                            </div>
                        </div>
                        <div class="row" align="center" v-else>
                            <div class="col-12 col-md-2 q-pb-sm q-pb-sm " v-for="icon in currentMaxIcones"
                                v-bind:class="{'selected': idIconeChange === icon.id}">
                                <p class="flex flex-center q-pb-xs ">{{icon.nom}}</p>
                                <q-img :src="urlImgIcone+icon.image" @click="checkIcon(icon.id)" style="width:50px">
                                </q-img>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 flex flex-center">
                        <div class="col  material-icons-outlined">
                            <q-btn class="q-ma-xs" color="primary" icon="add" @click="fixed = true" padding="xs"
                                style="font-size: 1em;">
                            </q-btn>
                        </div>
                        <div class="col q-pa-lg flex flex-center">
                            <q-pagination v-model="currentMax" :max="pageMax" direction-links>
                            </q-pagination>
                        </div>
                        <div class="col  material-icons-outlined">
                            <q-btn class="q-ma-xs" color="red" icon="delete" @click="Iconedialog=true" padding="xs"
                                style="font-size: 1em;">
                            </q-btn>
                        </div>
                    </div>
                </div>
                <!------------------  espace pour le tableau document ---------------------------->
                <div class="col-12 col-md-9 q-mt-lg">
                    <div class="" v-if="cadreselect && edition && listeDocumentCadreAttach.length > 0">
                        <q-table :columns="columnsDocDesaffecter" :rows="listeDocumentCadreAttach">
                            <template v-slot:body="props">
                                <q-tr :props="props">
                                    <q-td key="Nom" :props="props">
                                        {{ props.row.nom }}
                                    </q-td>
                                    <q-td key="DuréeAffichage" :props="props">
                                        <q-input v-model="props.row.dureeAffichage"
                                            @blur="updateDureeAffichDoc(props.row.id, props.row.dureeAffichage, cadreselect.value.id)"
                                            outlined :props="props" filled :dense="dense">
                                        </q-input>
                                    </q-td>
                                    <q-td key="Date DV" :props="props">
                                        <q-input outlined v-model="props.row.dateDebut"
                                            @blur="updateDateDvDoc(props.row.id, props.row.dateDebut, cadreselect.value.id)"
                                            :props="props" filled :dense="dense">
                                        </q-input>
                                    </q-td>
                                    <q-td key="Date FV">
                                        <q-input outlined v-model="props.row.dateFin"
                                            @blur="updateDateFVDoc(props.row.id, props.row.dateFin, cadreselect.value.id)"
                                            :props="props" filled :dense="dense">
                                        </q-input>
                                    </q-td>
                                    <q-td key="raffraichir">
                                        <q-input v-model="props.row.raffraichissement"
                                            @blur="updateRaffraichDoc(props.row.id, props.row.raffraichissement, cadreselect.value.id)"
                                            :props="props" filled>
                                        </q-input>
                                    </q-td>
                                    <q-td key="Prioryte">
                                        <q-input min="0" v-model="props.row.ordreDePriorite"
                                            @blur="updateOrdrePrioriteDoc(props.row.id, props.row.ordreDePriorite, cadreselect.value.id)"
                                            :props="props"></q-input>
                                    </q-td>
                                    <q-td key="desaffected" :props="props">
                                        <q-checkbox v-model="props.row.desaffected"
                                            @click="checkDisaffectDocs(props.row.id,cadreselect.value.id)">
                                        </q-checkbox>
                                    </q-td>
                                </q-tr>
                            </template>
                        </q-table>
                    </div>
                    <div class=""
                        v-else-if="cadreselect && edition && keysDocsSelect.length > 0 && listeDocumentCadreAttach.length <= 0">
                        <q-table :columns="columnsDoc" :rows="keysDocsSelect">
                            <template v-slot:body="props">
                                <q-tr :props="props">
                                    <q-td key="Nom" :props="props">
                                        {{ props.row.nom }}
                                    </q-td>
                                    <q-td key="DuréeAffichage" :props="props">
                                        <q-input type="time" v-model="props.row.dureeAffichage" :props="props">
                                        </q-input>
                                    </q-td>
                                    <q-td key="Date DV" :props="props">
                                        <q-input filled v-model="props.row.dateDebut">
                                            <template v-slot:prepend>
                                                <q-icon name="event" class="cursor-pointer">
                                                    <q-popup-proxy cover transition-show="scale" transition-
                                                        hide="scale">
                                                        <q-date v-model="props.row.dateDebut" mask="YYYY-MM-DD HH:mm">
                                                            <div class="row items-center justify-end">
                                                                <q-btn v-close-popup label="Close" color="primary" flat>
                                                                </q-btn>
                                                            </div>
                                                        </q-date>
                                                    </q-popup-proxy>
                                                </q-icon>
                                            </template>
                                            <template v-slot:append>
                                                <q-icon name="access_time" class="cursor-pointer">
                                                    <q-popup-proxy cover transition-show="scale"
                                                        transition-hide="scale">
                                                        <q-time v-model="props.row.dateDebut" mask="YYYY-MM-DD HH:mm"
                                                            format24h>
                                                            <div class="row items-center justify-end">
                                                                <q-btn v-close-popup label="Close" color="primary" flat>
                                                                </q-btn>
                                                            </div>
                                                        </q-time>
                                                    </q-popup-proxy>
                                                </q-icon>
                                            </template>
                                        </q-input>
                                    </q-td>
                                    <q-td key="Date FV" :props="props">
                                        <q-input filled v-model="props.row.dateFin" :props="props">
                                            <template v-slot:prepend>
                                                <q-icon name="event" class="cursor-pointer">
                                                    <q-popup-proxy cover transition-show="scale" transition-
                                                        hide="scale">
                                                        <q-date v-model="props.row.dateFin" mask="YYYY-MM-DD HH:mm">
                                                            <div class="row items-center justify-end">
                                                                <q-btn v-close-popup label="Close" color="primary" flat>
                                                                </q-btn>
                                                            </div>
                                                        </q-date>
                                                    </q-popup-proxy>
                                                </q-icon>
                                            </template>
                                            <template v-slot:append>
                                                <q-icon name="access_time" class="cursor-pointer">
                                                    <q-popup-proxy cover transition-show="scale"
                                                        transition-hide="scale">
                                                        <q-time v-model="props.row.dateFin" mask="YYYY-MM-DD HH:mm"
                                                            format24h>
                                                            <div class="row items-center justify-end">
                                                                <q-btn v-close-popup label="Close" color="primary" flat>
                                                                </q-btn>
                                                            </div>
                                                        </q-time>
                                                    </q-popup-proxy>
                                                </q-icon>
                                            </template>
                                        </q-input>
                                    </q-td>

                                    <q-td key="raffraichir">
                                        <q-input type="number" min="0" v-model="props.row.raffraichissement"
                                            :props="props" :props="props">
                                        </q-input>
                                    </q-td>
                                    <q-td key="Prioryte">
                                        <q-input type="number" min="0" v-model="props.row.ordreDePriorite"
                                            :props="props" :props="props"></q-input>
                                    </q-td>
                                    <q-td key="affected" :props="props">
                                        <q-checkbox v-model="props.row.affected"
                                            @click="insertDocSurCadre(props.row.id,cadreselect.value.id,props.row.raffraichissement,
                                        props.row.ordreDePriorite,props.row.dureeAffichage,props.row.dateDebut,props.row.dateFin)">
                                        </q-checkbox>
                                    </q-td>
                                </q-tr>
                            </template>
                        </q-table>
                    </div>
                    <!--------- boutton ajouter /sauvarder /supprimer-------------------------->
                    <div>
                        <q-card-actions>
                            <div class="col-3 col-md-3">
                                <q-btn color="primary" label="Ajouter" style="font-seize:2em" @click="layout = true">
                                </q-btn>
                            </div>
                            <div class="row col-9 col-md-9 justify-end">
                                <div v-if="cadreselect && (listeDocumentCadreAttach.length !== 0)">
                                    <a :href=`pageAffichageDoc.php?idCadre=${cadreselect.value.id}` target="_blank">
                                        <q-btn class="q-ma-sm" color="white" text-color="black" label="Display" />
                                        </q-btn>
                                    </a>
                                </div>
                                <div class="row justify-end">
                                    <q-btn class="q-ma-xs" round color="red" icon="delete"
                                        @click="deleteDataAll(cadreselect.value.id)">
                                    </q-btn>
                                </div>
                            </div>
                        </q-card-actions>
                        <!---------------------------------modal Documents-------------------------------->
                        <q-dialog v-model="layout" full-width>
                            <q-layout view="Lhh lpR fff" container class="bg-white">
                                <q-header class="bg-white">
                                    <q-toolbar>
                                        <!-- <q-toolbar-title>Documents</q-toolbar-title> -->
                                        <q-btn flat v-close-popup round dense icon="close" @click="saveDoc"
                                            color="black">
                                        </q-btn>
                                    </q-toolbar>
                                </q-header>
                                <q-page-container>
                                    <q-page padding>
                                        <!-------------------- tableau modal Documents ------------------------------------>
                                        <q-table :rows="filteredDocs" :columns="columnss" :loading="loading"
                                            class="text-italic">
                                            <template v-slot:body="props">
                                                <q-tr :props="props">
                                                    <q-td key="Nom" :props="props">
                                                        <q-input outlined v-model="props.row.nom" type="text"
                                                            @blur="updateNameDoc(props.row.id, props.row.nom)"
                                                            error-message=""></q-input>
                                                    </q-td>
                                                    <q-td key="types" :props="props">
                                                        {{props.row.types}}
                                                    </q-td>
                                                    <q-td key="affecter" :props="props">
                                                        <q-checkbox v-model="props.row.affecter"
                                                            @click="addIdDoc(props.row.id)"
                                                            @update:model-value="displayResultDoc"></q-checkbox>
                                                    </q-td>
                                                    <q-td key="supprimer" :props="props">
                                                        <q-btn flat round icon="delete" color="primary"
                                                            @click="displayDocTrashDialog(props.row.id)">
                                                        </q-btn>
                                                    </q-td>
                                                    </q-td>
                                                </q-tr>
                                            </template>
                                            <!-- boutton et champ de recherche -->
                                            <template v-slot:top>
                                                <q-card-actions>
                                                    <q-btn color="primary" label=" + Document " @click="addDoc = true ">
                                                    </q-btn>
                                                </q-card-actions>
                                                <q-space></q-space>
                                                <q-input type="search " outlined color="primary" debounce="300"
                                                    v-model="searchTerm">
                                                    <template v-slot:append>
                                                        <q-icon name="search"></q-icon>
                                                    </template>
                                                </q-input>
                                            </template>
                                        </q-table>
                                    </q-page>
                                </q-page-container>
                            </q-layout>
                        </q-dialog>
                    </div>
                </div>
                <!----------------------------------- modal btn +Document ------------------------------------------->
                <q-dialog v-model="addDoc">
                    <q-layout view="Lhh lpR fff" container class="bg-white">
                        <q-header class="xl-white">
                            <q-toolbar>
                                <q-btn flat v-close-popup round dense icon="close" @click="saveDoc" color="black">
                                </q-btn>
                                <q-separator></q-separator>
                            </q-toolbar>
                        </q-header>
                        <q-page-container>
                            <q-card-section>
                                <p class="text-h6 text-center">Nouveau document <q-spinner-dots color="blue">
                                    </q-spinner-dots>
                                </p>
                            </q-card-section>
                            <q-card-section>
                                <q-input square outlined v-model="nomNouveauDoc" label="Nom"></q-input>
                            </q-card-section>
                            <q-card-section>
                                <div style="min-height:25vh;">
                                    <div>
                                        <div>
                                            <q-fab v-model="fab2" label="Choissez le type de document"
                                                vertical-actions-align="left" color="primary" icon="keyboard_arrow_down"
                                                direction="down" @click="changeValueFab = ! changeValueFab">
                                                <div class=" flex flex-row un">
                                                    <p class="row q-pa-md q-gutter-md un-un"
                                                        @click="typeDoc('documents')">
                                                        <q-btn round color="primary" icon="picture_as_pdf"></q-btn>
                                                        <input multiple filled type="file" id="UnDocument"
                                                            v-if="inputType == 'documents'">
                                                        </input>
                                                    </p>
                                                </div>
                                                <div class="flex flex-column deux">
                                                    <p class="row q-pa-md q-gutter-md deux-deux"
                                                        @click="typeDoc('video')">
                                                        <q-btn round color="brown-5" icon="video_library"></q-btn>
                                                        <input outlined type="url" v-if="inputType == 'video'"
                                                            v-model="searchVideokey"
                                                            placeholder="Entrez l'url de la vidéo"></input>
                                                    </p>
                                                </div>
                                                <div class=" flex flex-row trois">
                                                    <p class="row q-pa-md q-gutter-md trois-trois"
                                                        @click="typeDoc('image')">
                                                        <q-btn round color="black" icon="image"></q-btn>
                                                        <input multiple filled type="file" id="UneImage"
                                                            v-if="inputType == 'image'" multiple filled type="file">
                                                        </input>
                                                    </p>
                                                </div>
                                            </q-fab>
                                        </div>
                                    </div>
                                </div>
                            </q-card-section>
                            <q-page-container>
                                <q-page padding>
                                    <q-card-actions align="right">
                                        <q-btn flat label="Enregistrer" @click="insertEtAfficher" color="primary"
                                            v-close-popup>
                                        </q-btn>
                                    </q-card-actions>
                                </q-page>
                            </q-page-container>
                        </q-page-container>
                    </q-layout>
                </q-dialog>
                <!--- ----------------- Modal validation suppression documents --------------------------------- -->
                <div class="q-pa-md">
                    <q-dialog v-model="validateDialog" persistent>
                        <q-card>
                            <q-card-section class="row items-center">
                                <q-avatar icon="delete_forever" color="red" text-color="white"></q-avatar>
                                <span class="q-ml-xl">Voulez-vous vraiment supprimer!</span>
                                <q-card-section class="q-pt-none">
                                    <h6>Cadre de travail attacher :</h6>
                                    <q-card-section v-for="displayResultNameAndDocs in displayResultNameAndDoc">
                                        <li>{{displayResultNameAndDocs.nom}}</li>
                                    </q-card-section align="left">
                                    <q-toggle v-model="cancelEnabled" label="valider">
                                    </q-toggle>
                                </q-card-section>
                            </q-card-section>
                            <!-- Notice v-close-popup -->
                            <q-card-actions align="right">
                                <q-btn flat label="Annuler" color="primary" v-close-popup></q-btn>
                                <q-btn flat label="Supprimer" @click="DeleteToDeleteDocs(validateDialog.value)"
                                    :disable="!cancelEnabled" color="primary" v-close-popup="cancelEnabled">
                                </q-btn>
                            </q-card-actions>
                        </q-card>
                    </q-dialog>
                </div>
                <!---------------------- Modal du tableau icones -------------------------->
                <div class="q-pa-md">
                    <q-dialog v-model="fixed">
                        <q-card>
                            <q-card-section>
                                <p class="text-h6">Ajouter une Icône</p><br>
                                <div class="q-gutter-md" style="max-width: 300px">
                                    <q-input type="text" v-model="nouvNom" label="Nom de votre icone"></q-input>
                                    <br>
                                </div>
                                <q-separator></q-separator>
                                <div class="q-gutter-md" style="max-width: 300px">
                                    <input id="file" type="file" label="Choisissez une image"></input>
                                </div>
                            </q-card-section>
                            <q-card-actions align="right">
                                <q-btn flat label="ajouter" @click="createIconAndFresh" color="white" class="bg-blue"
                                    v-close-popup>
                                </q-btn>
                            </q-card-actions>
                            <q-separator> </q-separator>
                        </q-card>
                    </q-dialog>
                </div>
                <!------------------- Modal deleteIcones -------------------------------------------->
                <div class="q-pa-md">
                    <q-dialog v-model="Iconedialog">
                        <q-card>
                            <q-card-section>
                                <div v-if="idIconeChange">
                                    <p class="text-h6">Voulez-vous vraiment supprimer ?</p><br>
                                </div>
                                <div v-else>
                                    <p class="text-h6">Il faut selectionner pour supprimmer ?</p><br>
                                </div>
                                <div class="q-gutter-md" style="max-width: 300px">
                                </div>
                                <q-separator></q-separator>
                            </q-card-section>
                            <q-card-actions align="right">
                                <div v-if="idIconeChange" class="sepader">
                                    <div class="row q-pa-md q-gutter-sm">
                                        <q-btn flat label="Supprimer" @click="deleteRefraich" color="white"
                                            class="bg-blue" v-close-popup>
                                        </q-btn>
                                        <q-btn flat label="Annuler" color="white" class="bg-blue" v-close-popup>
                                        </q-btn>
                                    </div>
                                </div>
                                <div v-else>
                                    <q-btn flat label="retour pour selectionnner" color="white" class="bg-blue"
                                        v-close-popup>
                                    </q-btn>
                                </div>
                            </q-card-actions>
                            <q-separator> </q-separator>
                        </q-card>
                    </q-dialog>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
include_once('commun/ent_foot/footer.php');
?>