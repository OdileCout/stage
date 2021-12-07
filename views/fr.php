<?php 
  include_once('commun/ent_foot/entete.php');
?>
<div id="q-app" style="height: auto">
{{listeMotCle}}
    <div class="row q-pa-md">
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
            <!-- fatou -->
            <div class="col-12 col-md-7" style="padding: 0 15px 10px 15px">
                <div class="cadre_travail" style="padding: 0 15px 5px 15px; height: 99%">
                    <div class="">
                        <h4 class="midtitle">Cadre de travail</h4>
                    </div>
                    <!-- select pour ajouter ou selectionner un cadre de travail -->
                    <div>
                        <label>Nom de Tâche:</label>
                        <!-- <q-select outlined v-model="model" :options="optionss" label="Choisissez un cadre de travail"> -->
                        </q-select>
                        <!-- champ de text -->
                        <div class="labelDescription">
                            <label>Description:</label>
                            <q-input outlined square v-model="text" :dense="dense"></q-input>
                        </div>
                        <!-- diapo -->
                        <div class="row bas">
                            <div class="col-6 labelDiapo">
                                <label class="diapo">Diaporama:</label>
                                <q-option-group v-model="group" :options="options" color="primary" inline dense>
                                </q-option-group>
                            </div>
                            <!-- /fatou -->
                            <!-- icone pour generer un QRcode -->
                            <div class="col-6 qrcode">
                                <label class="diapo">QRcode:</label>
                                <span class="material-icons-outlined">
                                    <i class="fas fa-file-download"></i>
                                    <q-icon name="file_download" class="text-blue " style="font-size: 3em"></q-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- mot cles -->
            <div class="mot-cle col-12 col-md-5" style="padding: 0 15px 15px 15px">
                <div class="ligneMotCle_Cdt" style="padding: 0 15px 10px 15px">
                    <div class="">
                        <h4 class="midtitle">Mot cle</h4>
                    </div>
                    <!-- tableau -->
                    <div class="">
                        <q-table :rows="rows" :columns="columns" row-key="name" color="white" class="table">
                            <template v-slot:header-cell-supprimer="props">
                                <q-th :props="props">
                                    <q-icon name="delete" size="2.5em"></q-icon>
                                    {{ props.col.label }}
                                </q-th>
                            </template>
                            <template v-slot:body-cell-supprimer="props">
                                <q-td key="supprimer" :props="props">
                                    <q-icon name="check_circle_outline" size="2.5em"></q-icon>
                                </q-td>
                            </template>
                            <!-- <template v-slot:body-cell-name="props">
                                <q-td :props="props">
                                    {{tests.nom}}
                                     <q-icon name="check_circle_outline" size="2.5em"></q-icon> 
                                </q-td>
                            </template> -->
                            <template v-slot:body-cell-affecter="props">
                                <q-td key="affecter" :props="props">
                                    <q-icon name="check_circle_outline" size="2.5em"></q-icon>
                                </q-td>
                            </template>
                        </q-table>
                    </div>
                    <div class="btnAjoutMotcle">
                        <span class="material-icons-outlined bg-indigo-14">
                            <q-icon name="add" @click="alert = true" class="add-icon"
                                style="font-size: 3em; color: white; ">
                            </q-icon>
                        </span>
                    </div>
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
                                <q-input outlined v-model="text" label="Nouveau cadre"></q-input>
                            </div>
                        </div>
                        <q-card-actions align="right">
                            <q-btn flat label="Enregister" color="white" class="bg-blue" v-close-popup></q-btn>
                        </q-card-actions>
                    </q-card-section>
                </q-card>
            </q-dialog>

        </div>


        <!--  espace pour le tableau document -->
        <div class="row" style="height: auto;">
            <div class="col-12 col-md-8 q-pa-md">
                <div class="">
                    <q-table :rows=" roudocument" row-key="Nom"></q-table>
                </div>
                <!-- boutton envoyer -->
                <div class="lesBtn">
                    <q-btn color="secondary" icon-right="download" label="Télecharger doc"></q-btn>
                    <q-btn color="primary" label="Ajouter" style="font-seize:2em" @click="layout = true"></q-btn>
                    <!-- modal -->
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
                                        <q-table title="Treats" :rows="rowss" :columns="columnss" row-key="id"
                                            :filter="filter" :loading="loading">
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
                                                <q-btn color="primary" :disable="loading" label="Save" @click="addRow">
                                                </q-btn>
                                                <q-space></q-space>
                                                <q-input outlined color="primary" v-model="filter">
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

            <!-- tableau d'icons -->
            <div class="col-12 col-md-4 q-pa-md" style="height: auto;">
                <div class="row lesIcones" style="border:1px solid Black;">
                    <div class="q-pa-md col-12 col-md-10">
                        <div class="row">
                            <div class="text-blue  col-6 col-md-4">
                                <q-icon name="precision_manufacturing" style="font-size:4em;"></q-icon>
                                <!-- <q-icon name="desktop_mac"></q-icon>
                                <q-icon name="palette"></q-icon>
                                <q-icon name="delete"></q-icon>
                                <q-icon name="local_shipping"></q-icon>
                                <q-icon name="style"></q-icon> -->
                            </div>
                            <div class="text-blue  col-6 col-md-4">
                                <q-icon name="desktop_mac" style="font-size:4em;"></q-icon>
                                <!-- <q-icon name="delete"></q-icon>
                                <q-icon name="format_size"></q-icon>
                                <q-icon name="palette"></q-icon>
                                <q-icon name="today"></q-icon>
                                <q-icon name="local_shipping"></q-icon> -->
                            </div>
                            <div class="text-blue  col-6 col-md-4">
                                <q-icon name="desktop_mac" style="font-size:4em;"></q-icon>
                                <!-- <q-icon name="delete"></q-icon>
                                <q-icon name="format_size"></q-icon>
                                <q-icon name="palette"></q-icon>
                                <q-icon name="today"></q-icon>
                                <q-icon name="local_shipping"></q-icon> -->
                            </div>
                            <div class="text-blue  col-6 col-md-4">
                                <q-icon name="font_download" style="font-size:4em;"></q-icon>
                                <!-- <q-icon name="local_shipping"></q-icon>
                                <q-icon name="desktop_mac"></q-icon>
                                <q-icon name="palette"></q-icon>
                                <q-icon name="precision_manufacturing"></q-icon>
                                <q-icon name="style"></q-icon> -->
                            </div>
                            <div class="text-blue  col-6 col-md-4">
                                <q-icon name="desktop_mac" style="font-size:4em;"></q-icon>
                                <!-- <q-icon name="warning"></q-icon>
                                <q-icon name="format_size"></q-icon>
                                <q-icon name="print"></q-icon>
                                <q-icon name="today"></q-icon>
                                <q-icon name="style"></q-icon> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 droite">
                        <p class="titles">Icônes</p>
                        <span class="material-icons-outlined bg-indigo-14">
                            <q-icon name="add" @click="fixed = true" class="add-icon"
                                style="font-size: 3em; color: white; ">
                        </span>
                    </div>
                </div>
                <!-- Modal du tableau icones -->
                <div class="q-pa-md q-gutter-sm">
                    <q-dialog v-model="fixed">
                        <q-card>
                            <q-card-section>
                                <p class="text-h6">Ajouter une Icône</p><br>
                                <div class="q-gutter-md" style="max-width: 300px">
                                    <q-input v-model="text" label="Nom de votre icone"></q-input><br>
                                </div>
                                <q-separator></q-separator>
                                <div class="q-gutter-md" style="max-width: 300px">
                                    <q-input @update:model-value="val => { file = val[0] }" filled type="file" hint="">
                                    </q-input>
                                </div>
                            </q-card-section>
                            <q-card-actions align="right">
                                <q-btn flat label="ajouter" color="white" class="bg-blue" v-close-popup></q-btn>
                            </q-card-actions>
                            <q-separator> </q-separator>
                        </q-card>
                    </q-dialog>
                </div>

                <!-- bouttons enregistre -->
                <div class="row">
                    <div class="col-4 button">
                        <q-btn color="white" text-color="black" label="Display" />
                    </div>
                    <div class="col-4 button">
                        <q-btn color="white" text-color="black" label="Save" />
                    </div>
                    <div class="col-4 button">
                        <q-btn round color="red" icon="delete"></q-btn>
                    </div>
                </div>

                <div>

                    <div>
                        <q-btn label="Document 0" @click="loadDocument(0)" />
                    </div>
                    <div>
                        <q-btn label="Document 1" @click="loadDocument(1)" />
                    </div>
                    <div>
                        <q-btn label="Document 2" @click="loadDocument(2)" />
                    </div>
                    <div>
                        <q-btn label="Document 3" @click="loadDocument(3)" />
                    </div>
                    <div>
                        <q-btn label="Document 4" @click="loadDocument(4)" />
                    </div>
                    <div>
                        <q-btn label="Document sans id" @click="loadDocument()" />
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
<script src="assets/js/fr.js"></script>
</body>
</html>

