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
                <!-- cadre de travail -->
                <div class="cadre_travail" style="padding: 0 15px 5px 15px; height: 99%">
                    <div class="">
                        <h4 class="midtitle">Cadre de travail</h4>
                    </div>
                    <div>
                        <label>Nom de Tâche:</label>
                        <div class="row">
                            <div v-if="edition " class="col">
                                <q-select v-model="cadreselect" @update:model-value="relieur(cadreselect.value.id)"
                                    :options="cadresTravailOptions"></q-select>
                            </div>
                            <div v-else class="col">
                                <q-input filled v-model="nouveauNom" @blur="insernomCadreandRefraish"
                                    label="nouveau Cadre">
                                </q-input>
                            </div>
                            <q-btn flat round :icon="(edition) ? 'edit': 'add'" @click="edition = !edition && refraich">
                            </q-btn>
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
                                    <q-input outlined square @blur="inserdescCadreandRefraish" :dense="dense"
                                        v-model="description"></q-input>
                                </div>
                            </div>
                        </div>
                        <!-- diapo -->
                        <div class="row bas">
                            <div class="col-6 labelDiapo">
                                <label class="diapo">Diaporama:</label>
                                <div class="q-gutter-sm">
                                    <div class="row">
                                        <div v-if="cadreselect && edition" class="col">
                                            <q-checkbox v-if="selectionDiapo && cadreselect"
                                                v-model="cadreselect.value.diaporama"
                                                @blur="miseAjourDiapoAndFresh(cadreselect.value.id)"></q-checkbox>
                                        </div>
                                        <div v-else class="col">
                                            <q-checkbox @click="inserdiapoCadreandRefraish " v-model="diaporama">
                                            </q-checkbox>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- icone pour generer un QRcode -->
                            <div class="col-6 qrcode">
                                <label class="diapo">QRcode:</label>
                                <span class="material-icons-outlined">
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
            <!-- tableau mot cles -->
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
                                            @click="checkIndeleted(props.row.id,cadreselect.value.id)"
                                            @update:model-value="displayResult">
                                        </q-checkbox>
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
                        <span class="material-icons-outlined bg-indigo-14">
                            <q-icon name="add" @click="alert = true" class="add-icon"
                                style="font-size: 2em; color: white; ">
                            </q-icon>

                        </span>
                    </div>
                </div>
            </div>

            <!--  espace pour le modal tableau mots cles -->
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
        <!-- espace pour le modal delete mot cle -->
        <div class="q-pa-md">
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
                        <q-btn flat label="Supprimer" @click="keyWordDeleted(dialog.value)" :disable="!cancelEnabled"
                            color="primary" v-close-popup="cancelEnabled"></q-btn>
                    </q-card-actions>
                </q-card>
            </q-dialog>
        </div>
        <!--  espace pour le tableau document -->
        <div class="row" style="height: auto;">
            <div class="col-12 col-md-8 q-pa-md">
                <div class="" v-if="cadreselect && edition && (listeDocumentCadreAttach.length !== 0)">
                    <q-table :columns="columnsDocDesaffecter" :rows="listeDocumentCadreAttach">
                        <template v-slot:body="props">
                            <q-tr :props="props">
                                <q-td key="Nom" :props="props">
                                    {{ props.row.nom }}
                                </q-td>
                                <q-td key="DuréeAffichage" :props="props">
                                    <!-- {{ props.row.dureeAffichage }} -->
                                    <q-input v-model="props.row.dureeAffichage"
                                        @blur="updateDureeAffichDoc(props.row.id, props.row.dureeAffichage, cadreselect.value.id)"
                                        outlined :props="props" filled :dense="dense">
                                    </q-input>
                                </q-td>
                                <q-td key="Date DV" :props="props">
                                    <!-- {{ props.row.dateDebut}} -->
                                    <q-input outlined v-model="props.row.dateDebut"
                                        @blur="updateDateDvDoc(props.row.id, props.row.dateDebut, cadreselect.value.id)"
                                        :props="props" filled :dense="dense">
                                    </q-input>
                                </q-td>
                                <q-td key="Date FV">
                                    <!-- {{ props.row.dateFin}} -->
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
                                        @click="checkDisaffectDocs(props.row.id,cadreselect.value.id)"></q-checkbox>
                                </q-td>
                            </q-tr>
                        </template>
                    </q-table>
                </div>
                <div class=""
                    v-else-if="cadreselect && edition && (listeDocumentCadreAttach.length === 0) && keysDocsSelect">
                    <q-table :columns="columnsDoc" :rows="keysDocsSelect">
                        <template v-slot:body="props">
                            <q-tr :props="props">
                                <q-td key="Nom" :props="props">
                                    {{ props.row.nom }}
                                </q-td>
                                <q-td key="DuréeAffichage" :props="props">
                                    <!-- {{ props.row.dureeAffichage }} -->
                                    <q-input type="time" v-model="props.row.dureeAffichage" :props="props"
                                        :props="props">
                                    </q-input>
                                </q-td>
                                <q-td key="Date DV" :props="props">
                                    <!-- {{ props.row.dateDebut}} -->
                                    <q-input type="date" v-model="props.row.dateDebut" :props="props" :props="props">
                                    </q-input>
                                </q-td>
                                <q-td key="Date FV" :props="props">
                                    <!-- {{ props.row.dateFin}} -->
                                    <q-input type="date" v-model="props.row.dateFin" :props="props" :props="props">
                                    </q-input>
                                </q-td>
                                <q-td key="raffraichir">
                                    <q-input type="number" min="0" v-model="props.row.raffraichissement" :props="props"
                                        :props="props">
                                    </q-input>
                                </q-td>
                                <q-td key="Prioryte">
                                    <q-input type="number" min="0" v-model="props.row.ordreDePriorite" :props="props"
                                        :props="props"></q-input>
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
                <div class="" v-else-if="keysDocsSelect">
                    <!-- <q-table :columns="columnsDoc" :rows="keysDocsSelect">
                        <template v-slot:body="props">
                            <q-tr :props="props">
                                <q-td key="Nom" :props="props">
                                    {{ props.row.nom }}
                                </q-td>
                                <q-td key="DuréeAffichage" :props="props">
                                    {{ props.row.dureeAffichage }}
                                </q-td>
                                <q-td key="Date DV" :props="props">
                                    {{ props.row.dateDebut}}
                                </q-td>
                                <q-td key="Date FV" :props="props">
                                    {{ props.row.dateFin}}
                                </q-td>
                                <q-td key="raffraichir">
                                    <q-input v-model="props.row.raffraichissement" :props="props" filled type="number">
                                    </q-input>
                                </q-td>
                                <q-td key="Prioryte">
                                    <q-input type="number" min="0" v-model="props.row.ordreDePriorite" :props="props"
                                        :props="props"></q-input>
                                </q-td>
                                <q-td key="affecterDoc" :props="props">
                                    <q-checkbox v-model="props.row.affecterDoc"
                                        @click="checkDoc(props.row.id,props.row.raffraichissement,props.row.ordreDePriorite)"
                                        @blur="insertDocumentation" @update:model-value="displayResultDoc"></q-checkbox>
                                </q-td>
                            </q-tr>
                        </template>
                    </q-table> -->
                </div>
                <div v-else>
                </div>
                <!-- boutton envoyer -->
                <div>
                    <q-card-actions>
                        <q-btn color="primary" label="Ajouter" style="font-seize:2em" @click="layout = true"></q-btn>
                    </q-card-actions>
                    <!-- modal -->
                    <q-dialog v-model="layout" full-width>
                        <q-layout view="Lhh lpR fff" container class="bg-white">
                            <q-header class="bg-white">
                                <q-toolbar>
                                    <!-- <q-toolbar-title>Documents</q-toolbar-title> -->
                                    <q-btn flat v-close-popup round dense icon="close" @click="saveDoc" color="black">
                                    </q-btn>
                                </q-toolbar>
                            </q-header>
                            <q-page-container>
                                <q-page padding>
                                    <!-- tableau modal -->
                                    <q-table :rows="filteredDocs" :columns="columnss" :loading="loading"
                                        class="text-italic">
                                        <template v-slot:body="props">
                                            <q-tr :props="props">
                                                <q-td key="Nom" :props="props">
                                                    <!-- <div v-if="props.row.nom"> -->
                                                    <!-- {{props.row.nom}}
                                                    </div>
                                                    <div v-else> -->
                                                    <q-input outlined v-model="props.row.nom" type="text"
                                                        @blur="updateNameDoc(props.row.id, props.row.nom)"
                                                        error-message=""></q-input>
                                                    <!-- </div> -->
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
            <!-- modal btn +Document -->
            <q-dialog v-model="addDoc">
                <q-layout view="Lhh lpR fff" container class="bg-white">
                    <q-header class="xl-white">
                        <q-toolbar>
                            <!-- <q-toolbar-title>Documents</q-toolbar-title> -->
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
                        <q-page padding>
                            <q-card-section>
                                <q-input square outlined v-model="nomNouveauDoc" label="Nom"></q-input>
                            </q-card-section>
                            <q-card-section>
                                <input id="UnDocument" multiple filled type="file" hint=""></input>
                            </q-card-section>
                            <div style="min-height: 100vh;">
                                <div>
                                    <div>
                                        <div class="flex flex-column">
                                            <p class="row q-pa-md q-gutter-md" v-on:click="searchInput('name')">
                                                <q-btn round color="secondary" icon="picture_as_pdf"></q-btn>
                                                <input multiple filled type="file" v-if="inputType == 'name'"
                                                    v-model="searchkey">
                                                </input>
                                            </p>
                                        </div>
                                        <div class="flex flex-column">
                                            <p class="row q-pa-md q-gutter-md" v-on:click="searchTextInput('text')">
                                                <q-btn round color="primary" icon="description"></q-btn>
                                                <input multiple filled type="file" v-if="inputType == 'text'"
                                                    v-model="searchtextkey"></input>
                                            </p>
                                        </div>

                                        <div class="flex flex-column">
                                            <p class="row q-pa-md q-gutter-md" v-on:click="searchVideoInput('video')">
                                                <q-btn round color="brown-5" icon="video_library"></q-btn>
                                                <input type="url" v-if="inputType == 'video'"
                                                    v-model="searchVideokey" :dense="dense" style="width:300%"></input>
                                            </p>
                                        </div>
                                        <div class="flex flex-column">
                                            <p class="row q-pa-md q-gutter-md" v-on:click="searchImageInput('image')">
                                                <q-btn round color="black" icon="image"></q-btn>
                                                <input multiple filled type="file" v-if="inputType == 'image'" multiple
                                                    filled type="file" v-model="searchImagekey"></input>
                                            </p>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- <q-card-section>
                                <q-input v-model="dureeAffichageDoc" filled type="number"
                                    hint="Durée Affichage (minutes)">
                                </q-input>
                            </q-card-section> -->
                                <!-- <q-card-section>
                                <q-input v-model="dateDebutDeValiditeDoc" filled type="date"
                                    hint="Date début de validité">
                                </q-input>
                                <q-input v-model="HeureDebutDeValiditeDoc" filled type="time"
                                    hint="heure début de validité">
                                </q-input>
                            </q-card-section>
                            <q-card-section>
                                <q-input v-model="dateDeFinValiditeDoc" filled type="date" hint="Date fin de validité">
                                </q-input>
                                <q-input v-model="heureDeFinValiditeDoc" filled type="time" hint="Date fin de validité">
                                </q-input>
                            </q-card-section> -->
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

            <!-- tableau d'icons -->
            <div class="col-12 col-md-4 q-pa-md" style="height: auto;">
                <div class="row lesIcones" style="border:1px solid Black;">
                    <p style="color:red; text-align: center">
                    </p>
                    <div class="q-pa-md col-12 col-md-10">
                        <div class="row" v-if="cadreselect && edition">
                            <div class="text-blue  col-6 col-md-4" v-for="icon in currentMaxIcones "
                                v-bind:class="{'selected': idIconeChange === icon.id}">
                                <p>{{icon.nom}}</p>
                                <q-img :src="urlImgIcone+icon.image"
                                    @click="changeIconAttacher(icon.id, cadreselect.value.id)" style="width: 50%">
                                </q-img>
                            </div>
                        </div>
                        <!--v-else-if="!cadreselect && edition && refraich"-->
                        <div class="row" v-else>
                            <div class="text-blue  col-6 col-md-4" v-for="icon in currentMaxIcones"
                                v-bind:class="{'selected': idIconeChange === icon.id}">
                                <p>{{icon.nom}}</p>
                                <q-img :src="urlImgIcone+icon.image" @click="checkIcon(icon.id)" style="width: 50%">
                                </q-img>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 droite">
                        <p class="titles">Icônes</p>

                        <span class="material-icons-outlined bg-indigo-14">
                            <q-icon name="add " @click="fixed = true" class="add-icon"
                                style="font-size: 2em; color: white; ">
                        </span>
                        <span class="material-icons-outlined">
                            <q-btn color="red" icon="delete" @click="Iconedialog=true" padding="xs"
                                style="font-size: 1em;">
                            </q-btn>
                        </span>

                    </div>
                    <div class="q-pa-lg flex flex-center">
                        <q-pagination v-model="currentMax" :max="pageMax" direction-links>
                        </q-pagination>
                    </div>
                </div>
                <!-- --- Modal validation suppression documents ---- -->
                <div class="q-pa-md">
                    <q-dialog v-model="validateDialog">
                        <q-card>
                            <q-card-section>
                                <p class="text-h6">Voulez-vous vraiment supprimer!</p><br>
                                <q-separator></q-separator>
                            </q-card-section>
                            <q-card-actions align="right">
                                <q-btn flat label="supprimer" @click="DeletedDocs(validateDialog.value)" color="white"
                                    class="bg-blue" v-close-popup>
                                </q-btn>
                            </q-card-actions>
                            <q-separator> </q-separator>
                        </q-card>
                    </q-dialog>
                </div>
                <!-- Modal du tableau icones -->
                <div class="q-pa-md">
                    <q-dialog v-model="fixed">
                        <q-card>
                            <q-card-section>
                                <p class="text-h6">Ajouter une Icône</p><br>
                                <div class="q-gutter-md" style="max-width: 300px">
                                    <q-input type="text" v-model="nouvNom" label="Nom de votre icone"></q-input><br>
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
                <!----- Modal deleteIcones ------>
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
                <!------ bouttons enregistre ------->
                <div class="row q-gutter-none justify-end">
                    <div v-if="cadreselect && (listeDocumentCadreAttach.length !== 0)">
                        <a :href=`pageAffichageDoc.php?idCadre=${cadreselect.value.id}` target="_blank">
                            <q-btn class="q-ma-sm" color="white" text-color="black" label="Display" />
                            </q-btn>
                        </a>
                    </div>
                    <div class="col-1 button ">
                        <q-btn round color="red" icon="delete" @click="deleteDataAll(cadreselect.value.id)">
                        </q-btn>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="/COMMUN/framework-css-js/vue.js/3.2.13/vue.global.js"></script>
<script src="/COMMUN/framework-css-js/quasar/2.1.0/quasar.umd.js"></script>
<script src="/COMMUN/framework-css-js/qrcode-vue/3.3.2/qrcode.vue.browser.min.js"></script>
<script src="/COMMUN/framework-css-js/axios/axios.min.js"></script>
<script src="assets/js/scriptfatou.js"></script>
</body>

</html>